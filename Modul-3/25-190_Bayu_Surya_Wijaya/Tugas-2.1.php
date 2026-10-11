<?php
$fruits = array("Avocado", "Blueberry", "Cherry");


for ($x = 1; $x <= 4; $x++) {
    $fruits[] = "Buah baru indeks ke-" . $x;
}

$arrlength = count($fruits);

for ($x = 0; $x < $arrlength; $x++) {
    echo $fruits[$x] . "<br>";
}
?>
