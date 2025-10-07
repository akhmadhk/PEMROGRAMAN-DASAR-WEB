<?php
function tampilkanHaloDunia($sisa = 5){
  if ($sisa <= 0) return;              
  echo "Halo dunia! <br>";
  tampilkanHaloDunia($sisa - 1);       
}

for ($i = 1; $i <= 25; $i++){
  echo "Perulangan ke-{$i} <br>";
}

echo "<hr>";

function tampilkanAngka(int $jumlah, int $indeks = 1) {
  echo "Perulangan ke-{$indeks} <br>";
  if ($indeks < $jumlah) {
    tampilkanAngka($jumlah, $indeks + 1);
  }
}

tampilkanHaloDunia();     
echo "<hr>";
tampilkanAngka(20);       


