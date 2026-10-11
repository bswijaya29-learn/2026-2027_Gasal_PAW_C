<?php
// Menambahkan tag <pre> agar output spasi dan enter (print_r) terbaca rapi di browser
echo "<pre>";

// ==========================================
// 1. INDEXED ARRAY
// ==========================================
echo "<b>--- 1. INDEXED ARRAY ---</b>\n";
$indexed1 = ["Apel", "Jeruk", "Mangga"];
$indexed2 = ["Pisang", "Anggur"];

// array_push()
array_push($indexed1, "Durian");
echo "array_push: \n"; 
print_r($indexed1);

// array_merge()
$merged_indexed = array_merge($indexed1, $indexed2);
echo "\narray_merge: \n"; 
print_r($merged_indexed);

// array_values()
$values_indexed = array_values($indexed1);
echo "\narray_values: \n"; 
print_r($values_indexed);

// array_search()
$search_indexed = array_search("Jeruk", $indexed1);
echo "\narray_search ('Jeruk'): Index ke-" . $search_indexed . "\n";

// array_filter()
$filtered_indexed = array_filter($indexed1, function($val) {
    return strlen($val) > 4; // Mencari string dengan panjang > 4
});
echo "\narray_filter (>4 huruf): \n"; 
print_r($filtered_indexed);

// Sorting (sort) - Mengurutkan nilainya
sort($indexed1);
echo "\nsort: \n"; 
print_r($indexed1);
echo "\n\n";


// ==========================================
// 2. ASSOCIATIVE ARRAY
// ==========================================
echo "<b>--- 2. ASSOCIATIVE ARRAY ---</b>\n";
$assoc1 = ["a" => 30, "b" => 10, "c" => 20];
$assoc2 = ["d" => 40, "e" => 50];

// array_push() - Catatan: array_push akan mengubah kunci menjadi numerik di akhir array
array_push($assoc1, 60); 
echo "array_push: \n"; 
print_r($assoc1);

// array_merge()
$merged_assoc = array_merge($assoc1, $assoc2);
echo "\narray_merge: \n"; 
print_r($merged_assoc);

// array_values()
$values_assoc = array_values($assoc1);
echo "\narray_values: \n"; 
print_r($values_assoc);

// array_search()
$search_assoc = array_search(20, $assoc1);
echo "\narray_search (Nilai 20): Key '" . $search_assoc . "'\n";

// array_filter()
$filtered_assoc = array_filter($assoc1, function($val) {
    return $val >= 30;
});
echo "\narray_filter (>= 30): \n"; 
print_r($filtered_assoc);

// Sorting (asort) - Mengurutkan berdasarkan value, mempertahankan key
asort($assoc1);
echo "\nasort (berdasarkan value): \n"; 
print_r($assoc1);
echo "\n\n";


// ==========================================
// 3. MULTIDIMENSIONAL ARRAY
// ==========================================
echo "<b>--- 3. MULTIDIMENSIONAL ARRAY ---</b>\n";
$multi1 = [
    ["id" => 2, "nama" => "Budi"],
    ["id" => 1, "nama" => "Andi"]
];
$multi2 = [
    ["id" => 3, "nama" => "Citra"]
];

// array_push()
array_push($multi1, ["id" => 4, "nama" => "Dewi"]);
echo "array_push: \n"; 
print_r($multi1);

// array_merge()
$merged_multi = array_merge($multi1, $multi2);
echo "\narray_merge: \n"; 
print_r($merged_multi);

// array_values()
$values_multi = array_values($multi1);
echo "\narray_values: \n"; 
print_r($values_multi);

// array_search() - Mencari array spesifik di dalam array multidimensi
$search_multi = array_search(["id" => 1, "nama" => "Andi"], $multi1);
echo "\narray_search (Andi): Index ke-" . $search_multi . "\n";

// array_filter()
$filtered_multi = array_filter($multi1, function($val) {
    return $val["id"] > 1;
});
echo "\narray_filter (id > 1): \n"; 
print_r($filtered_multi);

// Sorting (usort) - Mengurutkan array multidimensi berdasarkan key tertentu
usort($multi1, function($a, $b) {
    return $a['id'] <=> $b['id']; // Urutkan berdasarkan ID
});
echo "\nusort (berdasarkan ID): \n"; 
print_r($multi1);

echo "</pre>";
?>