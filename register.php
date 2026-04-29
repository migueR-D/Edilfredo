<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre    = trim($_POST['nombre']    ?? '');
    $apellido  = trim($_POST['apellido']  ?? '');
    $email     = trim($_POST['email']     ?? '');
    $password  = $_POST['password']  ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if (empty($nombre) || empty($apellido) || empty($email) || empty($password)) {
        $error = 'Por favor completa todos los campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo electrónico no es válido.';
    } elseif (strlen($password) < 8) {
        $error = 'La contraseña debe tener al menos 8 caracteres.';
    } elseif ($password !== $confirmar) {
        $error = 'Las contraseñas no coinciden.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = 'Este correo ya está registrado.';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare(
                "INSERT INTO usuarios (nombre, apellido, email, password) VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([$nombre, $apellido, $email, $hash]);
            $success = '¡Cuenta creada con éxito! <a href="login.php">Inicia sesión aquí</a>.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear cuenta · Arkana</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="auth-body">

  <!-- Panel izquierdo decorativo -->
  <div class="auth-panel">
    <div class="auth-panel-grid"></div>
    <div class="auth-panel-circle"></div>

    <div class="auth-panel-logo"><span>Registrar</span></div>

    <div class="auth-panel-body">
      <div class="auth-panel-tag">Registro gratuito</div>
      <div class="auth-panel-headline">
        Empieza<br>hoy <em>mismo.</em>
      </div>
      <p class="auth-panel-sub">
        Crea tu cuenta en segundos y accede a todas las herramientas del panel.
      </p>
    </div>

    <div class="auth-panel-dots">
      <span></span><span></span><span></span>
    </div>
  </div>

  <!-- Panel derecho: formulario -->
  <div class="auth-form-side">
    <div class="auth-card">

      <h1>Crear cuenta</h1>
      <p class="subtitle">Completa los datos para registrarte.</p>

      <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php elseif ($success): ?>
        <div class="success"><?= $success ?></div>
      <?php endif; ?>

      <form method="POST" novalidate>

        <div class="field-row">
          <div class="field">
            <label for="nombre">Nombre</label>
            <input
              type="text"
              id="nombre"
              name="nombre"
              placeholder="Ana"
              value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
              required
              autocomplete="given-name"
            >
          </div>
          <div class="field">
            <label for="apellido">Apellido</label>
            <input
              type="text"
              id="apellido"
              name="apellido"
              placeholder="López"
              value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>"
              required
              autocomplete="family-name"
            >
          </div>
        </div>

        <div class="field">
          <label for="email">Correo electrónico</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="correo@ejemplo.com"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            required
            autocomplete="email"
          >
        </div>

        <div class="field">
          <label for="password">Contraseña</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Mínimo 8 caracteres"
            required
            autocomplete="new-password"
            oninput="checkStrength(this.value)"
          >
          <div class="pw-strength">
            <div class="pw-bar" id="bar1"></div>
            <div class="pw-bar" id="bar2"></div>
            <div class="pw-bar" id="bar3"></div>
            <div class="pw-bar" id="bar4"></div>
          </div>
        </div>

        <div class="field">
          <label for="confirmar">Confirmar contraseña</label>
          <input
            type="password"
            id="confirmar"
            name="confirmar"
            placeholder="Repite tu contraseña"
            required
            autocomplete="new-password"
          >
        </div>

        <button type="submit" class="btn-primary">Crear cuenta</button>
      </form>

      <p class="switch">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>

    </div>
  </div>

  <script>
    function checkStrength(pw) {
      const bars = [1,2,3,4].map(i => document.getElementById('bar'+i));
      const colors = ['#E24B4A','#EF9F27','#7F77DD','#1D9E75'];
      let score = 0;
      if (pw.length >= 8)  score++;
      if (/[A-Z]/.test(pw)) score++;
      if (/[0-9]/.test(pw)) score++;
      if (/[^A-Za-z0-9]/.test(pw)) score++;
      bars.forEach((b, i) => {
        b.style.background = i < score ? colors[score - 1] : 'var(--border)';
      });
    }
  </script>
</body>
</html>