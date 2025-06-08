<?php
session_start();
require_once 'php/conexion.php';
$usuario_activo = isset($_SESSION['usuario']) || isset($_SESSION['usuario_id']);

$horasOcupadasPorFecha = [];
$hoy = date('Y-m-d');
$stmt = $conn->prepare("SELECT fecha, hora FROM citas WHERE fecha >= ?");
$stmt->bind_param("s", $hoy);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $fecha = $row['fecha'];
    $hora = $row['hora'];
    if (!isset($horasOcupadasPorFecha[$fecha])) {
        $horasOcupadasPorFecha[$fecha] = [];
    }
    $horasOcupadasPorFecha[$fecha][] = $hora;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Agenda una cita para tu mascota en Pet House" />
  <title>Pet House - Agendar Cita</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="css/styles.css" />
  <style>
    .modal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); }
    .modal-content { background-color: #fff; margin: 10% auto; padding: 20px; border-radius: 10px; width: 90%; max-width: 400px; text-align: center; }
    .modal-content h2 { margin-bottom: 20px; }
    .modal-content .botones { display: flex; justify-content: space-between; gap: 10px; }
    .modal-content .botones a,
    .modal-content .botones button {
      flex: 1; padding: 10px; border: none; cursor: pointer; font-weight: bold; border-radius: 5px;
    }
    .modal-content .botones a {
      background-color: #2e8b57; color: white; text-decoration: none; text-align: center;
    }
    .modal-content .botones button {
      background-color: #ccc;
    }
  </style>
</head>
<body>
  <!-- CABECERA -->
  <header class="cabecera" aria-label="Cabecera principal">
    <div class="contenedor">
      <div class="logo">
        <i class="fas fa-paw"></i>
        <h1>Pet House</h1>
      </div>
      <nav class="navegacion" aria-label="Navegación principal">
        <a href="index.php">Inicio</a>
        <a href="servicios.php">Servicios</a>
        <a href="productos.php">Productos</a>
        <a href="citas.php" class="activo">Citas</a>
        <a href="contacto.php">Contacto</a>
        <a href="carrito.php" class="carrito-link">
          <i class="fas fa-shopping-cart"></i>
          <span id="contador-carrito" class="contador-carrito">0</span>
        </a>
        <?php if ($usuario_activo): ?>
          <a href="usuario/dashboard.php">Mis citas y compras</a>
          <a href="php/cerrar.php" class="boton-login">Cerrar sesión</a>
        <?php else: ?>
          <a href="login.php" class="boton-login">Ingresar</a>
        <?php endif; ?>
      </nav>
      <button class="boton-menu" aria-label="Menú móvil" aria-expanded="false">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </header>

  <!-- MENÚ MÓVIL -->
  <nav class="mobile-nav" aria-label="Navegación móvil">
    <ul>
      <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
      <li><a href="servicios.php"><i class="fas fa-clinic-medical"></i> Servicios</a></li>
      <li><a href="productos.php"><i class="fas fa-pills"></i> Productos</a></li>
      <li><a href="citas.php" class="activo"><i class="fas fa-calendar-check"></i> Citas</a></li>
      <li><a href="contacto.php"><i class="fas fa-phone-alt"></i> Contacto</a></li>
      <li><a href="carrito.php" class="carrito-link"><i class="fas fa-shopping-cart"></i> <span class="contador-carrito" id="contador-carrito-mobile">0</span></a></li>
      <?php if ($usuario_activo): ?>
        <li><a href="usuario/dashboard.php"><i class="fas fa-user-check"></i> Mis citas y compras</a></li>
        <li><a href="php/cerrar.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
      <?php else: ?>
        <li><a href="login.php"><i class="fas fa-user"></i> Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>


  <!-- CONTENIDO PRINCIPAL -->
  <main class="contenedor">
    <h1 class="titulo-seccion">Agenda una Cita</h1>
    <p class="subtitulo-seccion">Completa el formulario y elige el mejor horario para tu mascota</p>

    <form class="formulario-cita" action="php/procesar_cita.php" method="POST" novalidate>
      <div class="campo">
        <label for="mascota-nombre">Nombre de la mascota:</label>
        <input type="text" name="mascota-nombre" id="mascota-nombre" required />
      </div>
      <div class="campo">
        <label for="tipo">Tipo de mascota:</label>
        <select name="tipo" id="tipo" required>
          <option value="">Seleccione</option>
          <option value="Perro">Perro</option>
          <option value="Gato">Gato</option>
          <option value="Otro">Otro</option>
        </select>
      </div>
      <div class="campo">
        <label for="servicio">Servicio:</label>
        <select name="servicio" id="servicio" required>
          <option value="">Seleccione</option>
        </select>
      </div>
      <div class="campo">
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" id="fecha" required min="<?php echo date('Y-m-d'); ?>" />
      </div>
      <div class="campo">
        <label for="hora">Hora:</label>
        <select name="hora" id="hora" required></select>
      </div>
      <div class="campo">
        <label for="nombre">Tu nombre completo:</label>
        <input type="text" name="nombre" id="nombre" required />
      </div>
      <div class="campo">
        <label for="telefono">Teléfono:</label>
        <input type="tel" name="telefono" id="telefono" pattern="[0-9]{9}" required placeholder="Ej: 987654321" />
      </div>
      <div class="campo">
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" required />
      </div>
      <input type="submit" value="Agendar Cita" class="boton" <?php if (!$usuario_activo) echo 'onclick="return false;"'; ?> />
    </form>
  </main>

  <!-- Modal Informativo -->
  <div id="loginModal" class="modal">
    <div class="modal-content">
      <h2>Para continuar necesitas iniciar sesión</h2>
      <div class="botones">
        <a href="login.php">Iniciar sesión</a>
        <button onclick="window.location.href='servicios.php'">Cancelar</button>
      </div>
    </div>
  </div>

  <!-- PIE DE PÁGINA -->
  <footer class="pie-pagina" aria-label="Pie de página">
    <div class="contenedor">
      <p>&copy; <span id="year"></span> Pet House - Todos los derechos reservados</p>
    </div>
  </footer>

  <!-- SCRIPTS -->
  <script src="js/boton-menu.js"></script>
  <script src="js/formulario-citas.js"></script>
  <script src="js/carrito.js"></script>
  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
    const modal = document.getElementById('loginModal');
    function cerrarModal() {
      modal.style.display = 'none';
    }
    <?php if (!$usuario_activo): ?>
      window.onload = () => {
        modal.style.display = 'block';
      };
    <?php endif; ?>
  </script>

  <!-- para que no se selcione citas al mimo tiempo -->
   <script>
  const horasPorFecha = <?php echo json_encode($horasOcupadasPorFecha); ?>;
  const horasDisponibles = [
    "09:00", "10:00", "11:00", "12:00",
    "14:00", "15:00", "16:00", "17:00"
  ];

  function actualizarHoras() {
    const fechaSeleccionada = document.getElementById('fecha').value;
    const selectHora = document.getElementById('hora');
    selectHora.innerHTML = '';

    if (!fechaSeleccionada) return;

    const ocupadas = horasPorFecha[fechaSeleccionada] || [];
    const disponibles = horasDisponibles.filter(hora => !ocupadas.includes(hora));

    if (disponibles.length === 0) {
      const opt = document.createElement('option');
      opt.value = '';
      opt.textContent = 'Sin horarios disponibles';
      selectHora.appendChild(opt);
    } else {
      disponibles.forEach(hora => {
        const opt = document.createElement('option');
        opt.value = hora;
        opt.textContent = hora;
        selectHora.appendChild(opt);
      });
    }
  }

  document.getElementById('fecha').addEventListener('change', actualizarHoras);
</script>
<script src="js/formulario-citas.js"></script>

</body>
</html>
