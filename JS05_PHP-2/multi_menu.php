<?php
$menu = [
  [
    "nama" => "Beranda"
  ],
  [
    "nama" => "Berita",
    "subMenu" => [
      [
        "nama" => "Wisata",
        "subMenu" => [
          [
            "nama" => "Pantai"
          ],
          [
            "nama" => "Gunung"
          ]
        ]
      ],
      [
        "nama" => "Kuliner"
      ],
      [
        "nama" => "Hiburan"
      ]
    ]
  ],
  [
    "nama" => "Tentang"
  ],
  [
    "nama" => "Kontak"
  ]
];
function tampilkanMenuBertingkat(array $menu) {
  echo "<ul>";
  foreach ($menu as $key => $item) {
    echo "<li>{$item['nama']}";
    // Menambahkan kondisi rekursif untuk subMenu
    if (isset($item['subMenu'])) {
      tampilkanMenuBertingkat($item['subMenu']);  // Panggil fungsi rekursif untuk subMenu
    }
    echo "</li>";
  }
  echo "</ul>";
}
tampilkanMenuBertingkat($menu);
?>


tampilkanMenuBertingkat($menu);
?>
