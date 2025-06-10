<?php
ini_set('max_execution_time', 300);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$adminUser = 'root';
$adminPass = ''; // Cambia esto si tu root tiene contraseña

// Usuario del sistema
$newUser = 'romel';
$newPass = '123456';

// Conexión inicial como root
$conn = new mysqli($host, $adminUser, $adminPass);
if ($conn->connect_error) {
    die("Error de conexión con root: " . $conn->connect_error);
}

// Crear usuario MySQL si no existe
$conn->query("CREATE USER IF NOT EXISTS '$newUser'@'localhost' IDENTIFIED BY '$newPass'");
$conn->query("GRANT ALL PRIVILEGES ON *.* TO '$newUser'@'localhost' WITH GRANT OPTION");

// Crear bases de datos
$conn->query("CREATE DATABASE IF NOT EXISTS pet_house");
$conn->query("CREATE DATABASE IF NOT EXISTS pethouse_pagos");

echo "<p> Usuario MySQL y bases de datos creadas.</p>";

// Función para ejecutar un archivo SQL en una base de datos
function ejecutarScript($conexion, $archivoSQL, $base) {
    $conexion->select_db($base);
    $sql = file_get_contents($archivoSQL);

    if (!$sql) {
        echo "<p>⚠️ Archivo $archivoSQL vacío o no encontrado.</p>";
        return;
    }

    if ($conexion->multi_query($sql)) {
        do {
            if ($res = $conexion->store_result()) {
                $res->free();
            }
        } while ($conexion->more_results() && $conexion->next_result());
        echo "<p> Base de datos '$base' instalada correctamente.</p>";
    } else {
        echo "<p> Error ejecutando $archivoSQL en $base: " . $conexion->error . "</p>";
    }
}

// Ejecutar scripts SQL si existen
ejecutarScript($conn, __DIR__ . "/pet_house.sql", "pet_house");
ejecutarScript($conn, __DIR__ . "/pethouse_pagos.sql", "pethouse_pagos");

// Insertar usuario administrador en la base pet_house
$conn->select_db("pet_house");
$nombre = "Administrador";
$email = "admin@pethouse.com";
$telefono = null;
$tipo = "admin";
$clavePlano = "Admin123";
$claveHasheada = password_hash($clavePlano, PASSWORD_DEFAULT);
$fechaRegistro = date("Y-m-d H:i:s");

// Verificar si ya existe
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $stmt->close();
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, telefono, tipo, fecha_registro) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $email, $claveHasheada, $telefono, $tipo, $fechaRegistro);

    if ($stmt->execute()) {
        echo "<p> Usuario administrador insertado correctamente.</p>";
    } else {
        echo "<p> Error al insertar admin: " . $stmt->error . "</p>";
    }
} else {
    echo "<p>⚠️ El usuario administrador ya existe.</p>";
}

$stmt->close();
$conn->close();

echo "<p>🎉 Instalación finalizada correctamente.</p>";
include __DIR__ . '/migrate_products.php';
?>
