<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $_SESSION['error'] = "Todos los campos son obligatorios";
        header('Location: ../login.php');
        exit();
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Formato de correo inválido";
        header('Location: ../login.php');
        exit();
    }

    $stmt = $conn->prepare("SELECT id, nombre, password, tipo FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];

            if ($usuario['tipo'] === 'admin') {
                header('Location: ../admin/dashboard.php');
            } else {
                header('Location: ../perfil.php'); // o a donde quieras dirigir al usuario
            }
            exit();
        } else {
            $_SESSION['error'] = "Contraseña incorrecta";
        }
    } else {
        $_SESSION['error'] = "Correo no registrado";
    }

    $stmt->close();
    header('Location: ../login.php');
    exit();
} else {
    header('Location: ../login.php');
    exit();
}
?>
