<?php
require_once 'config.php';

// Hanya terima POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed');
}

// Ambil data dari POST
$username = sanitize($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$role = sanitize($_POST['role'] ?? '');
$remember = isset($_POST['remember']) && $_POST['remember'] === 'true';

// Validasi input
if (empty($username)) {
    jsonResponse(false, 'Username tidak boleh kosong');
}

if (strlen($username) < 3) {
    jsonResponse(false, 'Username minimal 3 karakter');
}

if (empty($password)) {
    jsonResponse(false, 'Password tidak boleh kosong');
}

if (strlen($password) < 6) {
    jsonResponse(false, 'Password minimal 6 karakter');
}

if (empty($role)) {
    jsonResponse(false, 'Role harus dipilih');
}

// Cek kredensial user
if (!isset($users[$username])) {
    jsonResponse(false, 'Username tidak ditemukan');
}

if (!password_verify($password, $users[$username]['password'])) {
    jsonResponse(false, 'Password salah');
}

if ($users[$username]['role'] !== $role) {
    jsonResponse(false, 'Role tidak sesuai');
}

// Login berhasil - Set session
$_SESSION['logged_in'] = true;
$_SESSION['username'] = $username;
$_SESSION['role'] = $role;
$_SESSION['login_time'] = time();

// Set cookie jika remember me dicentang
if ($remember) {
    $expire = time() + (7 * 24 * 60 * 60); // 7 hari
    setcookie('remembered_user', $username, $expire, '/');
    setcookie('remembered_role', $role, $expire, '/');
    setcookie('remember_checked', 'true', $expire, '/');
} else {
    // Hapus cookie jika ada
    setcookie('remembered_user', '', time() - 3600, '/');
    setcookie('remembered_role', '', time() - 3600, '/');
    setcookie('remember_checked', '', time() - 3600, '/');
}

jsonResponse(true, 'Login berhasil', [
    'username' => $username,
    'role' => $role
]);
?>