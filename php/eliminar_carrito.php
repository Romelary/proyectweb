<?php
session_start();
require_once 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
$producto_id = intval($data['producto_id'] ?? 0);

if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $conn->prepare("DELETE FROM carrito WHERE usuario_id = ? AND producto_id = ?");
    $stmt->bind_param("ii", $usuario_id, $producto_id);
    $stmt->execute();
} else {
    unset($_SESSION['carrito'][$producto_id]);
}

echo json_encode(['success' => true]);
