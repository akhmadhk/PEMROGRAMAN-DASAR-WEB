<?php
$loremIpsum = "Lorem ipsum dolor sit amet consectetur adipisicing elit. 
	Voluptatem reprehenderit nobis veritatis commodi fugiat molestias 
	impedit unde ipsum voluptatum, corrupti minus sit excepituri nostrum 
	quisquam? Quos impedit eum nulla optio.";

echo "<p>{$loremIpsum}</p>";
echo "Panjang karakter: " . strlen($loremIpsum) . "<br>";
echo "Panjang kata: " . str_word_count($loremIpsum) . "<br>";
echo "<p>" . strtoupper($loremIpsum) . "</p>";
echo "<p>" . strtolower($loremIpsum) . "</p>";                         
?>
<html>
  <head>
    <title>Cara 01</title>
  </head>
  <body>
    <p>Tanggal Hari ini : <?php echo date("d M Y"); ?></p>
  </body>
</html>

