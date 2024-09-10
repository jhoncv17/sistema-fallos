<?php
// Ruta donde se almacenan las imágenes
$ruta_imagenes = 'C:/xampp/htdocs/nuevo 1.1/contadores/';

// Obtener el nombre de la imagen de la URL
$nombre_imagen = isset($_GET['imagen']) ? $_GET['imagen'] : '';

// Ruta completa de la imagen
$ruta_completa = $ruta_imagenes . $nombre_imagen;

// Verificar si la imagen existe
if (file_exists($ruta_completa)) {
    // Establecer la cabecera de la respuesta como una imagen
    header('Content-Type: image/jpeg');

    // Mostrar la imagen
    readfile($ruta_completa);
} else {
    // Si la imagen no existe, mostrar una imagen de reemplazo o un mensaje de error
    // Puedes personalizar esto según tus necesidades
    echo 'Imagen no encontrada';
}
?>
