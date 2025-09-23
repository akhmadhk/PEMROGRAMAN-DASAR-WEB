<?php
$a = 10;
$b = 5;

$hasilTambah = $a + $b;
$hasilKurang = $a - $b;
$hasilKali = $a * $b;
$hasilBagi = $a / $b;
$sisaBagi = $a % $b;
$pangkat = $a ** $b;

echo "===== HASIL PERHITUNGAN NILAI a = 10 DAN b = 5 =====<br>";
echo "Hasil a + b = {$hasilTambah} <br>";
echo "Hasil a - b = {$hasilKurang} <br>";
echo "Hasil a x b = {$hasilKali} <br>";
echo "Hasil a : b = {$hasilBagi} <br>";
echo "Hasil sisa a : b = {$sisaBagi} <br>";
echo "Hasil a pangkat b = {$pangkat} <br>";

$hasilSama = $a == $b;
$hasilTidakSama = $a != $b;
$hasilLebihKecil = $a < $b;
$hasilLebihBesar = $a > $b;
$hasilLebihKecilSama = $a <= $b;
$hasilLebihBesarSama = $a >= $b;

echo "<br>===== HASIL PERBANDINGAN NILAI a = 10 DAN b = 5 =====<br>";
echo "Hasil a == b = ";
var_dump($hasilSama);
echo "<br>Hasil a != b = ";
var_dump($hasilTidakSama);
echo "<br>Hasil a < b = ";
var_dump($hasilLebihKecil);
echo "<br>Hasil a > b = ";
var_dump($hasilLebihBesar);
echo "<br>Hasil a <= b = ";
var_dump($hasilLebihKecilSama);
echo "<br>Hasil a >= b = ";
var_dump($hasilLebihBesarSama);

$hasilAnd = $a && $b;
$hasilOr = $a || $b;
$hasilNotA = !$a;
$hasilNotB = !$b;

echo "<br><br>===== HASIL OPERATOR LOGIKA NILAI a = 10 DAN b = 5 =====<br>";
echo "Hasil a && b = ";
var_dump($hasilAnd);
echo "<br>Hasil a || b = ";
var_dump($hasilOr);
echo "<br>Hasil !a = ";
var_dump($hasilNotA);
echo "<br>Hasil !b = ";
var_dump($hasilNotB);

echo "<br><br>===== HASIL OPERATOR PENUGASAN NILAI a = 10 DAN b = 5 =====<br>";
$a += $b;
echo "Hasil a += b = {$a}<br>";
$a -= $b;
echo "Hasil a -= b = {$a}<br>";
$a *= $b;
echo "Hasil a *= b = {$a}<br>";
$a /= $b;
echo "Hasil a /= b = {$a}<br>";
$a %= $b;
echo "Hasil a %= b = {$a}<br>";

$hasilIndentik = $a === $b;
$hasilTidakIdentik = $a !== $b;

echo "<br>Hasil a === b = ";
var_dump($hasilIndentik);
echo "<br>Hasil a !== b = ";
var_dump($hasilTidakIdentik);

echo "<br><br>===== SOAL CERITA =====";
echo "<br>Sebuah restoran memiliki 45 kursi di dalamnya. Pada suatu malam, 28 kursi telah ditempati oleh pelanggan. 
      <br>Berapa persen kursi yang masih kosong di restoran tersebut?<br><br>";

$totalKursi    = 45;   
$kursiTerpakai = 28;  

$kursiKosong = $totalKursi - $kursiTerpakai;

$persenKosong = ($kursiKosong / $totalKursi) * 100;

echo "Total kursi      : {$totalKursi}<br>";
echo "Kursi terpakai   : {$kursiTerpakai}<br>";
echo "Kursi kosong     : {$kursiKosong}<br>";
echo "Persen kursi kosong: {$persenKosong}%";
?>