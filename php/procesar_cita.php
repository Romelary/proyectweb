<?php
require_once 'conexion.php';

// Verificar si el usuario está logueado
if(!isset($_SESSION['usuario_id'])) {
    $_SESSION['error'] = "Debes iniciar sesión para agendar una cita";
    header('Location: login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger y validar datos
    $nombre_mascota = filter_var($_POST['mascota-nombre'], FILTER_SANITIZE_STRING);
    $tipo_mascota = filter_var($_POST['tipo-mascota'], FILTER_SANITIZE_STRING);
    $servicio = filter_var($_POST['servicio'], FILTER_SANITIZE_STRING);
    $fecha = filter_var($_POST['fecha'], FILTER_SANITIZE_STRING);
    $hora = filter_var($_POST['hora'], FILTER_SANITIZE_STRING);
    $comentarios = filter_var($_POST['comentarios'], FILTER_SANITIZE_STRING);
    $usuario_id = $_SESSION['usuario_id'];

    try {
        $stmt = $conexion->prepare("INSERT INTO citas (usuario_id, nombre_mascota, tipo_mascota, servicio, fecha, hora, comentarios) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$usuario_id, $nombre_mascota, $tipo_mascota, $servicio, $fecha, $hora, $comentarios]);
        
        $_SESSION['exito'] = "Cita agendada exitosamente para el $fecha a las $hora";
        header('Location: citas.html');
        
    } catch(PDOException $e) {
        $_SESSION['error'] = "Error al agendar la cita: " . $e->getMessage();
        header('Location: citas.html');
    }
} else {
    header('Location: citas.html');
}
?>