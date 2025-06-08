<?php
ini_set('max_execution_time', 300);
$host = 'localhost';
$adminUser = 'root';
$adminPass = ''; // Cambiar si tienes contraseña de root

// Nuevo usuario que se creará
$newUser = 'romel';
$newPass = '123456';

// Conexión con root
$conn = new mysqli($host, $adminUser, $adminPass);
if ($conn->connect_error) {
    die("Error de conexión con root: " . $conn->connect_error);
}

// Crear usuario romel si no existe
$conn->query("CREATE USER IF NOT EXISTS '$newUser'@'localhost' IDENTIFIED BY '$newPass'");
$conn->query("GRANT ALL PRIVILEGES ON *.* TO '$newUser'@'localhost' WITH GRANT OPTION");

// Crear bases de datos
$conn->query("CREATE DATABASE IF NOT EXISTS pet_house");
$conn->query("CREATE DATABASE IF NOT EXISTS pethouse_pagos");

echo "<p>Usuario y bases de datos creadas.</p>";

// Función para ejecutar un script SQL
function ejecutarScript($conexion, $archivoSQL, $base) {
    $conexion->select_db($base);
    $sql = file_get_contents($archivoSQL);
    if ($conexion->multi_query($sql)) {
        do {
            if ($res = $conexion->store_result()) {
                $res->free();
            }
        } while ($conexion->more_results() && $conexion->next_result());
        echo "<p>Base de datos '$base' instalada correctamente.</p>";
    } else {
        echo "<p>Error ejecutando $archivoSQL en $base: " . $conexion->error . "</p>";
    }
}

// Ejecutar los scripts
ejecutarScript($conn, __DIR__ . "/pet_house.sql", "pet_house");
ejecutarScript($conn, __DIR__ . "/pethouse_pagos.sql", "pethouse_pagos");

$conn->close();
echo "<p>Instalación finalizada correctamente.</p>";
?>
