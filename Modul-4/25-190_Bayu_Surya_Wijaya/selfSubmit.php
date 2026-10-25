<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['surname'])) {
    require_once 'validate.inc';

    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');

    if ($errors) {
        echo '<h1>Invalid, correct the following errors:</h1><ul>';
        foreach ($errors as $field => $error) {
            echo '<li>' . htmlspecialchars($field, ENT_QUOTES, 'UTF-8') . ': '
               . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</li>';
        }
        echo '</ul>';
        require 'form.inc';
    } else {
        echo '<h1>Form submitted successfully with no errors</h1>';
        echo '<h2>Ringkasan data</h2><ul>';
        $summary = [
            'Surname' => $_POST['surname'] ?? '',
            'Email address' => $_POST['email'] ?? '',
            'Street Address' => $_POST['streetAddress'] ?? '',
            'State' => $_POST['state'] ?? '',
            'Country' => $_POST['country'] ?? '',
            'Gender' => $_POST['gender'] ?? '',
            'Vegetarian?' => isset($_POST['vegetarian']) ? 'Yes' : 'No',
            'Password' => isset($_POST['password']) && $_POST['password'] !== '' ? 'Terisi (disembunyikan)' : 'Tidak diisi'
        ];
        foreach ($summary as $field => $value) {
            echo '<li><strong>' . htmlspecialchars($field, ENT_QUOTES, 'UTF-8') . ':</strong> '
               . htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') . '</li>';
        }
        echo '</ul>';
    }
} else {
    require 'form.inc';
}
?>
