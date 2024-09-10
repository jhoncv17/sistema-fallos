<?php
session_start();
include('db_connection.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit();
}

// Lógica para obtener los reportes
$query = "SELECT * FROM registrofallas";
$result = $conn->query($query);

// Obtener los datos para el gráfico
$areas = [];
$reporte_counts = [];

while ($row = $result->fetch_assoc()) {
    $area = $row['area'];
    if (!isset($areas[$area])) {
        $areas[$area] = 0;
    }
    if ($row['enviado'] == 1) {
        $areas[$area]++;
    }
}

$area_labels = array_keys($areas);
$report_counts = array_values($areas);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Reportes</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .image-container {
            max-width: 200px;
        }
        .image-container img {
            width: 100%;
            height: auto;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .form-container {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        #myChart {
            max-width: 600px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ver Reportes</h2>
        <a href="dashboard.php" class="btn">Volver al Panel de Control</a>

        <!-- Botón para generar gráfico -->
        <button onclick="generateChart()" class="btn">Generar Gráfico</button>

        <!-- Canvas para el gráfico -->
        <div id="chart-container">
            <canvas id="myChart" style="display: none;"></canvas>
        </div>

        <!-- Tabla de reportes -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Área</th>
                    <th>Problema</th>
                    <th>Imagen</th>
                    <th>Enviado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar los reportes en la tabla
                $result->data_seek(0); // Reiniciar el puntero del resultado
                while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['report_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['area']); ?></td>
                    <td><?php echo htmlspecialchars($row['problema']); ?></td>
                    <td>
                        <?php if ($row['imagen']): ?>
                        <div class="image-container">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($row['imagen']); ?>" alt="Imagen del reporte">
                        </div>
                        <?php else: ?>
                        No disponible
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row['enviado'] ? 'Sí' : 'No'; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function generateChart() {
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($area_labels); ?>,
                    datasets: [{
                        label: 'Número de Reportes Enviados',
                        data: <?php echo json_encode($report_counts); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Mostrar el gráfico y ocultar el botón
            document.getElementById('myChart').style.display = 'block';
        }
    </script>
</body>
</html>
