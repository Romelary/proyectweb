<?php
require_once 'conexion.php';
header('Content-Type: application/json');

// Leer body (form-urlencoded)
parse_str(file_get_contents("php://input"), $_DELETE);
$id = intval($_DELETE['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(["success" => false, "error" => "ID inválido"]);
    exit;
}

$res = $conn->query("DELETE FROM productos WHERE id = $id");

if ($res) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}
$conn->close();
exit;