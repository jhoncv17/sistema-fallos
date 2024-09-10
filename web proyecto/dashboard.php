<?php
session_start();

// Establecer encabezados para evitar el almacenamiento en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['admin_id'])) {
    // Si no está autenticado, redirigir al login
    header("Location: inicio-sesion.php");
    exit();
}

// El resto de tu código para la página protegida



$nombre_admin = $_SESSION['admin_nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
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
            margin-bottom: 20px;
            margin-left: 250px;
        }

        .main-content p {
            font-size: 18px;
            color: #34495e;
            margin-left: 250px;
        }

        .logout-btn {
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

        .logout-btn:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="logo">Panel de Control</div>
    <a href="gestionar_areas.php"><i class="fa fa-cogs"></i> Gestionar Áreas</a>
    <a href="ver_reportes.php"><i class="fa fa-file-text"></i> Ver Reportes</a>
    <a href="gestionar_usuarios.php"><i class="fa fa-users"></i> Gestionar Usuarios</a> <!-- Nueva opción -->
    <button class="logout-btn" onclick="window.location.href='logout.php'"><i class="fa fa-sign-out"></i> Cerrar Sesión</button>
</aside>


    <div class="main-content">
        <h2>Hola, <?php echo htmlspecialchars($nombre_admin); ?>. ¡Bienvenido al Panel de Control!</h2>
        <p>Utiliza el menú lateral para navegar entre las diferentes secciones del panel.</p>
    </div>
</body>
</html>
