<?php
header('Content-Type: application/json');

$uploadDir = 'uploads/';
$imagesDataFile = $uploadDir . 'images_data.json';

// Cek apakah filename ada
if (!isset($_POST['filename'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Filename tidak ditemukan'
    ]);
    exit;
}

$filename = $_POST['filename'];
$filePath = $uploadDir . $filename;

// Validasi filename untuk keamanan
if (strpos($filename, '..') !== false || strpos($filename, '/') !== false) {
    echo json_encode([
        'success' => false,
        'message' => 'Filename tidak valid'
    ]);
    exit;
}

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
        
        echo json_encode([
            'success' => true,
            'message' => 'Gambar berhasil dihapus'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Gagal menghapus file'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'File tidak ditemukan'
    ]);
}
?>