<?php

$students = array(
    array("Name" => "Alex", "NIM" => "220401", "Mobile" => "0812345678"),
    array("Name" => "Bianca", "NIM" => "220402", "Mobile" => "0812345687"),
    array("Name" => "Candice", "NIM" => "220403", "Mobile" => "0812345665")
);


$students[] = array("Name" => "David", "NIM" => "220404", "Mobile" => "0812345611");
$students[] = array("Name" => "Ethan", "NIM" => "220405", "Mobile" => "0812345622");
$students[] = array("Name" => "Frank", "NIM" => "220406", "Mobile" => "0812345633");
$students[] = array("Name" => "George", "NIM" => "220407", "Mobile" => "0812345644");
$students[] = array("Name" => "Harry", "NIM" => "220408", "Mobile" => "0812345655");


echo "<table border='1' >";
echo "<tr>
        <th>Name</th>
        <th>NIM</th>
        <th>Mobile</th>
      </tr>";


foreach ($students as $row) {
    echo "<tr>";
    echo "<td>" . $row["Name"] . "</td>";
    echo "<td>" . $row["NIM"] . "</td>";
    echo "<td>" . $row["Mobile"] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>