<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login & Registration</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <style>
        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <nav class="nav">
            <div class="nav-logo">
                <!-- Puedes agregar un logo aquí -->
            </div>
            <div class="nav-menu" id="navMenu">
                <ul>
                    <!-- Opciones del menú -->
                </ul>
            </div>
            <div class="nav-button">
                <button class="btn white-btn" id="loginBtn" onclick="showLogin()">Login</button>
                <button class="btn" id="registerBtn" onclick="showRegister()">Register</button>
                <!-- Botón de Salir -->
                <button class="btn" id="logoutBtn" onclick="window.location.href='index1.php'">Salir</button>
            </div>
            <div class="nav-menu-btn">
                <i class="bx bx-menu" onclick="myMenuFunction()"></i>
            </div>
        </nav>

        <div class="form-box">
            <!-- login form -->
            <div class="login-container" id="login">
                <div class="top">
                    <span>No tienes una cuenta? <a href="#" onclick="showRegister()">Registrar</a></span>
                    <header>Login</header>
                </div>
                <form id="loginForm" action="login.php" method="POST">
                    <input type="hidden" name="action" value="login">
                    <div class="input-box">
                        <input type="text" class="input-field" name="usuario" placeholder="Usuario" required>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" class="input-field" name="contrasena" placeholder="Contraseña" required>
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="input-box">
                        <input type="submit" class="submit" value="Login">
                    </div>
                    <?php if (isset($error_message)): ?>
                        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
                    <?php endif; ?>
                </form>
            </div>

            <!-- registration form -->
            <div class="register-container" id="register">
                <div class="top">
                    <span>¿Ya tienes cuenta? <a href="#" onclick="showLogin()">Login</a></span>
                    <header>Registrar</header>
                </div>
                <form action="login.php" method="POST">
                    <input type="hidden" name="action" value="register">
                    <div class="input-box">
                        <input type="text" class="input-field" name="nuevo_usuario" placeholder="Usuario" required>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" class="input-field" name="nueva_contrasena" placeholder="Contraseña" required>
                        <i class="bx bx-lock-alt"></i>
                    </div>
                    <div class="input-box">
                        <input type="submit" class="submit" value="Registrar">
                    </div>
                    <?php if (isset($error_message)): ?>
                        <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>   

    <script>
        function myMenuFunction() {
            var i = document.getElementById("navMenu");
            if(i.className === "nav-menu") {
                i.className += " responsive";
            } else {
                i.className = "nav-menu";
            }
        }

        function showLogin() {
            document.getElementById("login").style.left = "0px";
            document.getElementById("register").style.right = "-520px";
            document.getElementById("loginBtn").classList.add("white-btn");
            document.getElementById("registerBtn").classList.remove("white-btn");
            document.getElementById("login").style.opacity = 1;
            document.getElementById("register").style.opacity = 0;
        }

        function showRegister() {
            document.getElementById("login").style.left = "-520px";
            document.getElementById("register").style.right = "0px";
            document.getElementById("loginBtn").classList.remove("white-btn");
            document.getElementById("registerBtn").classList.add("white-btn");
            document.getElementById("login").style.opacity = 0;
            document.getElementById("register").style.opacity = 1;
        }

        // Inicializar mostrando el formulario de login
        showLogin();
    </script>
</body>
</html>
