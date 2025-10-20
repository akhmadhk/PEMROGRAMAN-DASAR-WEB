<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja</title>
</head>
<body>
    <h2>Keranjang Belanja</h2>
    
    <?php
    // Inisialisasi variabel dengan nilai default 0
    $beliNovel = 0;
    $beliBuku = 0;
    
    // Cek apakah cookie ada, jika ada ambil nilainya
    if(isset($_COOKIE['beliNovel'])) {
        $beliNovel = $_COOKIE['beliNovel'];
    }
    
    if(isset($_COOKIE['beliBuku'])) {
        $beliBuku = $_COOKIE['beliBuku'];
    }
    
    echo "Jumlah Novel :" . $beliNovel ."<br>";
    echo "Jumlah Buku :" . $beliBuku;
    ?>
</body>
</html>