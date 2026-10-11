<?php 
    $fruits = ["Apple", "Banana", "Cherry", "Date", "Elderberry"];  
    unset($fruits[4]); 
    var_dump($fruits);
    echo "nilai dengan indeks tertinggi: " .     $fruits[count($fruits) - 1];
?>