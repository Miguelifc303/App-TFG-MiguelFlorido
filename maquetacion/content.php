<?php
include("db.php");
include("scripts.php");
include("controller_graficas.php");

$solicitudesPorMes = getClientesPorMes();
$clientesPorMecanico = getCitasPorMecanico();
?>

<div class="charts-container">
  <!-- Gráfica Clientes por mes -->
  <div class="chart-box">
    <h3>Clientes por mes</h3>
    <canvas id="clientesMesChart"></canvas>
    <table class="table">
      <thead>
        <tr><th>Mes</th><th>Total Clientes</th></tr>
      </thead>
      <tbody>
        <?php foreach ($solicitudesPorMes as $fila): ?>
        <tr>
          <td><?= $fila['mes'] ?></td>
          <td><?= $fila['total'] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Gráfica Citas por Mecánico -->
  <div class="chart-box">
    <h3>Citas por Mecánico</h3>
    <canvas id="clientesMecanicoChart"></canvas>
    <table class="table">
      <thead>
        <tr><th>Mecánico</th><th>Total Citas</th></tr>
      </thead>
      <tbody>
        <?php foreach ($clientesPorMecanico as $fila): ?>
        <tr>
          <td><?= htmlspecialchars($fila['mecanico']) ?></td>
          <td><?= $fila['total_citas'] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Datos Clientes por mes
  const solicitudesPorMes = <?= json_encode($solicitudesPorMes) ?>;
  const labelsMes = solicitudesPorMes.map(item => item.mes);
  const dataMes = solicitudesPorMes.map(item => item.total);

  // Gráfico barras verticales para clientes por mes
  new Chart(document.getElementById('clientesMesChart'), {
    type: 'bar',
    data: {
      labels: labelsMes,
      datasets: [{
        label: 'Clientes con Solicitudes',
        data: dataMes,
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: true }},
      scales: {
        y: { beginAtZero: true, title: { display: true, text: 'Clientes únicos' }},
        x: { title: { display: true, text: 'Mes' }}
      }
    }
  });

  // Datos Citas por mecánico
  const clientesPorMecanico = <?= json_encode($clientesPorMecanico) ?>;
  const labelsMecanico = clientesPorMecanico.map(item => item.mecanico);
  const dataMecanico = clientesPorMecanico.map(item => item.total_citas);

  // Gráfico barras horizontales para citas por mecánico
  new Chart(document.getElementById('clientesMecanicoChart'), {
    type: 'bar',
    data: {
      labels: labelsMecanico,
      datasets: [{
        label: 'Citas por Mecánico',
        data: dataMecanico,
        backgroundColor: 'rgba(255, 159, 64, 0.6)',
        borderColor: 'rgba(255, 159, 64, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(value) {
              return Number.isInteger(value) ? value : null;
            },
            stepSize: 1
          },
          title: {
            display: true,
            text: 'Cantidad de Citas'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Mecánico'
          }
        }
      }
    }
  });
</script>

<link rel="stylesheet" href="maquetacion/styleGraficas.css" />
