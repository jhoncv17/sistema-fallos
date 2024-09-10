<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['admin_id'])) {
    header("Location: inicio-sesion.php");
    exit();
}

$nombre_admin = $_SESSION['admin_nombre'];

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "ReportesFallasDB");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejo de eliminación de usuario
if (isset($_GET['action']) && $_GET['action'] == 'eliminar' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM administradores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Manejo de autorización/denegación de usuario
if (isset($_GET['action']) && in_array($_GET['action'], ['autorizar', 'denegar', 'pendiente']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $estado = $_GET['action'];
    $estadoTexto = ($estado == 'autorizar') ? 'activo' : (($estado == 'denegar') ? 'denegado' : 'pendiente');
    $sql = "UPDATE administradores SET estado = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $estadoTexto, $id);
    $stmt->execute();
    $stmt->close();
    
    $nombre_usuario = $conn->query("SELECT nombre FROM administradores WHERE id = $id")->fetch_assoc()['nombre'];

    echo "<script>
        alert('El usuario \"$nombre_usuario\" ha sido " . ($estadoTexto == 'activo' ? "activado" : ($estadoTexto == 'denegado' ? "rechazado" : "marcado como pendiente")) . ".');
        window.location.href = 'gestionar_usuarios.php';
    </script>";
    exit();
}

// Manejo de actualización de contraseña
if (isset($_POST['actualizar_contrasena'])) {
    $id = intval($_POST['id']);
    $nueva_contrasena = password_hash($_POST['nueva_contrasena'], PASSWORD_BCRYPT);
    $sql = "UPDATE administradores SET contrasena = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nueva_contrasena, $id);
    $stmt->execute();
    $stmt->close();

    echo "<script>
        alert('La contraseña ha sido actualizada.');
        window.location.href = 'gestionar_usuarios.php';
    </script>";
    exit();
}

// Consultar usuarios
$sql = "SELECT * FROM administradores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Estilos actualizados */
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
            transition: transform 0.3s ease, width 0.3s ease;
            transform: translateX(0);
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

        .main-content {
            margin-left: 250px;
            padding: 50px;
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
        h3{
            font-size: 28px;
            margin-bottom: 20px;
            margin-left: 100px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            margin-right: 5px;
        }

        .btn-autorizar {
            background-color: #2ecc71;
            color: #fff;
        }

        .btn-denegar {
            background-color: #e74c3c;
            color: #fff;
        }

        .btn-pendiente {
            background-color: #f39c12;
            color: #fff;
        }

        .btn-eliminar {
            background-color: #c0392b;
            color: #fff;
        }

        .btn-editar {
            background-color: #3498db;
            color: #fff;
        }

        .edit-form {
            margin-top: 20px;
        }

        .sidebar .logout-btn {
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

        .sidebar .logout-btn:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
                height: 100%;
                overflow-y: auto;
            }

            .main-content {
                margin-left: 200px;
                padding: 10px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                transform: translateX(0);
            }

            .sidebar.closed {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<aside class="sidebar">
    <div class="logo">Panel de Control</div>
    <a href="gestionar_areas.php"><i class="fa fa-cogs"></i> Gestionar Áreas</a>
    <a href="ver_reportes.php"><i class="fa fa-file-text"></i> Ver Reportes</a>
    <a href="gestionar_usuarios.php"><i class="fa fa-users"></i> Gestionar Usuarios</a>
    <button class="logout-btn" onclick="window.location.href='logout.php'"><i class="fa fa-sign-out"></i> Cerrar Sesión</button>
</aside>

<div class="main-content">
    <h2>Hola, <?php echo htmlspecialchars($nombre_admin); ?>. Gestión de Usuarios</h2>

    <h3>Agregar Nuevo Usuario</h3>
    <form action="agregar_usuario.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <button type="submit" class="btn btn-autorizar">Agregar Usuario</button>
    </form>

    <h3>Lista de Usuarios</h3>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td><?php echo htmlspecialchars($row['usuario']); ?></td>
                <td><?php echo htmlspecialchars($row['estado']); ?></td>
                <td>
                    <a href="gestionar_usuarios.php?action=autorizar&id=<?php echo $row['id']; ?>" class="btn btn-autorizar"><i class="fa fa-check"></i> Autorizar</a>
                    <a href="gestionar_usuarios.php?action=denegar&id=<?php echo $row['id']; ?>" class="btn btn-denegar"><i class="fa fa-times"></i> Denegar</a>
                    <a href="gestionar_usuarios.php?action=pendiente&id=<?php echo $row['id']; ?>" class="btn btn-pendiente"><i class="fa fa-clock-o"></i> Pendiente</a>
                    <a href="gestionar_usuarios.php?action=eliminar&id=<?php echo $row['id']; ?>" class="btn btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario?');"><i class="fa fa-trash"></i> Eliminar</a>
                    <button class="btn btn-editar" onclick="mostrarFormularioEditar('<?php echo $row['id']; ?>', '<?php echo $row['nombre']; ?>');"><i class="fa fa-pencil"></i> Editar</button>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <!-- Formulario para actualizar la contraseña -->
    <div id="editForm" class="edit-form" style="display: none;">
        <h3>Actualizar Contraseña</h3>
        <form action="gestionar_usuarios.php" method="post">
            <input type="hidden" name="id" id="editId">
            <label for="editNombre">Nombre:</label>
            <input type="text" id="editNombre" name="nombre" readonly>
            <label for="nueva_contrasena">Nueva Contraseña:</label>
            <input type="password" id="nueva_contrasena" name="nueva_contrasena" required>
            <button type="submit" name="actualizar_contrasena" class="btn btn-editar">Actualizar</button>
        </form>
    </div>
</div>

<script>
function mostrarFormularioEditar(id, nombre) {
    document.getElementById('editId').value = id;
    document.getElementById('editNombre').value = nombre;
    document.getElementById('editForm').style.display = 'block';
}
</script>
</body>
</html>

<?php
$conn->close();
?>

