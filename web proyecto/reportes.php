<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Fallos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="reportes.css">
</head>
<body>
    <h2>Reporte de Fallos</h2>
    <form action="ReportesFallas.php" method="POST">
        <input type="hidden" name="report_id" value="<?php echo sha1(uniqid(rand(), true)); ?>">
        <label for="area">Seleccione su área:</label>
        <select id="area" name="area" required>
            <option value="" disabled selected>Selecciona una opción</option>
            <?php
            // Incluir la conexión a la base de datos
            include 'db_connection.php';

            // Consultar las áreas desde la base de datos
            $sql = "SELECT nombre FROM areas";
            $result = $conn->query($sql);

            // Verificar si hay resultados y generar las opciones del select
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['nombre'] . "'>" . $row['nombre'] . "</option>";
                }
            } else {
                echo "<option value='' disabled>No hay áreas disponibles</option>";
            }

            // Cerrar la conexión
            $conn->close();
            ?>
        </select>
        <div>
            <label for="problema">Describa el problema o fallo que presenta:</label>
            <textarea id="problema" name="problema" rows="4" required></textarea>
        </div>
        <button type="submit">Enviar Reporte</button>
    </form>
    <script>
        // Obtener el icono de carga
        var uploadIcon = document.getElementById("upload-icon");

        // Obtener el elemento de entrada de tipo archivo
        var fileInput = document.getElementById("imagen");

        // Agregar un evento de clic al icono
        uploadIcon.addEventListener("click", function() {
            fileInput.click(); // Hacer clic en el input de tipo archivo cuando se hace clic en el icono
        });
    </script>
</body>
</html>
