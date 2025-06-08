<?php
session_start();
require_once 'conexion.php';

if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $conn->prepare("DELETE FROM carrito WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
} else {
    unset($_SESSION['carrito']);
}

echo json_encode(['success' => true]);
