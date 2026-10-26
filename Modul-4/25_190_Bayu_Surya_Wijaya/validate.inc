<?php
/**
 * Validasi surname sesuai modul: huruf alfabet, apostrof, dan tanda hubung.
 * Error disimpan sebagai array berdasarkan nama field.
 */
function validateName(array &$errors, array $field_list, string $field_name): void
{
    $pattern = "/^[a-zA-Z'-]+$/";

    if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '') {
        $errors[$field_name] = 'required';
    } elseif (!preg_match($pattern, $field_list[$field_name])) {
        $errors[$field_name] = 'invalid';
    }
}

/** Validasi email sederhana. */
function validateEmail(array &$errors, array $field_list, string $field_name): void
{
    if (!isset($field_list[$field_name]) || trim($field_list[$field_name]) === '') {
        $errors[$field_name] = 'required';
    } elseif (!filter_var($field_list[$field_name], FILTER_VALIDATE_EMAIL)) {
        $errors[$field_name] = 'invalid';
    }
}
?>
