<?php
session_start();
require_once 'conexion.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);
$producto_id = intval($data['producto_id'] ?? 0);
$accion = $data['accion'] ?? '';

if ($producto_id < 1 || !in_array($accion, ['sumar', 'restar'])) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit();
}

$cambio = ($accion === 'sumar') ? 1 : -1;

if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("SELECT cantidad FROM carrito WHERE usuario_id = ? AND producto_id = ?");
    $stmt->bind_param("ii", $usuario_id, $producto_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $fila = $res->fetch_assoc();
        $nueva_cantidad = max($fila['cantidad'] + $cambio, 1);

        $update = $conn->prepare("UPDATE carrito SET cantidad = ? WHERE usuario_id = ? AND producto_id = ?");
        $update->bind_param("iii", $nueva_cantidad, $usuario_id, $producto_id);
        $update->execute();
    }
} else {
    if (isset($_SESSION['carrito'][$producto_id])) {
        $_SESSION['carrito'][$producto_id] += $cambio;
        if ($_SESSION['carrito'][$producto_id] < 1) {
            $_SESSION['carrito'][$producto_id] = 1;
        }
    }
}

echo json_encode(['success' => true]);
