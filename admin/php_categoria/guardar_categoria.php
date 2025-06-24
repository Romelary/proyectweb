<?php
require_once '../../php/conexion.php';

$id = $_POST['id'] ?? null;
$nombre = trim($_POST['nombre']);
$descripcion = trim($_POST['descripcion']);
$icono = trim($_POST['icono']);

if ($id) {
    $stmt = $conn->prepare("UPDATE categorias SET nombre=?, descripcion=?, icono=? WHERE id=?");
    $stmt->bind_param("sssi", $nombre, $descripcion, $icono, $id);
} else {
    $stmt = $conn->prepare("INSERT INTO categorias (nombre, descripcion, icono) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $descripcion, $icono);
}

if ($stmt->execute()) {
    header("Location: ../categorias.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}
