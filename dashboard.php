<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$nombre = htmlspecialchars($_SESSION['user_name'] ?? 'Usuario');
$iniciales = '';
foreach (explode(' ', $nombre) as $parte) {
    $iniciales .= strtoupper(mb_substr($parte, 0, 1));
    if (strlen($iniciales) >= 2) break;
}

$diasSemana = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'];
$meses = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];
$hoy = $diasSemana[date('w')] . ' ' . date('j') . ' ' . $meses[(int)date('n')-1] . '. ' . date('Y');

$hora = (int)date('H');
if ($hora < 12)       $saludo = 'Buenos días';
elseif ($hora < 18)   $saludo = 'Buenas tardes';
else                  $saludo = 'Buenas noches';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard · Arkana</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="db-body">

<!-- ── Sidebar ─────────────────────────────────────────────────────────── -->
<aside class="sidebar">
  <div class="sidebar-logo"><em>Dashboard</em></div>

  <div class="sidebar-section">Principal</div>

  <a href="dashboard.php" class="nav-item active">
    <svg class="nav-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4">
      <rect x="1" y="1" width="6" height="6" rx="1"/>
      <rect x="9" y="1" width="6" height="6" rx="1"/>
      <rect x="1" y="9" width="6" height="6" rx="1"/>
      <rect x="9" y="9" width="6" height="6" rx="1"/>
    </svg>
    Panel
  </a>

  <a href="#" class="nav-item">
    <svg class="nav-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4">
      <circle cx="8" cy="5" r="3"/>
      <path d="M2 14c0-3.3 2.7-6 6-6s6 2.7 6 6"/>
    </svg>
    Usuarios
  </a>

  <a href="#" class="nav-item">
    <svg class="nav-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4">
      <path d="M2 12L5 8l3 3 3-4 3 3"/>
      <rect x="1" y="1" width="14" height="14" rx="1"/>
    </svg>
    Analíticas
  </a>

  <a href="#" class="nav-item">
    <svg class="nav-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4">
      <path d="M8 1l1.8 4.5H14.5L10.8 8.5l1.4 4.5L8 10.2 3.8 13l1.4-4.5L1.5 5.5H6.2L8 1z"/>
    </svg>
    Reportes
  </a>

  <div class="sidebar-section">Configuración</div>

  <a href="#" class="nav-item">
    <svg class="nav-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4">
      <circle cx="8" cy="8" r="2"/>
      <path d="M8 1v2M8 13v2M1 8h2M13 8h2M3.3 3.3l1.4 1.4M11.3 11.3l1.4 1.4M11.3 3.3l-1.4 1.4M4.7 11.3l-1.4 1.4"/>
    </svg>
    Ajustes
  </a>

  <a href="#" class="nav-item">
    <svg class="nav-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4">
      <path d="M8 1a7 7 0 100 14A7 7 0 008 1zM8 5v4M8 11v1"/>
    </svg>
    Soporte
  </a>

  <div class="sidebar-bottom">
    <div class="sidebar-user">
      <div class="s-avatar"><?= $iniciales ?></div>
      <div>
        <div class="s-name"><?= $nombre ?></div>
        <div class="s-role">administrador</div>
      </div>
    </div>
    <form method="POST" action="logout.php">
      <button type="submit" class="logout-btn">
        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4">
          <path d="M6 2H3a1 1 0 00-1 1v10a1 1 0 001 1h3M10 11l3-3-3-3M13 8H6"/>
        </svg>
        Cerrar sesión
      </button>
    </form>
  </div>
</aside>

