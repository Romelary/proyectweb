<?php
session_start();
include 'php/conexion.php';

// Verificar si el usuario ya está logueado
if(isset($_SESSION['usuario_id'])) {
    if($_SESSION['usuario_tipo'] == 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: login.php');
    }
    exit();
}

// Generar token CSRF
if(empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet House - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="pagina-login">
    <header class="cabecera-simple">
        <div class="contenedor">
            <div class="logo">
                <i class="fas fa-paw"></i>
                <h1>Pet House</h1>

            </div>
        </div>
    </header>

    <main class="contenedor">
        <div class="contenedor-login">
            <h1>Iniciar Sesión</h1>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert error">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['exito'])): ?>
                <div class="alert exito">
                    <?= $_SESSION['exito']; unset($_SESSION['exito']); ?>
                </div>
            <?php endif; ?>
            
            <form class="formulario-login" action="php/procesar_login.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                
                <div class="campo">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="campo">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="boton">Ingresar</button>
                
                <div class="enlaces">
                    <a href="index.html">Volver al inicio</a>
                    <a href="php/recuperar.php">¿Olvidaste tu contraseña?</a>
                    <a href="php/registrouser.php">Crear cuenta</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>