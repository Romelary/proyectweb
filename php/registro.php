<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar que los campos no estén vacíos
    if (empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['telefono'])) {
        $_SESSION['error'] = "Todos los campos son obligatorios";
        header('Location: registrouser.php');
        exit();
    }

    // Validar y limpiar datos
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);

    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "El formato del email no es válido";
        header('Location: registrouser.php');
        exit();
    }

    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    if ($password === false) {
        $_SESSION['error'] = "Error al generar el hash de la contraseña";
        header('Location: registrouser.php');
        exit();
    }

    // Verificar si el email ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result(); // Necesario para rowCount con mysqli

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "El email ya está registrado";
        $stmt->close();
        header('Location: registrouser.php');
        exit();
    }
    $stmt->close();

    // Insertar nuevo usuario (tipo 'cliente' por defecto)
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, telefono, tipo) VALUES (?, ?, ?, ?, 'cliente')");
    $stmt->bind_param("ssss", $nombre, $email, $password, $telefono);

    if ($stmt->execute()) {
        $_SESSION['exito'] = "Registro exitoso. Por favor inicia sesión.";
        $stmt->close();
        header('Location: ../login.php');
        exit();
    } else {
        $_SESSION['error'] = "Error al registrar: " . $stmt->error;
        $stmt->close();
        header('Location: registrouser.php');
        exit();
    }
} else {
    header('Location: registrouser.php');
    exit();
}
?>
