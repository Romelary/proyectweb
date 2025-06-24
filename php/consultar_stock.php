<?php
require_once 'conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT stock FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $producto = $res->fetch_assoc();

    if ($producto) {
        echo json_encode(['stock' => $producto['stock']]);
    } else {
        echo json_encode(['stock' => 0]);
    }
}
?>
