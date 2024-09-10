<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen del Reporte</title>
    <!-- Agregar Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="firebase-config.js"></script>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        /* Contenedor principal */
        .container {
            max-width: 600px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: auto;
        }

        /* Encabezado */
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        /* Estilo para los iconos */
        .icon {
            margin-right: 10px;
            color: #555;
        }

        /* Mensaje de agradecimiento */
        .thank-you {
            margin-top: 20px;
            text-align: center;
            font-style: italic;
            color: #777;
        }

        /* Botón de cerrar */
        .btn-close {
            background-color: #e74c3c;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 100px;
        }

        /* Cambiar el color de fondo cuando el cursor está sobre el botón */
        .btn-close:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Resumen del Reporte</h2>
    <!-- ID del Reporte -->
    <p><i class="fas fa-id-card icon"></i><strong>ID del Reporte:</strong> <?php echo isset($_GET['report_id']) ? $_GET['report_id'] : ''; ?></p>
    <!-- Área -->
    <p><i class="fas fa-map-marked icon"></i><strong>Área:</strong> <?php echo isset($_GET['area']) ? $_GET['area'] : ''; ?></p>
    <!-- Resumen del Problema -->
    <p><i class="fas fa-exclamation-triangle icon"></i><strong>Resumen del Problema:</strong> <?php echo isset($_GET['problema']) ? $_GET['problema'] : ''; ?></p>
    <!-- Imagen -->
    <?php
    $imagen = isset($_GET['imagen']) ? $_GET['imagen'] : '';
    if (!empty($imagen)) {
        echo '<p><i class="fas fa-image icon"></i><strong>Imagen:</strong> <img src="' . $imagen . '" alt="Imagen del Reporte" style="max-width: 100%;"></p>';
    }
    ?>
    <!-- Mensaje de agradecimiento -->
    <p class="thank-you">¡Gracias por enviar el reporte!</p>
    <!-- Botón de cerrar con icono -->
    <button class="btn-close" onclick="window.location.href = 'index1.php';">Cerrar</button>
</div>


</body>
<?php
// Llamada a la función para enviar el resumen por Telegram
$mensaje = "Nuevo reporte: Se ha detectado un problema en el sistema.";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost:5000/enviar_reporte_telegram?mensaje=" . urlencode($mensaje));
curl_exec($ch);
curl_close($ch);
?>

</html>

