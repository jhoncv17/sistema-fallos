<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <title>Error de Seguridad</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            text-align: center;
            background-color: #f4f4f4; /* Fondo claro para la página */
            color: #333; /* Color de texto oscuro */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff; /* Fondo blanco para el contenedor */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra sutil */
        }

        .error-message {
            color: #e74c3c; /* Rojo más suave para el mensaje de error */
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        .error-description {
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .button {
            display: inline-block;
            padding: 12px 25px;
            font-size: 1em;
            color: #fff;
            background-color: #007bff; /* Azul corporativo */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .button:hover {
            background-color: #0056b3; /* Azul más oscuro en hover */
            transform: scale(1.05); /* Escala ligera en hover */
        }

        /* Estilos responsivos */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .error-message {
                font-size: 1.5em;
            }

            .error-description {
                font-size: 1em;
            }

            .button {
                padding: 10px 20px;
                font-size: 0.9em;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 10px;
                margin: 20px;
            }

            .error-message {
                font-size: 1.3em;
            }

            .error-description {
                font-size: 0.9em;
            }

            .button {
                padding: 8px 15px;
                font-size: 0.8em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="error-message"><i class="fa fa-exclamation-circle"></i> Código de Seguridad Incorrecto</h1>
        <p class="error-description">El código que ingresaste es incorrecto. Por favor, intenta nuevamente.</p>
        <a href="index1.php" class="button"><i class="fa fa-arrow-left"></i> Volver a Intentar</a>
    </div>
</body>
</html>
