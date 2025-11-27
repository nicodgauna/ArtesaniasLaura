<?php
require ("../includes/auth.php"); // Protege la página
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Mi Tienda</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="index.php">
                    <img src="https://via.placeholder.com/120" alt="Logo">
                    <span>Admin Panel</span>
                </a>
            </div>
            <nav class="nav">
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-menu">
                    <li><a href="admin-productos.php"><i class="fas fa-box"></i> Productos</a></li>
                    <li><a href="ordenes.php"><i class="fas fa-shopping-cart"></i> Órdenes</a></li>
                    <li><a href="../includes/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="dashboard">
        <div class="container">
            <h1>Bienvenido, <?= htmlspecialchars($_SESSION['admin_nombre']) ?> 👋</h1>
            <p>Este es tu panel de administración. Desde aquí podés gestionar productos y revisar órdenes.</p>

            <div class="dashboard-cards">
                <div class="card">
                    <i class="fas fa-box fa-2x"></i>
                    <h3>Productos</h3>
                    <p>Gestiona el catálogo de productos.</p>
                    <a href="productos.php" class="btn">Ir a productos</a>
                </div>

                <div class="card">
                    <i class="fas fa-shopping-cart fa-2x"></i>
                    <h3>Órdenes</h3>
                    <p>Revisa y actualiza el estado de las órdenes.</p>
                    <a href="ordenes.php" class="btn">Ir a órdenes</a>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-bottom">
                &copy; <span id="year"></span> Mi Tienda - Panel Admin
            </div>
        </div>
    </footer>
    <script src="../js/script.js"></script>
    <script>
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
</body>
</html>
