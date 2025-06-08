<?php
session_start();
header('Content-Type: application/json');

require_once 'conexion.php';

// Leer JSON del cuerpo
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['producto_id']) || !isset($data['cantidad'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit();
}

$producto_id = intval($data['producto_id']);
$cantidad = intval($data['cantidad']);
if ($cantidad < 1) $cantidad = 1;

// Si el usuario está autenticado, usar la base de datos
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("SELECT id, cantidad FROM carrito WHERE usuario_id = ? AND producto_id = ?");
    $stmt->bind_param("ii", $usuario_id, $producto_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $nueva_cantidad = $row['cantidad'] + $cantidad;

        $update = $conn->prepare("UPDATE carrito SET cantidad = ? WHERE id = ?");
        $update->bind_param("ii", $nueva_cantidad, $row['id']);
        $update->execute();
        $update->close();
    } else {
        $insert = $conn->prepare("INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)");
        $insert->bind_param("iii", $usuario_id, $producto_id, $cantidad);
        $insert->execute();
        $insert->close();
    }

    // Obtener total de productos en carrito
    $res = $conn->prepare("SELECT SUM(cantidad) FROM carrito WHERE usuario_id = ?");
    $res->bind_param("i", $usuario_id);
    $res->execute();
    $res->bind_result($total);
    $res->fetch();
    $res->close();

} else {
    // Usuario no logueado → usar carrito en sesión
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if (isset($_SESSION['carrito'][$producto_id])) {
        $_SESSION['carrito'][$producto_id] += $cantidad;
    } else {
        $_SESSION['carrito'][$producto_id] = $cantidad;
    }

    $total = array_sum($_SESSION['carrito']);
}

echo json_encode(['success' => true, 'message' => 'Producto añadido al carrito', 'totalItems' => $total]);
exit();
