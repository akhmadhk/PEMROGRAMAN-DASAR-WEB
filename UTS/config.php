<?php
// Mulai session
session_start();

// Konfigurasi Database (Opsional - jika ingin pakai database)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'upload_system');

// Konfigurasi Upload
define('UPLOAD_DIR', 'uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('ALLOWED_EXT', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Data User (Hardcoded - bisa diganti dengan database)
$users = [
    'admin' => [
        'password' => password_hash('admin123', PASSWORD_DEFAULT),
        'role' => 'admin'
    ],
    'member' => [
        'password' => password_hash('member123', PASSWORD_DEFAULT),
        'role' => 'member'
    ]
];

// Fungsi helper
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function getUserRole() {
    return $_SESSION['role'] ?? null;
}

function getUsername() {
    return $_SESSION['username'] ?? null;
}

// Buat folder uploads jika belum ada
if (!file_exists(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

// Fungsi sanitasi input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Fungsi generate response JSON
function jsonResponse($success, $message = '', $data = []) {
    header('Content-Type: application/json');
    echo json_encode(array_merge([
        'success' => $success,
        'message' => $message
    ], $data));
    exit;
}
?>