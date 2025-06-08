<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar campos requeridos
    if (
        empty($_POST['nombre']) || empty($_POST['telefono']) ||
        empty($_POST['fecha']) || empty($_POST['hora']) || empty($_POST['motivo'])
    ) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header('Location: ../citas.html');
        exit();
    }

    // Limpiar datos
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $motivo = filter_var($_POST['motivo'], FILTER_SANITIZE_STRING);

    // Insertar cita en la base de datos
    $stmt = $conn->prepare("INSERT INTO citas (nombre, telefono, fecha, hora, motivo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $telefono, $fecha, $hora, $motivo);

    if ($stmt->execute()) {
        $_SESSION['exito'] = "Cita registrada correctamente.";
    } else {
        $_SESSION['error'] = "Error al registrar la cita: " . $stmt->error;
    }

    $stmt->close();
    header('Location: ../citas.html');
    exit();
} else {
    $_SESSION['error'] = "Acceso no permitido.";
    header('Location: ../citas.html');
    exit();
}
?>