<!-- ── Main ─────────────────────────────────────────────────────────────── -->
<main class="db-main">

  <!-- Topbar -->
  <div class="db-topbar">
    <div class="db-greeting"><?= $saludo ?>, <em><?= $nombre ?></em></div>
    <div class="db-date"><?= $hoy ?></div>
  </div>

  <!-- Métricas -->
  <div class="metrics-grid">

    <div class="metric-card accent">
      <div class="metric-label">Usuarios totales</div>
      <div class="metric-value">3,841</div>
      <div class="metric-delta delta-up">↑ 12.4% este mes</div>
      <div class="metric-icon">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4">
          <circle cx="8" cy="5" r="3"/>
          <path d="M2 14c0-3.3 2.7-6 6-6s6 2.7 6 6"/>
        </svg>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-label">Sesiones hoy</div>
      <div class="metric-value">218</div>
      <div class="metric-delta delta-up">↑ 8 vs ayer</div>
      <div class="metric-icon">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4">
          <rect x="2" y="3" width="12" height="9" rx="1"/>
          <path d="M5 14h6M8 12v2"/>
        </svg>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-label">Nuevos este mes</div>
      <div class="metric-value">473</div>
      <div class="metric-delta delta-up">↑ 31 vs anterior</div>
      <div class="metric-icon">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4">
          <path d="M8 2v12M2 8h12"/>
        </svg>
      </div>
    </div>

    <div class="metric-card">
      <div class="metric-label">Tasa de retención</div>
      <div class="metric-value">68%</div>
      <div class="metric-delta delta-down">↓ 2pp vs anterior</div>
      <div class="metric-icon">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.4">
          <path d="M2 12L5 8l3 3 3-4 3 3"/>
        </svg>
      </div>
    </div>

  </div>

  <!-- Gráfica + Actividad reciente -->
  <div class="two-col">

    <!-- Gráfica de barras -->
    <div class="card">
      <div class="card-head">
        <div>
          <div class="card-title">Registros — últimas 8 semanas</div>
        </div>
        <div class="card-subtitle">nuevos usuarios/sem.</div>
      </div>
      <div style="display:flex;gap:14px;margin-bottom:12px;font-size:11px;font-family:'DM Mono',monospace;color:var(--text-muted);">
        <span style="display:flex;align-items:center;gap:5px;">
          <span style="width:10px;height:10px;border-radius:2px;background:#534AB7;display:inline-block;"></span>Registros
        </span>
        <span style="display:flex;align-items:center;gap:5px;">
          <span style="width:10px;height:10px;border-radius:2px;background:#5DCAA5;display:inline-block;"></span>Activos
        </span>
      </div>
      <div style="position:relative;width:100%;height:190px;">
        <canvas id="regChart" role="img" aria-label="Barras de registros semanales">
          Semanas S1–S8: 28, 42, 35, 58, 47, 63, 71, 88 registros.
        </canvas>
      </div>
    </div>

    <!-- Actividad reciente -->
    <div class="card">
      <div class="card-head">
        <div class="card-title">Actividad reciente</div>
        <span class="badge badge-new">En vivo</span>
      </div>
      <div>
        <div class="activity-item">
          <div class="act-dot" style="background:#534AB7;"></div>
          <div>
            <div class="act-label"><strong>Carlos M.</strong> <span>inició sesión</span></div>
            <div class="act-time">hace 3 min</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="act-dot" style="background:#1D9E75;"></div>
          <div>
            <div class="act-label"><strong>Sofía R.</strong> <span>cuenta creada</span></div>
            <div class="act-time">hace 11 min</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="act-dot" style="background:#BA7517;"></div>
          <div>
            <div class="act-label"><strong>M. Herrera</strong> <span>contraseña fallida ×3</span></div>
            <div class="act-time">hace 24 min</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="act-dot" style="background:#A32D2D;"></div>
          <div>
            <div class="act-label"><strong>T. Vargas</strong> <span>cuenta bloqueada</span></div>
            <div class="act-time">hace 47 min</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="act-dot" style="background:#534AB7;"></div>
          <div>
            <div class="act-label"><strong>Valeria N.</strong> <span>verificación completa</span></div>
            <div class="act-time">hace 1 h</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="act-dot" style="background:#1D9E75;"></div>
          <div>
            <div class="act-label"><strong>Pablo G.</strong> <span>cuenta creada</span></div>
            <div class="act-time">hace 2 h</div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Tres columnas inferiores -->
  <div class="three-col">

    <!-- Últimos usuarios -->
    <div class="card">
      <div class="card-head">
        <div class="card-title">Últimos registros</div>
        <span class="card-subtitle">5 recientes</span>
      </div>
      <table class="user-table">
        <thead>
          <tr>
            <th>Usuario</th>
            <th style="text-align:right;">Estado</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <span class="u-ava">CM</span>
              <div style="display:inline-block;vertical-align:middle;">
                <div>Carlos Mendoza</div>
                <div class="u-email">c.mendoza@mail.com</div>
              </div>
            </td>
            <td style="text-align:right;"><span class="badge badge-ok">activo</span></td>
          </tr>
          <tr>
            <td>
              <span class="u-ava">SR</span>
              <div style="display:inline-block;vertical-align:middle;">
                <div>Sofía Rincón</div>
                <div class="u-email">sofia.r@gmail.com</div>
              </div>
            </td>
            <td style="text-align:right;"><span class="badge badge-new">nuevo</span></td>
          </tr>
          <tr>
            <td>
              <span class="u-ava">MH</span>
              <div style="display:inline-block;vertical-align:middle;">
                <div>Martín Herrera</div>
                <div class="u-email">m.herrera@corp.co</div>
              </div>
            </td>
            <td style="text-align:right;"><span class="badge badge-pend">pendiente</span></td>
          </tr>
          <tr>
            <td>
              <span class="u-ava">VN</span>
              <div style="display:inline-block;vertical-align:middle;">
                <div>Valeria Nieto</div>
                <div class="u-email">val.nieto@out.com</div>
              </div>
            </td>
            <td style="text-align:right;"><span class="badge badge-ok">activo</span></td>
          </tr>
          <tr>
            <td>
              <span class="u-ava">TV</span>
              <div style="display:inline-block;vertical-align:middle;">
                <div>Tomás Vargas</div>
                <div class="u-email">t.vargas@net.co</div>
              </div>
            </td>
            <td style="text-align:right;"><span class="badge badge-err">bloqueado</span></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Origen tráfico -->
    <div class="card">
      <div class="card-head">
        <div class="card-title">Origen del tráfico</div>
        <span class="card-subtitle">este mes</span>
      </div>
      <div style="position:relative;width:100%;height:160px;margin-bottom:16px;">
        <canvas id="pieChart" role="img" aria-label="Gráfica circular de origen del tráfico">
          Directo 42%, Orgánico 28%, Referido 18%, Social 12%.
        </canvas>
      </div>
      <div style="display:flex;flex-direction:column;gap:2px;">
        <div class="stat-row">
          <div class="stat-label">Directo</div>
          <div class="stat-bar-wrap"><div class="stat-bar" style="width:84%;"></div></div>
          <div class="stat-val">42%</div>
        </div>
        <div class="stat-row">
          <div class="stat-label">Orgánico</div>
          <div class="stat-bar-wrap"><div class="stat-bar" style="width:56%;background:#1D9E75;"></div></div>
          <div class="stat-val">28%</div>
        </div>
        <div class="stat-row">
          <div class="stat-label">Referido</div>
          <div class="stat-bar-wrap"><div class="stat-bar" style="width:36%;background:#D85A30;"></div></div>
          <div class="stat-val">18%</div>
        </div>
        <div class="stat-row">
          <div class="stat-label">Social</div>
          <div class="stat-bar-wrap"><div class="stat-bar" style="width:24%;background:#BA7517;"></div></div>
          <div class="stat-val">12%</div>
        </div>
      </div>
    </div>

    <!-- Estado del sistema -->
    <div class="card">
      <div class="card-head">
        <div class="card-title">Estado del sistema</div>
        <span class="badge badge-ok">Operativo</span>
      </div>
      <div style="display:flex;flex-direction:column;gap:0;">
        <div class="activity-item">
          <div class="act-dot" style="background:#1D9E75;margin-top:4px;"></div>
          <div style="flex:1;">
            <div style="display:flex;justify-content:space-between;align-items:center;">
              <div class="act-label">Base de datos</div>
              <span class="badge badge-ok">online</span>
            </div>
            <div class="act-time">Supabase · latencia 24ms</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="act-dot" style="background:#1D9E75;margin-top:4px;"></div>
          <div style="flex:1;">
            <div style="display:flex;justify-content:space-between;align-items:center;">
              <div class="act-label">Servidor PHP</div>
              <span class="badge badge-ok">online</span>
            </div>
            <div class="act-time">Uptime 99.9% · 30 días</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="act-dot" style="background:#BA7517;margin-top:4px;"></div>
          <div style="flex:1;">
            <div style="display:flex;justify-content:space-between;align-items:center;">
              <div class="act-label">Correo SMTP</div>
              <span class="badge badge-pend">degradado</span>
            </div>
            <div class="act-time">Cola: 3 mensajes pendientes</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="act-dot" style="background:#1D9E75;margin-top:4px;"></div>
          <div style="flex:1;">
            <div style="display:flex;justify-content:space-between;align-items:center;">
              <div class="act-label">Almacenamiento</div>
              <span class="badge badge-ok">ok</span>
            </div>
            <div class="act-time">1.2 GB / 10 GB usados</div>
          </div>
        </div>
        <div class="activity-item" style="border:none;">
          <div class="act-dot" style="background:#1D9E75;margin-top:4px;"></div>
          <div style="flex:1;">
            <div style="display:flex;justify-content:space-between;align-items:center;">
              <div class="act-label">Certificado SSL</div>
              <span class="badge badge-ok">válido</span>
            </div>
            <div class="act-time">Vence en 87 días</div>
          </div>
        </div>
      </div>
    </div>

  </div>

