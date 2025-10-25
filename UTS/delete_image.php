<?php
require_once 'config.php';

// Cek apakah user sudah login
if (!isLoggedIn()) {
    jsonResponse(false, 'Unauthorized - Silakan login terlebih dahulu');
}

// Cek apakah user adalah admin
if (!isAdmin()) {
    jsonResponse(false, 'Access denied - Hanya admin yang dapat menghapus gambar');
}

header('Content-Type: application/json');

$imagesDataFile = UPLOAD_DIR . 'images_data.json';

// Cek apakah filename ada
if (!isset($_POST['filename'])) {
    jsonResponse(false, 'Filename tidak ditemukan');
}

$filename = sanitize($_POST['filename']);

// Validasi filename untuk keamanan
if (strpos($filename, '..') !== false || strpos($filename, '/') !== false) {
    jsonResponse(false, 'Filename tidak valid');
}

$filePath = UPLOAD_DIR . $filename;

// Hapus file fisik
if (file_exists($filePath)) {
    if (unlink($filePath)) {
        // Update data JSON
        if (file_exists($imagesDataFile)) {
            $imagesData = json_decode(file_get_contents($imagesDataFile), true);
            
            if (is_array($imagesData)) {
                // Filter data untuk menghapus entry yang sesuai
                $imagesData = array_filter($imagesData, function($image) use ($filename) {
                    return $image['filename'] !== $filename;
                });
                
                // Reindex array
                $imagesData = array_values($imagesData);
                
                // Simpan kembali ke file JSON
                file_put_contents($imagesDataFile, json_encode($imagesData, JSON_PRETTY_PRINT));
            }
        }
        
        jsonResponse(true, 'Gambar berhasil dihapus');
    } else {
        jsonResponse(false, 'Gagal menghapus file');
    }
} else {
    jsonResponse(false, 'File tidak ditemukan');
}
?>