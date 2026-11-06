<?php
// Admin Configuration & Authentication
if (!defined('CMS_ROOT')) {
    define('CMS_ROOT', dirname(__DIR__));
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$config_file = __DIR__ . '/config.json';

function get_auth_config() {
    global $config_file;
    if (file_exists($config_file)) {
        $data = json_decode(file_get_contents($config_file), true);
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
    return file_put_contents($config_file, json_encode($new_config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

function is_authenticated() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function get_data_filepath() {
    return dirname(__DIR__) . '/site-data.json';
}

