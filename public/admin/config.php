<?php
// Admin Configuration, Authentication & Security Engine
if (!defined('CMS_ROOT')) {
    define('CMS_ROOT', dirname(__DIR__));
}

// ─── 1. Security Headers ──────────────────────────────────────────
if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}

// ─── 2. Hardened Session Settings ─────────────────────────────────
ini_set('session.use_only_cookies', 1);
ini_set('session.use_trans_sid', 0);

$is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
            (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) ||
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0, // Session ends when browser closes
        'path' => '/admin/',
        'secure' => $is_https,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
}

// ─── 3. Session Inactivity Timeout (2 Hours) ──────────────────────
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 7200)) {
    session_unset();
    session_destroy();
}
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    $_SESSION['last_activity'] = time();
}

$config_file = __DIR__ . '/config.json';
$attempts_file = __DIR__ . '/login_attempts.json';

// ─── 4. CSRF Token Engine ─────────────────────────────────────────
function get_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

// ─── 5. Anti Brute-Force Rate Limiting (5 attempts / 15 mins) ─────
function get_client_ip() {
    return $_SERVER['HTTP_CF_CONNECTING_IP'] ?? 
           $_SERVER['HTTP_X_FORWARDED_FOR'] ?? 
           $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
}

function check_brute_force_status() {
    global $attempts_file;
    $ip = get_client_ip();
    if (!file_exists($attempts_file)) return ['allowed' => true];

    $data = json_decode(@file_get_contents($attempts_file), true) ?? [];
    if (!isset($data[$ip])) return ['allowed' => true];

    $record = $data[$ip];
    $window = 15 * 60; // 15 minutes
    $now = time();

    // Check if currently locked
    if (isset($record['locked_until']) && $record['locked_until'] > $now) {
        $remaining = ceil(($record['locked_until'] - $now) / 60);
        return [
            'allowed' => false,
            'error' => "تعداد تلاش‌های ناموفق بیش از حد مجاز است. لطفاً {$remaining} دقیقه دیگر امتحان کنید."
        ];
    }

    return ['allowed' => true];
}

function record_failed_login() {
    global $attempts_file;
    $ip = get_client_ip();
    $data = file_exists($attempts_file) ? (json_decode(@file_get_contents($attempts_file), true) ?? []) : [];
    
    $now = time();
    $window = 15 * 60;

    if (!isset($data[$ip])) {
        $data[$ip] = ['attempts' => 1, 'first_attempt' => $now];
    } else {
        // Reset if window passed
        if ($now - $data[$ip]['first_attempt'] > $window) {
            $data[$ip] = ['attempts' => 1, 'first_attempt' => $now];
        } else {
            $data[$ip]['attempts']++;
            if ($data[$ip]['attempts'] >= 5) {
                $data[$ip]['locked_until'] = $now + (15 * 60); // Lock for 15 minutes
            }
        }
    }

    @file_put_contents($attempts_file, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
}

function reset_failed_logins() {
    global $attempts_file;
    $ip = get_client_ip();
    if (file_exists($attempts_file)) {
        $data = json_decode(@file_get_contents($attempts_file), true) ?? [];
        if (isset($data[$ip])) {
            unset($data[$ip]);
            @file_put_contents($attempts_file, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
        }
    }
}

// ─── 6. Authentication Config ─────────────────────────────────────
function get_auth_config() {
    global $config_file;
    if (file_exists($config_file)) {
        $data = json_decode(@file_get_contents($config_file), true);
        if ($data && isset($data['username'], $data['password_hash'])) {
            return $data;
        }
    }
    // Default fallback credentials
    return [
        'username' => 'admin',
        'password_hash' => password_hash('Kianersi@1403', PASSWORD_BCRYPT)
    ];
}

function save_auth_config($username, $new_password) {
    global $config_file;
    $new_config = [
        'username' => $username,
        'password_hash' => password_hash($new_password, PASSWORD_BCRYPT),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return @file_put_contents($config_file, json_encode($new_config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX) !== false;
}

function is_authenticated() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function get_data_filepath() {
    return dirname(__DIR__) . '/site-data.json';
}
