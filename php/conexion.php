<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'romel');
define('DB_PASS', '123456');
define('DB_NAME', 'pet_house');

// Conexión a MySQLi
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer codificación de caracteres
$conn->set_charset("utf8");

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
