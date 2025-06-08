<?php
session_start();
file_put_contents('debug.log', "Sesion actual:\n" . print_r($_SESSION, true));

header('Content-Type: application/json');
require_once 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['producto_id']) || !isset($data['cantidad'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit();
}

$producto_id = intval($data['producto_id']);
$cantidad = intval($data['cantidad']);
if ($cantidad < 1) $cantidad = 1;

if (isset($_SESSION['usuario_id'])) {
    // Usuario autenticado: guardar en base de datos
    $usuario_id = $_SESSION['usuario_id'];

    if (!$conn) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        exit();
    }

    // 
    $stmt = $conn->prepare("
        INSERT INTO carrito (usuario_id, producto_id, cantidad)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE cantidad = cantidad + VALUES(cantidad)
    ");
    $stmt->bind_param("iii", $usuario_id, $producto_id, $cantidad);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Producto agregado al carrito (usuario)']);
} else {
    // Usuario no autenticado: usar $_SESSION
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $_SESSION['carrito'][$producto_id] = ($_SESSION['carrito'][$producto_id] ?? 0) + $cantidad;

    echo json_encode(['success' => true, 'message' => 'Producto agregado al carrito (sesión)']);
}
