<?php
session_start();
include('db_connection.php'); // Incluye tu conexión a la base de datos

$error_message = ""; // Inicializa el mensaje de error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'login') {
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        // Consulta para verificar las credenciales
        $query = "SELECT * FROM administradores WHERE usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            // Verificar la contraseña
            if (password_verify($contrasena, $admin['contrasena'])) {
                // Verificar el estado del usuario
                if ($admin['estado'] == 'activo') {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_nombre'] = $admin['nombre'];
                    header("Location: dashboard.php");
                    exit(); // Asegúrate de salir después de redirigir
                } elseif ($admin['estado'] == 'pendiente') {
                    header("Location: espera.html");
                    exit();
                } elseif ($admin['estado'] == 'denegado') {
                    header("Location: rechazado.html");
                    exit();
                }
            } else {
                $error_message = "Contraseña incorrecta.";
            }
        } else {
            $error_message = "Usuario no encontrado.";
        }

        $stmt->close();
        
        if (!empty($error_message)) {
            // Redirigir con mensaje de error
            header("Location: inicio-sesion.php?error=" . urlencode($error_message));
            exit();
        }
    } elseif ($action == 'register') {
        $nuevo_usuario = $_POST['nuevo_usuario'];
        $nueva_contrasena = $_POST['nueva_contrasena'];

        // Verificar si el usuario ya existe
        $query = "SELECT * FROM administradores WHERE usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $nuevo_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "El usuario ya existe.";
            header("Location: inicio-sesion.php?error=" . urlencode($error_message));
            exit();
        } else {
            // Hash de la contraseña
            $hash_contrasena = password_hash($nueva_contrasena, PASSWORD_BCRYPT);

            // Insertar nuevo administrador
            $query = "INSERT INTO administradores (nombre, usuario, contrasena) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $nombre = $nuevo_usuario; // Puedes ajustar esto según tus necesidades
            $stmt->bind_param("sss", $nombre, $nuevo_usuario, $hash_contrasena);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: register_success.php");
                exit(); // Asegúrate de salir después de redirigir
            } else {
                $error_message = "Error al registrar el administrador.";
                header("Location: inicio-sesion.php?error=" . urlencode($error_message));
                exit();
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>