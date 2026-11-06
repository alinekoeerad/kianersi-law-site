<?php
require_once __DIR__ . '/config.php';

header('Content-Type: application/json; charset=utf-8');

// Parse JSON input
$raw_input = file_get_contents('php://input');
$input = json_decode($raw_input, true) ?? $_POST;
$action = $_GET['action'] ?? $input['action'] ?? '';

// Helper response
function json_out($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// 1. Check Auth Status
if ($action === 'check_auth') {
    json_out([
        'authenticated' => is_authenticated(),
        'username' => $_SESSION['admin_username'] ?? '',
        'csrf_token' => get_csrf_token()
    ]);
}

// 2. Track Analytics Event (Public, Non-Blocking, Ultra-Lightweight)
if ($action === 'track_event') {
    $event = $input['event'] ?? '';
    $allowed = ['page_view', 'phone', 'instagram', 'eitaa', 'bale', 'rubika', 'maps'];
    if (!in_array($event, $allowed)) {
        json_out(['success' => false], 400);
    }

    $analytics_file = __DIR__ . '/analytics.json';
    $data = file_exists($analytics_file) ? (json_decode(@file_get_contents($analytics_file), true) ?? []) : [];
    
    $default_data = [
        'views' => 0,
        'phone' => 0,
        'instagram' => 0,
        'eitaa' => 0,
        'bale' => 0,
        'rubika' => 0,
        'maps' => 0,
        'last_updated' => date('Y-m-d H:i:s')
    ];
    $data = array_merge($default_data, $data);

    if ($event === 'page_view') {
        $data['views']++;
    } else {
        $data[$event]++;
    }
    $data['last_updated'] = date('Y-m-d H:i:s');

    @file_put_contents($analytics_file, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
    json_out(['success' => true]);
}

// 3. Login (with Anti-Brute-Force Protection)
if ($action === 'login') {
    // Check if IP is currently locked due to too many failed attempts
    $bf = check_brute_force_status();
    if (!$bf['allowed']) {
        json_out(['success' => false, 'error' => $bf['error']], 429);
    }

    $username = trim($input['username'] ?? '');
    $password = $input['password'] ?? '';

    $auth = get_auth_config();
    if ($username === $auth['username'] && password_verify($password, $auth['password_hash'])) {
        // Success: Reset failed attempts & regenerate session ID (anti-fixation)
        reset_failed_logins();
        session_regenerate_id(true);

        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        $_SESSION['last_activity'] = time();

        json_out([
            'success' => true,
            'message' => 'ورود با موفقیت انجام شد.',
            'csrf_token' => get_csrf_token()
        ]);
    } else {
        // Failed attempt: Record failure
        record_failed_login();
        json_out(['success' => false, 'error' => 'نام کاربری یا رمز عبور اشتباه است.'], 401);
    }
}

// 4. Logout
if ($action === 'logout') {
    $_SESSION = [];
    if (session_id()) {
        session_destroy();
    }
    json_out(['success' => true]);
}

// ─── Protected Routes (Requires Authentication) ───────────────────
if (!is_authenticated()) {
    json_out(['success' => false, 'error' => 'لطفاً ابتدا وارد سیستم شوید.'], 403);
}

// ─── CSRF Verification for State-Changing POST Requests ───────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $input['csrf_token'] ?? '';
    if (!verify_csrf_token($client_token)) {
        json_out(['success' => false, 'error' => 'خطای امنیتی: نشست یا توکن امنیتی (CSRF) نامعتبر است. لطفاً صفحه را بازنشانی کنید.'], 403);
    }
}

// Read site data file
function read_site_data() {
    $file = get_data_filepath();
    if (file_exists($file)) {
        $content = @file_get_contents($file);
        $data = json_decode($content, true);
        if ($data) return $data;
    }
    return ['general' => [], 'laws' => []];
}

// Save site data file with Atomic Lock & Automatic Backup
function write_site_data($data) {
    $file = get_data_filepath();
    $backup_file = dirname($file) . '/site-data-backup.json';

    // Auto-backup before saving
    if (file_exists($file)) {
        @copy($file, $backup_file);
    }

    return @file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX) !== false;
}

// 5. Get Data
if ($action === 'get_data') {
    $data = read_site_data();
    json_out(['success' => true, 'data' => $data, 'csrf_token' => get_csrf_token()]);
}

// 6. Get Analytics Data
if ($action === 'get_analytics') {
    $analytics_file = __DIR__ . '/analytics.json';
    $data = file_exists($analytics_file) ? (json_decode(@file_get_contents($analytics_file), true) ?? []) : [];
    $default_data = [
        'views' => 0,
        'phone' => 0,
        'instagram' => 0,
        'eitaa' => 0,
        'bale' => 0,
        'rubika' => 0,
        'maps' => 0,
        'last_updated' => '-'
    ];
    json_out(['success' => true, 'analytics' => array_merge($default_data, $data)]);
}

// 7. Reset Analytics Data
if ($action === 'reset_analytics') {
    $analytics_file = __DIR__ . '/analytics.json';
    $default_data = [
        'views' => 0,
        'phone' => 0,
        'instagram' => 0,
        'eitaa' => 0,
        'bale' => 0,
        'rubika' => 0,
        'maps' => 0,
        'last_updated' => date('Y-m-d H:i:s')
    ];
    @file_put_contents($analytics_file, json_encode($default_data, JSON_PRETTY_PRINT), LOCK_EX);
    json_out(['success' => true, 'message' => 'آمار بازدید و کلیک‌ها با موفقیت بازنشانی شد.', 'analytics' => $default_data]);
}

