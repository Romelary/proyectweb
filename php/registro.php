<?php
session_start(); // Añadir esto al inicio
require_once 'conexion.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar que los campos no estén vacíos
    if(empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['telefono'])) {
        $_SESSION['error'] = "Todos los campos son obligatorios";
        header('Location: registrouser.php');
        exit();
    }

    // Validar y limpiar datos
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    // Validar formato de email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "El formato del email no es válido";
        header('Location: registrouser.php');
        exit();
    }
    
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    if($password === false) {
        $_SESSION['error'] = "Error al generar el hash de la contraseña";
        header('Location: registrouser.php');
        exit();
    }
    
    $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);

    try {
        // Verificar si el email ya existe
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        
        if($stmt->rowCount() > 0) {
            $_SESSION['error'] = "El email ya está registrado";
            header('Location: registrouser.php');
            exit();
        }

        // Insertar nuevo usuario
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, password, telefono) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $email, $password, $telefono]);
        
        $_SESSION['exito'] = "Registro exitoso. Por favor inicia sesión.";
        header('Location: ../login.php');
        exit();
        
        
    } catch(PDOException $e) {
        $_SESSION['error'] = "Error al registrar: " . $e->getMessage();
        header('Location: registrouser.php');
        exit();
    }
} else {
    header('Location: registrouser.php');
    exit();
}
?>