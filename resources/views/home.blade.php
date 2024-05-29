<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Farmacia Online</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <nav class="navbar navbar-dark bg-success">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Farmacia</a>
      <form class="form-inline">
        <input class="form-control mr-sm-2" type="search" placeholder="Buscar medicamento" aria-label="Search">
      </form>
    </div>
  </nav>

  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-md-3">
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action bg-success text-light active">Inicio</a>
          <a href="#" class="list-group-item list-group-item-action">Pedidos</a>
          <a href="#" class="list-group-item list-group-item-action">Inventario</a>
          <a href="#" class="list-group-item list-group-item-action">Clientes</a>
          <a href="#" class="list-group-item list-group-item-action">Reportes</a>
          <a href="#" class="list-group-item list-group-item-action">Configuración</a>
        </div>
      </div>
      <div class="col-md-9">
        <h2>Número de Ventas</h2>
        <div class="btn-group mb-3">
          <button type="button" class="btn btn-success">Compartir</button>
          <button type="button" class="btn btn-success">Exportar</button>
          <div class="btn-group">
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Esta semana
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Este mes</a>
              <a class="dropdown-item" href="#">Último trimestre</a>
              <a class="dropdown-item" href="#">Año hasta la fecha</a>
            </div>
          </div>
        </div>
        <canvas id="ventasChart"></canvas>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    // Datos del gráfico y configuración
    var chartData = {
      labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
      datasets: [{
        label: 'Número de Ventas',
        data: [120, 180, 240, 200, 160, 90, 110],
        backgroundColor: 'rgba(40, 167, 69, 0.2)', // Color verde claro con opacidad
        borderColor: 'rgba(40, 167, 69, 1)', // Color verde oscuro sólido
        borderWidth: 1
      }]
    };

    var chartOptions = {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    };

    // Crear el gráfico
    var ctx = document.getElementById('ventasChart').getContext('2d');
    var ventasChart = new Chart(ctx, {
      type: 'line',
      data: chartData,
      options: chartOptions
    });
  </script>
</body>
</html>