<?php
include('db_connection.php'); // Asegúrate de que este archivo esté correctamente configurado

// Recupera el código ingresado
$inputCode = $_POST['code'];

// Recupera el código de seguridad almacenado en la base de datos
$query = "SELECT valor FROM configuracion WHERE clave = 'admin_password'";
$result = $conn->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $storedHash = $row['valor'];
    
    // Verifica el código ingresado contra el hash almacenado
    if (password_verify($inputCode, $storedHash)) {
        echo json_encode(['valid' => true]);
    } else {
        echo json_encode(['valid' => false]);
    }
} else {
    echo json_encode(['valid' => false]);
}
?>
