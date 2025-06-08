<?php
session_start();
header('Content-Type: application/json');
require_once 'conexion.php'; // Necesario para consultar el stock

// Asegurar que la variable de sesión del carrito existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Obtener los datos enviados desde JavaScript
$data = json_decode(file_get_contents('php://input'), true);
$producto_id = $data['producto_id'] ?? null;
$accion = $data['accion'] ?? null;

// Validar datos recibidos
if (!$producto_id || !$accion) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

// Asegurarse de que el producto existe en el carrito
if (!isset($_SESSION['carrito'][$producto_id])) {
    echo json_encode(['success' => false, 'message' => 'Producto no encontrado en el carrito']);
    exit;
}

// Consultar stock desde la base de datos
$stmt = $conn->prepare("SELECT stock FROM productos WHERE id = ?");
$stmt->bind_param("i", $producto_id);
$stmt->execute();
$stmt->bind_result($stock);
$stmt->fetch();
$stmt->close();

if ($accion === 'sumar') {
    if ($_SESSION['carrito'][$producto_id] < $stock) {
        $_SESSION['carrito'][$producto_id]++;
    } else {
        echo json_encode(['success' => false, 'message' => 'No hay más stock disponible']);
        exit;
    }
} elseif ($accion === 'restar') {
    $_SESSION['carrito'][$producto_id]--;

    // Si la cantidad baja de 1, eliminar del carrito
    if ($_SESSION['carrito'][$producto_id] < 1) {
        unset($_SESSION['carrito'][$producto_id]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Acción inválida']);
    exit;
}

// Éxito
echo json_encode(['success' => true]);
exit;
