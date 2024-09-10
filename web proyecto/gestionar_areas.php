<?php
session_start();
include('db_connection.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['admin_id'])) {
    header("Location: inicio-sesion.php");
    exit();
}

// Agregar nueva área
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_area'])) {
    $nombre_area = $_POST['nombre_area'];
    if (!empty($nombre_area)) {
        $query = "INSERT INTO areas (nombre) VALUES (?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $nombre_area);
        if ($stmt->execute()) {
            echo "<p>Área agregada exitosamente.</p>";
        } else {
            echo "<p>Error al agregar área.</p>";
        }
        $stmt->close();
    }
}

// Eliminar área
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_area'])) {
    $id_area = $_POST['id_area'];
    if (!empty($id_area)) {
        $query = "DELETE FROM areas WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_area);
        if ($stmt->execute()) {
            echo "<p>Área eliminada exitosamente.</p>";
        } else {
            echo "<p>Error al eliminar área.</p>";
        }
        $stmt->close();
    }
}

// Obtener áreas
$query = "SELECT * FROM areas";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Áreas</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ecf0f1;
            display: flex;
            height: 100vh;
            overflow: hidden;
            margin-left: 0px;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar .logo {
            font-size: 26px;
            font-weight: 700;
            color: #ecf0f1;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #ecf0f1;
            text-decoration: none;
            margin: 15px 0;
            padding: 12px;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .sidebar a:hover {
            background-color: #34495e;
            transform: scale(1.05);
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
            background-color: #ffffff;
            height: 100vh;
            overflow-y: auto;
            transition: margin-left 0.3s ease;
        }

        .main-content h2 {
            color: #2c3e50;
            font-size: 28px;
            margin-left: 250px;
        }

        .main-content p {
            font-size: 18px;
            color: #34495e;
            
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            color: #fff;
            background-color: #e74c3c;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        .form-container {
            margin-bottom: 20px;
            margin-left: 100px;
        }

        table {
            width: 50%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
            margin-left: 50px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">Panel de Control</div>
        <a href="gestionar_areas.php"><i class="fa fa-cogs"></i> Gestionar Áreas</a>
        <a href="ver_reportes.php"><i class="fa fa-file-text"></i> Ver Reportes</a>
        <a href="gestionar_usuarios.php"><i class="fa fa-users"></i> Gestionar Usuarios</a> <!-- Nueva opción -->
        <a href="dashboard.php"><i class="fa fa-tachometer"></i> Volver al Panel de Control</a>
        <button class="btn" onclick="window.location.href='logout.php'"><i class="fa fa-sign-out"></i> Cerrar Sesión</button>
    </aside>

    <div class="main-content">
        <h2>Gestionar Áreas</h2>
        
        <!-- Formulario para agregar área -->
        <div class="form-container">
            <h3>Agregar Nueva Área</h3>
            <form action="gestionar_areas.php" method="POST">
                <label for="nombre_area">Nombre del Área:</label>
                <input type="text" id="nombre_area" name="nombre_area" required>
                <button type="submit" name="agregar_area" class="btn">Agregar Área</button>
            </form>
        </div>

        <!-- Formulario para eliminar área -->
        <div class="form-container">
            <h3>Eliminar Área</h3>
            <form action="gestionar_areas.php" method="POST">
                <label for="id_area">ID del Área:</label>
                <input type="number" id="id_area" name="id_area" required>
                <button type="submit" name="eliminar_area" class="btn">Eliminar Área</button>
            </form>
        </div>

        <!-- Tabla de áreas -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
