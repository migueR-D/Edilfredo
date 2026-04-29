<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Por favor completa todos los campos.';
    } else {
        $stmt = $pdo->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Correo o contraseña incorrectos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="auth-body">

  <!-- Panel izquierdo decorativo -->
  <div class="auth-panel">
    <div class="auth-panel-grid"></div>
    <div class="auth-panel-circle"></div>

    <div class="auth-panel-logo"><span>Login</span></div>

    <div class="auth-panel-body">
      <div class="auth-panel-tag">Plataforma segura</div>
      <div class="auth-panel-headline">
        Bienvenido<br>de <em>vuelta.</em>
      </div>
      <p class="auth-panel-sub">
        Accede a tu panel de control y gestiona todo desde un solo lugar.
      </p>
    </div>

    <div class="auth-panel-dots">
      <span></span><span></span><span></span>
    </div>
  </div>

  <!-- Panel derecho: formulario -->
  <div class="auth-form-side">
    <div class="auth-card">

      <h1>Iniciar sesión</h1>
      <p class="subtitle">Ingresa tus credenciales para continuar.</p>

      <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" novalidate>
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
            placeholder="••••••••"
            required
            autocomplete="current-password"
          >
        </div>

        <a class="forgot" href="recuperar.php">¿Olvidaste tu contraseña?</a>

        <button type="submit" class="btn-primary">Entrar</button>
      </form>

      <p class="switch">¿No tienes cuenta? <a href="register.php">Regístrate gratis</a></p>

    </div>
  </div>

</body>
</html>