<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$producto_id = $data['producto_id'] ?? null;

if ($producto_id && isset($_SESSION['carrito'][$producto_id])) {
    unset($_SESSION['carrito'][$producto_id]);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
}
