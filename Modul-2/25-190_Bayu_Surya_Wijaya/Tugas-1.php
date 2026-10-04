<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas-1</title>
</head>
<body>
<?php
    $matkul = ["PTI","ALPRO","DPW","STRUKDAT","JARKOM","PAW","PSBF","RPL"];
    $praktikum = ["PAW","JARKOM"];

    for ($i = 0; $i < count($matkul); $i++) {
        if (in_array($matkul[$i], $praktikum)) {
            echo "Saya sedang mengambil matkul $matkul[$i] termasuk praktikumnya <br>";
        }else if ($matkul[$i] == $matkul[6] or $matkul[$i] == $matkul[7]) {
            echo "Saya sedang mengambil matkul $matkul[$i]<br>";
        }else {
            echo "Saya susdah mengambil matkul $matkul[$i] semester lalu <br>";
        }
    }
?>
    
</body>
</html>