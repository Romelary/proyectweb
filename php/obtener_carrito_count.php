<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['usuario_id'])) {
    require_once 'conexion.php';
    $usuario_id = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("SELECT SUM(cantidad) as total FROM carrito WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->bind_result($total);
    $stmt->fetch();
    $stmt->close();

    echo json_encode(['totalItems' => $total ?? 0]);
} else {
    // Visitante no logueado
    $total = 0;
    if (isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
        $total = array_sum($_SESSION['carrito']);
    }
    echo json_encode(['totalItems' => $total]);
}
exit();
