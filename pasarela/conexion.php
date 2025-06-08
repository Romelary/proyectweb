<?php
$host = 'localhost';
$user = 'romel';
$password = '123456';
$database = 'pethouse_pagos';

$connPagos = new mysqli($host, $user, $password, $database);

if ($connPagos->connect_error) {
    die("Conexión fallida a pasarela: " . $connPagos->connect_error);
}
?>
