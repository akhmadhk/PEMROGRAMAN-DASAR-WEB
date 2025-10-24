<?php
header('Content-Type: application/json');

$uploadDir = 'uploads/';
$imagesDataFile = $uploadDir . 'images_data.json';

// Cek apakah file data gambar ada
if (!file_exists($imagesDataFile)) {
    echo json_encode([
        'success' => true,
        'images' => []
    ]);
    exit;
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

echo json_encode([
    'success' => true,
    'images' => $imagesData
]);
?>