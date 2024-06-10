<?php
// config.php

// Sinu andmed
$db_server = 'localhost';
$db_andmebaas = 'muusikapood';
$db_kasutaja = 'dmeijel';
$db_salasona = 'dmeijel';

try {
    // Loome ka mysqli ühenduse
    $yhendus = mysqli_connect($db_server, $db_kasutaja, $db_salasona, $db_andmebaas);
} catch (mysqli_sql_exception $e) {
    // Kui ühendust ei saa luua, siis kuvatakse veateade
    die("Viga ühenduse loomisel: " . $e->getMessage());
}
?>
