<?php
$targetDirectory = "uploads/";
if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0777, true);
}

if (isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    $totalFiles = count($_FILES['files']['name']);

    for ($i = 0; $i < $totalFiles; $i++) {
        $fileName = $_FILES['files']['name'][$i];
        $targetFile = $targetDirectory . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (in_array($fileType, $allowedExtensions)) {
            if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $targetFile)) {
                echo "File gambar $fileName berhasil diunggah.<br>";
            } else {
                echo "Gagal mengunggah file gambar $fileName.<br>";
            }
        } else {
            echo "File $fileName bukan gambar yang valid (hanya jpg, jpeg, png, gif).<br>";
        }
    }
} else {
    echo "Tidak ada file yang diunggah.";
}
?>