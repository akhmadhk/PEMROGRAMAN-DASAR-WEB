<?php
require_once 'config.php';

// Cek apakah user sudah login
if (!isLoggedIn()) {
    jsonResponse(false, 'Unauthorized - Silakan login terlebih dahulu');
}

header('Content-Type: application/json');

$imagesDataFile = UPLOAD_DIR . 'images_data.json';

// Cek apakah file data gambar ada
if (!file_exists($imagesDataFile)) {
    jsonResponse(true, 'Tidak ada gambar', ['images' => []]);
}

// Baca data gambar
$imagesData = json_decode(file_get_contents($imagesDataFile), true);

if (!is_array($imagesData)) {
    $imagesData = [];
}

// Urutkan berdasarkan tanggal upload (terbaru dulu)
usort($imagesData, function($a, $b) {
    return strtotime($b['upload_date']) - strtotime($a['upload_date']);
});

// Filter data berdasarkan role
$currentRole = getUserRole();
$filteredData = [];

foreach ($imagesData as $image) {
    $imageInfo = [
        'filename' => $image['filename'],
        'original_name' => $image['original_name'],
        'upload_date' => $image['upload_date'],
        'size' => $image['size']
    ];
    
    // Admin bisa lihat uploader, member tidak
    if ($currentRole === 'admin') {
        $imageInfo['username'] = $image['username'];
    }
    
    $filteredData[] = $imageInfo;
}

jsonResponse(true, 'Data gambar berhasil dimuat', [
    'images' => $filteredData,
    'total' => count($filteredData)
]);
?>