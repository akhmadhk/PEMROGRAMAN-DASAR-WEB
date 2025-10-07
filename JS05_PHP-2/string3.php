<?php

$pesan = "saya arek malang";
$pesanPerKata = explode(" ", $pesan);  // pisah berdasarkan spasi
$pesanPerKata = array_map(fn($kata) => strrev($kata), $pesanPerKata);  // balikkan tiap kata
$pesan = implode(" ", $pesanPerKata);  // gabungkan kembali menjadi string
echo $pesan . "<br>";
?>
