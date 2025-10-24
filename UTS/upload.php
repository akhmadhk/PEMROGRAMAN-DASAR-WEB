<?php
header('Content-Type: application/json');

// Konfigurasi
$uploadDir = 'uploads/';
$maxFileSize = 5 * 1024 * 1024; // 5MB
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

// Buat folder uploads jika belum ada
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Cek apakah ada file yang diupload
if (!isset($_FILES['image'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Tidak ada file yang diupload'
    ]);
    exit;
}

$file = $_FILES['image'];
$username = isset($_POST['username']) ? $_POST['username'] : 'unknown';

// Validasi error upload
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        'success' => false,
        'message' => 'Error saat mengupload file'
    ]);
    exit;
}

// Validasi ukuran file
if ($file['size'] > $maxFileSize) {
    echo json_encode([
        'success' => false,
        'message' => 'Ukuran file terlalu besar (maksimal 5MB)'
    ]);
    exit;
}

// Validasi tipe file
$fileType = mime_content_type($file['tmp_name']);
if (!in_array($fileType, $allowedTypes)) {
    echo json_encode([
        'success' => false,
        'message' => 'Tipe file tidak diizinkan'
    ]);
    exit;
}

// Validasi ekstensi file
$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($fileExtension, $allowedExtensions)) {
    echo json_encode([
        'success' => false,
        'message' => 'Ekstensi file tidak diizinkan'
    ]);
    exit;
}

// Generate nama file unik
$newFileName = $username . '_' . date('YmdHis') . '_' . uniqid() . '.' . $fileExtension;
$targetPath = $uploadDir . $newFileName;

// Pindahkan file ke folder uploads
if (move_uploaded_file($file['tmp_name'], $targetPath)) {
    // Simpan informasi ke file JSON
    $imagesDataFile = $uploadDir . 'images_data.json';
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
    
    echo json_encode([
        'success' => true,
        'message' => 'File berhasil diupload',
        'filename' => $newFileName
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Gagal memindahkan file'
    ]);
}
?>