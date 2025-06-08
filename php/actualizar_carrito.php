<?php
session_start();
require_once 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
$producto_id = intval($data['producto_id'] ?? 0);
$accion = $data['accion'] ?? '';

if ($producto_id < 1 || !in_array($accion, ['sumar', 'restar'])) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit();
}

if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];

    $sql = "SELECT id, cantidad FROM carrito WHERE usuario_id = ? AND producto_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $usuario_id, $producto_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $fila = $res->fetch_assoc();
        $nueva_cantidad = $fila['cantidad'] + ($accion === 'sumar' ? 1 : -1);
        $nueva_cantidad = max($nueva_cantidad, 1);

        $update = $conn->prepare("UPDATE carrito SET cantidad = ? WHERE id = ?");
        $update->bind_param("ii", $nueva_cantidad, $fila['id']);
        $update->execute();
    }

    echo json_encode(['success' => true]);
} else {
    // Sesión sin login
    if (!isset($_SESSION['carrito'][$producto_id])) {
        echo json_encode(['success' => false]);
        exit();
    }

    $_SESSION['carrito'][$producto_id] += ($accion === 'sumar') ? 1 : -1;
    if ($_SESSION['carrito'][$producto_id] < 1) {
        $_SESSION['carrito'][$producto_id] = 1;
    }

    echo json_encode(['success' => true]);
}
