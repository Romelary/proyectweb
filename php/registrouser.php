<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet House - Registro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
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
            <h1>Crear Cuenta</h1>

            <?php session_start(); ?>
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert error">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form class="formulario-login" action="registro.php" method="POST">
                <div class="campo">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>

                <div class="campo">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="campo">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="campo">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" required>
                </div>

                <button type="submit" class="boton" >Registrarse</button>

                <div class="enlaces">
                    <a href="../login.php">¿Ya tienes cuenta? Inicia sesión</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
