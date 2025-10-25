<?php
require_once 'config.php';

// Cek apakah user sudah login
if (!isLoggedIn()) {
    jsonResponse(false, 'Unauthorized - Silakan login terlebih dahulu');
}

header('Content-Type: application/json');

// Cek apakah ada file yang diupload
if (!isset($_FILES['image'])) {
    jsonResponse(false, 'Tidak ada file yang diupload');
}

$file = $_FILES['image'];
$username = getUsername();

// Validasi error upload
if ($file['error'] !== UPLOAD_ERR_OK) {
    jsonResponse(false, 'Error saat mengupload file');
}

// Validasi ukuran file
if ($file['size'] > MAX_FILE_SIZE) {
    jsonResponse(false, 'Ukuran file terlalu besar (maksimal 5MB)');
}

// Validasi tipe file
$fileType = mime_content_type($file['tmp_name']);
if (!in_array($fileType, ALLOWED_TYPES)) {
    jsonResponse(false, 'Tipe file tidak diizinkan');
}

// Validasi ekstensi file
$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($fileExtension, ALLOWED_EXT)) {
    jsonResponse(false, 'Ekstensi file tidak diizinkan');
}

// Generate nama file unik
$newFileName = $username . '_' . date('YmdHis') . '_' . uniqid() . '.' . $fileExtension;
$targetPath = UPLOAD_DIR . $newFileName;

// Pindahkan file ke folder uploads
if (move_uploaded_file($file['tmp_name'], $targetPath)) {
    // Simpan informasi ke file JSON
    $imagesDataFile = UPLOAD_DIR . 'images_data.json';
    $imagesData = [];
    
    if (file_exists($imagesDataFile)) {
        $imagesData = json_decode(file_get_contents($imagesDataFile), true);
        if (!is_array($imagesData)) {
            $imagesData = [];
        }
    }
    
    // Tambahkan data gambar baru
    $imagesData[] = [
        'filename' => $newFileName,
        'original_name' => $file['name'],
        'username' => $username,
        'upload_date' => date('Y-m-d H:i:s'),
        'size' => $file['size']
    ];
    
    // Simpan ke file JSON
    file_put_contents($imagesDataFile, json_encode($imagesData, JSON_PRETTY_PRINT));
    
    jsonResponse(true, 'File berhasil diupload', [
        'filename' => $newFileName
    ]);
} else {
    jsonResponse(false, 'Gagal memindahkan file');
}
?>