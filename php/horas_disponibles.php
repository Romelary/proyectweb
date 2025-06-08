<?php
require_once 'conexion.php';

if (!isset($_GET['fecha'])) {
    http_response_code(400);
    echo json_encode(["error" => "Fecha no proporcionada"]);
    exit();
}

$fecha = $_GET['fecha'];
$horas_ocupadas = [];

$stmt = $conn->prepare("SELECT hora FROM citas WHERE fecha = ?");
$stmt->bind_param("s", $fecha);
$stmt->execute();
$resultado = $stmt->get_result();

while ($row = $resultado->fetch_assoc()) {
    $horas_ocupadas[] = $row['hora'];
}

$horarios_totales = ['09:00', '10:00', '11:00', '12:00', '15:00', '16:00', '17:00', '18:00'];
$disponibles = array_values(array_diff($horarios_totales, $horas_ocupadas));

echo json_encode($disponibles);
?>
