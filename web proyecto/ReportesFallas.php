
<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Configuración de la conexión a la base de datos
    $host = 'localhost'; // Nombre del servidor donde está alojada la base de datos
    $dbname = 'ReportesFallasDB'; // Nombre de la base de datos
    $username = 'root'; // Nombre de usuario de la base de datos
    $password = ''; // Contraseña de la base de datos

    try {
        // Crear una nueva instancia de la clase PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        // Establecer el modo de error de PDO a excepción
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Opcional: Establecer el conjunto de caracteres a UTF-8
        $pdo->exec("SET NAMES 'utf8'");

        // Generar un report_id único
        $report_id = sha1(uniqid('', true));
        // Usar solo los primeros 20 caracteres del report_id
        $report_id = substr($report_id, 0, 20);

        // Recibir los datos del formulario
        $area = $_POST['area'];
        $problema = $_POST['problema'];

        // Preparar la consulta para insertar los datos en la tabla
        $sql = "INSERT INTO RegistroFallas (report_id, area, problema, enviado) VALUES (:report_id, :area, :problema, 0)";
        $stmt = $pdo->prepare($sql);

        // Vincular los parámetros de la consulta con los valores recibidos del formulario
        $stmt->bindParam(':report_id', $report_id);
        $stmt->bindParam(':area', $area);
        $stmt->bindParam(':problema', $problema);

        // Ejecutar la consulta
        $stmt->execute();

        // Redirigir al usuario a resumen_reporte.php y pasar los datos del reporte como parámetros de la URL
        header("Location: resumen_reporte.php?report_id=$report_id&area=$area&problema=$problema");
        exit(); // Detener la ejecución del script después de redirigir al usuario
    } catch (PDOException $e) {
        // Capturar y mostrar cualquier error de conexión
        die("Error al guardar el reporte: " . $e->getMessage());
    }
}
?>
