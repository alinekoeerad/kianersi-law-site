<?php
require_once __DIR__ . '/config.php';

header('Content-Type: application/json; charset=utf-8');

// Parse JSON input
$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
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
        'username' => $_SESSION['admin_username'] ?? ''
    ]);
}

// 2. Login
if ($action === 'login') {
    $username = trim($input['username'] ?? '');
    $password = $input['password'] ?? '';

    $auth = get_auth_config();
    if ($username === $auth['username'] && password_verify($password, $auth['password_hash'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        json_out(['success' => true, 'message' => 'ورود با موفقیت انجام شد.']);
    } else {
        json_out(['success' => false, 'error' => 'نام کاربری یا رمز عبور اشتباه است.'], 401);
    }
}

// 3. Logout
if ($action === 'logout') {
    $_SESSION = [];
    if (session_id()) {
        session_destroy();
    }
    json_out(['success' => true]);
}

// ─── Protected Routes (Requires Auth) ───────────────────────────
if (!is_authenticated()) {
    json_out(['success' => false, 'error' => 'لطفاً ابتدا وارد سیستم شوید.'], 403);
}

// Read site data file
function read_site_data() {
    $file = get_data_filepath();
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $data = json_decode($content, true);
        if ($data) return $data;
    }
    return ['general' => [], 'laws' => []];
}

// Save site data file
function write_site_data($data) {
    $file = get_data_filepath();
    return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

// 4. Get Data
if ($action === 'get_data') {
    $data = read_site_data();
    json_out(['success' => true, 'data' => $data]);
}

// 5. Save General Settings
if ($action === 'save_general') {
    $general = $input['general'] ?? null;
    if (!$general || !is_array($general)) {
        json_out(['success' => false, 'error' => 'اطلاعات ارسالی نامعتبر است.'], 400);
    }

    $siteData = read_site_data();
    $siteData['general'] = array_merge($siteData['general'] ?? [], $general);
    
    if (write_site_data($siteData)) {
        json_out(['success' => true, 'message' => 'تنظیمات عمومی با موفقیت ذخیره شد.']);
    } else {
        json_out(['success' => false, 'error' => 'خطا در ذخیره فایل اطلاعات سایت.'], 500);
    }
}

// 6. Save Single Law (Add or Edit)
if ($action === 'save_law') {
    $law = $input['law'] ?? null;
    if (!$law || !isset($law['title'], $law['content'])) {
        json_out(['success' => false, 'error' => 'عنوان و متن قانون الزامی است.'], 400);
    }

    $siteData = read_site_data();
    $laws = $siteData['laws'] ?? [];
    
    $lawId = isset($law['id']) && (int)$law['id'] > 0 ? (int)$law['id'] : null;

    if ($lawId) {
        // Edit existing
        $found = false;
        foreach ($laws as &$l) {
            if ((int)$l['id'] === $lawId) {
                $l['title'] = trim($law['title']);
                $l['content'] = $law['content'];
                $found = true;
                break;
            }
        }
        if (!$found) {
            $laws[] = [
                'id' => $lawId,
                'title' => trim($law['title']),
                'content' => $law['content']
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
            'title' => trim($law['title']),
            'content' => $law['content']
        ];
    }

    $siteData['laws'] = $laws;
    if (write_site_data($siteData)) {
        json_out(['success' => true, 'message' => 'قانون با موفقیت ذخیره شد.', 'laws' => $laws]);
    } else {
        json_out(['success' => false, 'error' => 'خطا در ذخیره‌سازی قانون.'], 500);
    }
}

// 7. Delete Law
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

// 8. Change Password
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
        json_out(['success' => true, 'message' => 'رمز عبور با موفقیت به‌روزرسانی شد.']);
    } else {
        json_out(['success' => false, 'error' => 'خطا در ذخیره رمز عبور جدید.'], 500);
    }
}

json_out(['success' => false, 'error' => 'عملیات نامعتبر است.'], 400);