// 8. Download Backup File
if ($action === 'download_backup') {
    $file = get_data_filepath();
    if (!file_exists($file)) {
        json_out(['success' => false, 'error' => 'فایل اطلاعات جهت پشتیبان‌گیری یافت نشد.'], 404);
    }
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename="kianersi-backup-' . date('Y-m-d') . '.json"');
    header('Pragma: no-cache');
    header('Expires: 0');
    readfile($file);
    exit;
}

// 9. Save General Settings
if ($action === 'save_general') {
    $general = $input['general'] ?? null;
    if (!$general || !is_array($general)) {
        json_out(['success' => false, 'error' => 'اطلاعات ارسالی نامعتبر است.'], 400);
    }

    // Sanitize string inputs
    $sanitized = [];
    foreach ($general as $k => $v) {
        $sanitized[$k] = is_string($v) ? trim($v) : $v;
    }

    $siteData = read_site_data();
    $siteData['general'] = array_merge($siteData['general'] ?? [], $sanitized);
    
    if (write_site_data($siteData)) {
        json_out(['success' => true, 'message' => 'تنظیمات عمومی با موفقیت ذخیره شد.']);
    } else {
        json_out(['success' => false, 'error' => 'خطا در ذخیره فایل اطلاعات سایت.'], 500);
    }
}

// 10. Save Single Law (Add or Edit) - Including Category
if ($action === 'save_law') {
    $law = $input['law'] ?? null;
    if (!$law || !isset($law['title'], $law['content'])) {
        json_out(['success' => false, 'error' => 'عنوان و متن قانون الزامی است.'], 400);
    }

    $title = trim($law['title']);
    $content = trim($law['content']);
    $valid_categories = ['wells', 'rivers', 'lands'];
    $category = in_array($law['category'] ?? '', $valid_categories) ? $law['category'] : 'wells';

    if (empty($title) || empty($content)) {
        json_out(['success' => false, 'error' => 'عنوان یا متن قانون نمی‌تواند خالی باشد.'], 400);
    }

    $siteData = read_site_data();
    $laws = $siteData['laws'] ?? [];
    
    $lawId = isset($law['id']) && (int)$law['id'] > 0 ? (int)$law['id'] : null;

    if ($lawId) {
        // Edit existing
        $found = false;
        foreach ($laws as &$l) {
            if ((int)$l['id'] === $lawId) {
                $l['title'] = $title;
                $l['category'] = $category;
                $l['content'] = $content;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $laws[] = [
                'id' => $lawId,
                'title' => $title,
                'category' => $category,
                'content' => $content
            ];
        }
    } else {
        // Create new ID (max id + 1)
        $maxId = 0;
        foreach ($laws as $l) {
            if ((int)$l['id'] > $maxId) $maxId = (int)$l['id'];
        }
        $newId = $maxId + 1;
        $laws[] = [
            'id' => $newId,
            'title' => $title,
            'category' => $category,
            'content' => $content
        ];
    }

    $siteData['laws'] = $laws;
    if (write_site_data($siteData)) {
        json_out(['success' => true, 'message' => 'قانون با موفقیت ذخیره شد.', 'laws' => $laws]);
    } else {
        json_out(['success' => false, 'error' => 'خطا در ذخیره‌سازی قانون.'], 500);
    }
}

// 11. Delete Law
if ($action === 'delete_law') {
    $lawId = (int)($input['id'] ?? 0);
    if ($lawId <= 0) {
        json_out(['success' => false, 'error' => 'شناسه قانون نامعتبر است.'], 400);
    }

    $siteData = read_site_data();
    $laws = $siteData['laws'] ?? [];
    $filtered = array_values(array_filter($laws, function($l) use ($lawId) {
        return (int)$l['id'] !== $lawId;
    }));

    $siteData['laws'] = $filtered;
    if (write_site_data($siteData)) {
        json_out(['success' => true, 'message' => 'قانون مورد نظر با موفقیت حذف گردید.', 'laws' => $filtered]);
    } else {
        json_out(['success' => false, 'error' => 'خطا در ذخیره‌سازی تغییرات.'], 500);
    }
}

// 12. Change Password
if ($action === 'change_password') {
    $current_pass = $input['current_password'] ?? '';
    $new_pass = $input['new_password'] ?? '';

    if (empty($new_pass) || strlen($new_pass) < 6) {
        json_out(['success' => false, 'error' => 'رمز عبور جدید باید حداقل ۶ کاراکتر باشد.'], 400);
    }

    $auth = get_auth_config();
    if (!password_verify($current_pass, $auth['password_hash'])) {
        json_out(['success' => false, 'error' => 'رمز عبور فعلی نادرست است.'], 400);
    }

    if (save_auth_config($auth['username'], $new_pass)) {
        session_regenerate_id(true);
        json_out(['success' => true, 'message' => 'رمز عبور با موفقیت به‌روزرسانی شد.']);
    } else {
        json_out(['success' => false, 'error' => 'خطا در ذخیره رمز عبور جدید.'], 500);
    }
}

json_out(['success' => false, 'error' => 'عملیات نامعتبر است.'], 400);
