<?php
session_start();
require_once 'conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir variables
    $usuario_id = $_SESSION['usuario_id'];
    $nombre_mascota = trim($_POST['mascota-nombre'] ?? '');
    $tipo_mascota = trim($_POST['tipo'] ?? '');
    $servicio = trim($_POST['servicio'] ?? '');
    $fecha = trim($_POST['fecha'] ?? '');
    $hora = trim($_POST['hora'] ?? '');
    $nombre_cliente = trim($_POST['nombre'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $comentarios = "Nombre: $nombre_cliente, Teléfono: $telefono, Email: $email";
    $estado = 'pendiente';
    $fecha_creacion = date('Y-m-d H:i:s');

    // Validaciones básicas
    $errores = [];

    if ($nombre_mascota === '') $errores[] = "Nombre de la mascota es obligatorio.";
    if ($tipo_mascota === '') $errores[] = "Debe seleccionar el tipo de mascota.";
    if ($servicio === '') $errores[] = "Debe seleccionar un servicio.";
    if ($fecha === '') $errores[] = "Debe seleccionar una fecha.";
    if ($hora === '') $errores[] = "Debe seleccionar una hora.";
    if ($nombre_cliente === '') $errores[] = "Tu nombre es obligatorio.";
    if (!preg_match('/^\d{9}$/', $telefono)) $errores[] = "El teléfono debe tener 9 dígitos numéricos.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El correo electrónico no es válido.";

    if (empty($errores)) {
        // Verificar si la hora ya está ocupada
        $stmtCheck = $conn->prepare("SELECT id FROM citas WHERE fecha = ? AND hora = ?");
        $stmtCheck->bind_param("ss", $fecha, $hora);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            echo "Ese horario ya está ocupado. Por favor, elige otro.";
            exit();
        }

        // Insertar la cita
        $stmt = $conn->prepare("INSERT INTO citas (usuario_id, nombre_mascota, tipo_mascota, servicio, fecha, hora, comentarios, estado, fecha_creacion)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssss", $usuario_id, $nombre_mascota, $tipo_mascota, $servicio, $fecha, $hora, $comentarios, $estado, $fecha_creacion);

        if ($stmt->execute()) {
            header('Location: ../usuario/dashboard.php');
            exit();
        } else {
            echo "Error al agendar la cita: " . $stmt->error;
        }
    } else {
        echo "<h3>Errores encontrados:</h3><ul>";
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul><p><a href='../citas.php'>Volver al formulario</a></p>";
    }
} else {
    header('Location: ../citas.php');
    exit();
}
?>
