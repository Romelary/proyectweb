<?php
session_start();
require_once 'conexion.php';

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID de producto no proporcionado']);
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $producto = $resultado->fetch_assoc();
    echo json_encode($producto);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Producto no encontrado']);
}

$stmt->close();
exit();
?>
