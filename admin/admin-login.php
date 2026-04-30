<?php
session_start();
require ("../config/conndb.php");

$usuario = '';
$password = '';

if (isset($_SESSION['admin_id'])){
    header("Location: ../admin/dashboard.php"); // Panel admin
    exit;}

if ($_SERVER['REQUEST_METHOD'] = "POST"){
    if (isset($_POST['usuario']) && isset($_POST['password'])){
        
        $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
        $password = mysqli_real_escape_string($conexion, $_POST['password']);
        $sql = "SELECT id, nombre, password, rol FROM usuarios WHERE nombre = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $usuario); // "s" = string

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verificar password
            if (password_verify($password, $user['password'])) {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_nombre'] = $user['nombre'];
                $_SESSION['rol'] = $user['rol'];
                header("Location: ../admin/dashboard.php"); // Panel admin
                exit;
            } else {
                $error = "Usuario o contraseña incorrectos.";
            }
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    }
}

?>





<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador - Mi Tienda Online</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/admin-login.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="icon" href="../IMAGENES/LOGO1.png">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="../index.php">
                    <img src="../IMAGENES/LOGO.PNG" alt="Logo de Mi Tienda">
                </a>
            </div>
            
            <nav class="nav">
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-menu">
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="../pages/productos.php">Productos</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Login Section -->
    <section class="login-section">
        <div class="container">
            <div class="login-container">
                <div class="login-header">
                    <i class="fas fa-user-shield"></i>
                    <h1>Acceso Administrador</h1>
                    <p>Ingresa tus credenciales para acceder al panel de administración</p>
                </div>
                
                <form class="login-form" action="" method="POST">
                    <div class="form-group">
                        <label for="usuario">
                            <i class="fas fa-user"></i>
                            Usuario
                        </label>
                        <input type="text" id="usuario" name="usuario" required placeholder="Ingresa tu usuario">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Contraseña
                        </label>
                        <div class="password-input">
                            <input type="password" id="password" name="password" required placeholder="Ingresa tu contraseña">
                            <button type="button" class="toggle-password" onclick="togglePassword()">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    
                    
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Iniciar Sesión
                    </button>

                    <!-- Mostrar error si existe -->
                    <?php if (!empty($error)): ?>
                        <p class="error-message"><?= htmlspecialchars($error) ?></p>
                    <?php endif; ?>
                </form>
                
                <div class="login-footer">
                    <a href="index.html" class="back-link">
                        <i class="fas fa-arrow-left"></i>
                        Volver a la tienda
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Artesanias Laura</h3>
                    <p>Ofrecemos los mejores productos con la mejor calidad para decorar tu jardin.</p>
                </div>
                <div class="footer-section">
                    <h3>Enlaces</h3>
                    <ul>
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="pages/productos.php">Productos</a></li>
                        <li><a href="https://wa.me/5491138784077?text=Hola!%20Quiero%20consultar%20por%20sus%20productos">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Síguenos</h3>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="https://wa.me/5491138784077?text=Hola!%20Quiero%20consultar%20por%20sus%20productos"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; <span id="year"></span> Artesanias Laura. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <!-- Overlay para cuando el carrito está abierto -->
    <div class="overlay"></div>

    <script src="js/script.js"></script>
    <script>
        // Función para mostrar/ocultar contraseña
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.querySelector('.toggle-password i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.classList.remove('fa-eye');
                toggleButton.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleButton.classList.remove('fa-eye-slash');
                toggleButton.classList.add('fa-eye');
            }
        }
        
        // Establecer año actual en el footer
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
</body>
</html>
