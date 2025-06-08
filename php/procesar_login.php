<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            if (password_verify($password, $usuario['password'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario'] = true; 
                header('Location: ../index.php');
                exit();
            } else {
                $_SESSION['error_login'] = 'Contraseña incorrecta';
            }
        } else {
            $_SESSION['error_login'] = 'Usuario no encontrado';
        }
    } else {
        $_SESSION['error_login'] = 'Por favor completa todos los campos';
    }
} else {
    $_SESSION['error_login'] = 'Acceso inválido';
}

header('Location: ../login.php');
exit();
