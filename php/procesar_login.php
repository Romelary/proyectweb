<?php
session_start();
require_once __DIR__ . '/conexion.php';



error_reporting(E_ALL);
ini_set('display_errors', 1);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar datos recibidos
    if(empty($_POST['email']) || empty($_POST['password'])) {
        $_SESSION['error'] = "Email y contraseña son requeridos";
        header('Location: ../login.php');
        exit();
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    try {
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        
        // Verificar si se encontró el usuario
        if($stmt->rowCount() === 0) {
            $_SESSION['error'] = "Usuario no encontrado";
            header('Location: ../login.php');
            exit();
        }

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // var_dump($_POST);
        // var_dump($usuario);
        // var_dump($password);
        // var_dump(password_verify($password, $usuario['password']));
        // exit();
        
        if(password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];
            
            $redirect = ($usuario['tipo'] == 'admin') ? '../admin/dashboard.php' : '../perfil.php';
            header("Location: $redirect");
            exit();
            
        } else {
            $_SESSION['error'] = "Contraseña incorrecta";
            header('Location: ../login.php');
            exit();
            
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = "Error en el sistema: " . $e->getMessage();
        header('Location: ../login.php');
        exit();
    }
}

header('Location: ../login.php');
exit();
?>