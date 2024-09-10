<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }

        h2 {
            color: #2ecc71;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin-bottom: 30px;
        }
        .icon {
            width: 60px;
            height: 60px;
            margin-bottom: 20px;
        }

        a.button {
            display: inline-block;
            padding: 12px 25px;
            font-size: 16px;
            color: #ffffff;
            background-color: #3498db;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s, transform 0.3s;
        }

        a.button:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
    <img src="/web proyecto/images/escaneo-facial.gif" alt="Cargando" class="icon">
        <h2>Registro Exitoso</h2>
        <p>¡Te has registrado exitosamente! Puedes</p>
        <a href="inicio-sesion.php" class="button">Iniciar Sesion aquí.</a>
    </div>
</body>
</html>