</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
(function() {
  const fontMono = "'DM Mono', monospace";
  const gridC  = 'rgba(0,0,0,0.05)';
  const tickC  = '#A1A1AA';

  // Barras de registros
  new Chart(document.getElementById('regChart'), {
    type: 'bar',
    data: {
      labels: ['S1','S2','S3','S4','S5','S6','S7','S8'],
      datasets: [
        {
          label: 'Registros',
          data: [28, 42, 35, 58, 47, 63, 71, 88],
          backgroundColor: '#534AB7',
          borderRadius: 5,
          barPercentage: 0.55
        },
        {
          label: 'Activos',
          data: [20, 30, 28, 40, 38, 55, 60, 75],
          backgroundColor: '#5DCAA5',
          borderRadius: 5,
          barPercentage: 0.55
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        x: {
          grid: { display: false },
          ticks: { font: { family: fontMono, size: 11 }, color: tickC }
        },
        y: {
          grid: { color: gridC },
          ticks: { font: { family: fontMono, size: 11 }, color: tickC },
          beginAtZero: true
        }
      }
    }
  });

  // Dona origen tráfico
  new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
      labels: ['Directo','Orgánico','Referido','Social'],
      datasets: [{
        data: [42, 28, 18, 12],
        backgroundColor: ['#534AB7','#1D9E75','#D85A30','#BA7517'],
        borderWidth: 0,
        hoverOffset: 5
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '70%',
      plugins: { legend: { display: false } }
    }
  });
})();
</script>

</body>
</html>