<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'romel');
define('DB_PASS', '123456');
define('DB_NAME', 'pet_house');

// Conexión a MySQL
try {
    $conexion = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("SET NAMES 'utf8'");
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Iniciar sesión si no está iniciada
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
try {
    $conexion = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("SET NAMES 'utf8'");
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Sesión debe iniciarse en cada archivo que use $_SESSION
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>