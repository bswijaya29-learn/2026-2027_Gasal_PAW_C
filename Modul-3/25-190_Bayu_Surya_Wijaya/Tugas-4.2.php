<?php
$weight = array("Andy" => "70", "Barry" => "65", "Charlie" => "75");

$keys = array_keys($weight);
$values = array_values($weight);
$jumlahData = count($weight);

for ($i = 0; $i < $jumlahData; $i++) {
    echo $keys[$i] . " is " . $values[$i] . " kg.<br>";
}
?>