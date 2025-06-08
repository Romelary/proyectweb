<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['usuario_id'])) {
    require_once 'conexion.php';
    $usuario_id = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("DELETE FROM carrito WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error en la base de datos']);
    }
    $stmt->close();
} else {
    unset($_SESSION['carrito']); // vacía carrito de sesión
    echo json_encode(['success' => true]);
}
exit();
