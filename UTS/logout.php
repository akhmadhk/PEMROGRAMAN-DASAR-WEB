<?php
require_once 'config.php';

// Hapus semua session
$_SESSION = [];

// Hapus session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy session
session_destroy();

// Redirect ke index
header('Location: index.php');
exit;
?>