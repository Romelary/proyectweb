<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container">
        <div class="header">
            <h1>Panel de Administración</h1>
            <a href="../php/cerrar.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </a>
        </div>
        
        <?php if(isset($_SESSION['exito'])): ?>
            <div class="alert alert-success"><?= $_SESSION['exito']; unset($_SESSION['exito']); ?></div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon icon-primary">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-info">
                    <h3>Citas totales</h3>
                    <p><?= count($citas); ?></p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon icon-success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>Usuarios registrados</h3>
                    <p><?= count($usuarios); ?></p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon icon-warning">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stat-info">
                    <h3>Mensajes recibidos</h3>
                    <p><?= count($contactos); ?></p>
                </div>
            </div>
        </div>
        
        <!-- Sección de Citas -->
        <h2>Citas Agendadas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Mascota</th>
                    <th>Servicio</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($citas as $cita): ?>
                <tr>
                    <td><?= $cita['id'] ?></td>
                    <td><?= htmlspecialchars($cita['cliente']) ?></td>
                    <td><?= htmlspecialchars($cita['nombre_mascota']) ?></td>
                    <td><?= htmlspecialchars($cita['servicio']) ?></td>
                    <td><?= date('d/m/Y', strtotime($cita['fecha'])) ?></td>
                    <td><?= substr($cita['hora'], 0, 5) ?></td>
                    <td class="status-<?= strtolower($cita['estado']) ?>"><?= $cita['estado'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Sección de Contactos -->
        <h2>Mensajes de Contacto</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($contactos as $contacto): ?>
                <tr>
                    <td><?= $contacto['id'] ?></td>
                    <td><?= htmlspecialchars($contacto['nombre']) ?></td>
                    <td><?= htmlspecialchars($contacto['email']) ?></td>
                    <td><?= htmlspecialchars($contacto['asunto']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($contacto['fecha'])) ?></td>
                    <td><?= $contacto['leido'] ? 'Leído' : 'No leído' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Sección de Usuarios -->
        <h2>Usuarios Registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Registro</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['id'] ?></td>
                    <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                    <td><?= htmlspecialchars($usuario['telefono']) ?></td>
                    <td><?= date('d/m/Y', strtotime($usuario['fecha_registro'])) ?></td>
                    <td><?= $usuario['tipo'] == 'admin' ? 'Administrador' : 'Cliente' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

        