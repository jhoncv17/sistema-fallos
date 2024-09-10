<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"> 
    <title>DEPTO.INFORMATICA</title>
    <style>
       /* Estilos para el overlay */
#overlay {
    display: none; /* Inicialmente oculto */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6); /* Color de fondo oscuro */
    z-index: 999;
}

/* Estilos para el modal */
#securityCodeModal {
    display: none; /* Inicialmente oculto */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #f4f4f4; /* Fondo claro */
    padding: 20px;
    border-radius: 10px; /* Bordes redondeados */
    border: 1px solid #ddd;
    width: 90%;
    max-width: 400px; /* Tamaño máximo para pantallas grandes */
    text-align: center;
    z-index: 1000;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Sombra suave */
    box-sizing: border-box; /* Incluye padding y border en el tamaño total */
}

/* Estilos para el encabezado del modal */
#securityCodeModal h3 {
    margin: 0 0 15px;
    font-size: 1.2em;
    color: #333; /* Color de texto oscuro para mejor legibilidad */
}

/* Estilos para el campo de entrada */
#securityCodeModal input {
    width: calc(100% - 22px); /* Ajusta el ancho con padding y border */
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1em;
    box-sizing: border-box; /* Incluye padding y border en el tamaño total */
}

/* Estilos para los botones */
#securityCodeModal button {
    padding: 12px 25px;
    font-size: 1em;
    color: #fff;
    background-color: #007bff; /* Color corporativo azul */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

/* Efecto hover para botones */
#securityCodeModal button:hover {
    background-color: #0056b3; /* Color más oscuro en hover */
    transform: scale(1.05); /* Escala ligera para efecto de presión */
}

/* Estilos para el botón de cancelar */
#securityCodeModal button.cancel {
    background-color: #6c757d; /* Color gris para el botón de cancelar */
}

#securityCodeModal button.cancel:hover {
    background-color: #5a6268; /* Color más oscuro en hover para cancelar */
}

    </style>
</head>
<body>
    <header>
        <div class="contenedor">
            <h2 class="logotipo">DEPTO.INFORMATICA</h2>
            <nav>
                
                
            </nav>
        </div>
    </header>

    <main>
        <div class="pelicula-principal">
            <div class="contenedor">
                <h3 class="titulo">Reporte de fallos</h3>
                <p class="descripcion">
                   
                </p>
                <button id="openReportFormButton" role="button" class="boton" onclick="redirectToReportes()"><i style="font-size:24px" class="fa">&#xf007;</i>Nuevo reporte</button>
 
                <script>
                    function redirectToReportes() {
                        window.location.href = "reportes.php";
                    }
                </script>

                <button id="asistenciaPresencialButton" role="button" class="boton" onclick="redirigirWhatsApp()"><i class="fa fa-users"></i>Asistencia presencial</button>

                <script>
                    function redirigirWhatsApp() {
                        var mensaje = "Buenos días! por favor envia tu nombre y area para solicitar la asistencia presencial.";
                        var numeroWhatsApp = "918676480";
                        var enlaceWhatsApp = "https://api.whatsapp.com/send?phone=" + numeroWhatsApp + "&text=" + encodeURIComponent(mensaje);
                        window.location.href = enlaceWhatsApp;
                    }
                </script>

                <!-- Nuevo botón para Administradores -->
                <button id="adminLoginButton" role="button" class="boton"><i class="fa fa-lock"></i>Administradores</button>

                <!-- Modal para el código de seguridad -->
                <div id="overlay"></div>
                <div id="securityCodeModal">
                    <h3>Ingrese el Código de Seguridad</h3>
                    <input type="password" id="securityCodeInput" placeholder="Código de Seguridad">
                    <br><br>
                    <button onclick="checkSecurityCode()">Aceptar</button>
                    <button onclick="closeModal()">Cancelar</button>
                </div>

                <script>
                    function showSecurityCodeModal() {
                        document.getElementById('overlay').style.display = 'block';
                        document.getElementById('securityCodeModal').style.display = 'block';
                    }

                    function closeModal() {
                        document.getElementById('overlay').style.display = 'none';
                        document.getElementById('securityCodeModal').style.display = 'none';
                    }

                    function checkSecurityCode() {
                        var inputCode = document.getElementById('securityCodeInput').value;

                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'verify_security_code.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                var response = JSON.parse(xhr.responseText);
                                if (response.valid) {
                                    window.location.href = 'inicio-sesion.php'; // Redirige a la página de login.php si el código es correcto
                                } else {
                                    window.location.href = 'error.php'; // Redirige a la página de error.php si el código es incorrecto
                                }
                            } else {
                                alert('Error al verificar el código.');
                            }
                        };

                        xhr.send('code=' + encodeURIComponent(inputCode));
                    }

                    document.getElementById('adminLoginButton').addEventListener('click', showSecurityCodeModal);
                </script>

            </div>
        </div>
    </main>

    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
    
</body>
</html>

