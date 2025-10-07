<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Data Dosen</title>
  <style>
    body{font-family:Arial, sans-serif; margin:24px;}
    table{border-collapse:collapse; width:420px;}
    th,td{border:1px solid #ccc; padding:8px 10px; text-align:left;}
    th{background:#f2f2f2;}
    tr:nth-child(even) td{background:#fafafa;}
  </style>
</head>
<body>
<?php
  $Dosen = [
    'nama' => 'Elok Nur Hamdana',
    'domisili' => 'Malang',
    'jenis_kelamin' => 'Perempuan'
  ];
?>
<h3>Profil Dosen</h3>
<table>
  <tr><th>Field</th><th>Nilai</th></tr>
  <tr><td>Nama</td><td><?= $Dosen['nama']; ?></td></tr>
  <tr><td>Domisili</td><td><?= $Dosen['domisili']; ?></td></tr>
  <tr><td>Jenis Kelamin</td><td><?= $Dosen['jenis_kelamin']; ?></td></tr>
</table>
</body>
</html>
