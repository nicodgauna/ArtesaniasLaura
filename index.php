<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda Online</title>
    <link rel="stylesheet" href="css/styles.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="index.html">
                    <img src="https://via.placeholder.com/150" alt="Logo de Mi Tienda">
                    <span>Mi Tienda</span>
                </a>
            </div>
            
            <nav class="nav">
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-menu">
                    <li><a href="index.html">Inicio</a></li>
                    <li class="dropdown">
                        <a href="pages/productos.php">Productos <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="categoria1.html">Categoría 1</a></li>
                            <li><a href="categoria2.html">Categoría 2</a></li>
                            <li><a href="categoria3.html">Categoría 3</a></li>
                        </ul>
                    </li>
                    <li><a href="quienes-somos.html">Quiénes Somos</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                    <li class="cart-icon">
                        <a href="#" id="cart-toggle">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count">0</span>
                        </a>
                        <!-- Resumen del carrito -->
                        <div class="cart-dropdown">
                            <h3>Carrito de Compras</h3>
                            <div class="cart-items">
                                <!-- Los items del carrito se cargarán dinámicamente con JavaScript -->
                            </div>
                            <div class="cart-total">
                                <p>Total: <span>$0.00</span></p>
                            </div>
                            <div class="cart-buttons">
                                <a href="carrito.html" class="btn">Ver Carrito</a>
                                <a href="checkout.html" class="btn btn-primary">Terminar Compra</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Bienvenido a Mi Tienda</h1>
            <p>Los mejores productos para ti</p>
            <a href="productos.html" class="btn">Ver Productos</a>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products">
        <div class="container">
            <h2>Nuestros Productos</h2>
            
            <div class="product-slider-container">
                <button class="slider-arrow prev-arrow">
                    <i class="fas fa-chevron-left"></i>
                </button>
                
                <div class="product-slider">

                    <div class="product-slider-track">
                        <!-- Carga de productos -->
                        <?php
                        include ("config/conndb.php")  ;
                        $sql = "SELECT * from productos";
                        $stmt = $conexion->prepare($sql);
                        $consulta = $stmt->execute();
                        if (!$consulta){
                                echo "
                                    <tr>
                                        Aun no se han cargado productos. 
                                    </tr>";
                        }
                        else {$result = $stmt->get_result();
                                while( $resultado = $result->fetch_assoc()): ?>
                                
                                <div class="product-card" data-id=<?=$resultado['id']?> data-name=<?=$resultado['nombre']?> data-price=<?=$resultado['precio']?>>
                                    <div class="product-image">
                                        <img src=<?=$resultado['imagen_url']?> alt=<?=$resultado['nombre']?>>
                                    </div>
                                    <div class="product-info">
                                        <h3><?=$resultado['nombre']?></h3>
                                        <p><?=$resultado['descripcion']?></p>
                                        <div class="product-price">$<?=$resultado['precio']?></div>
                                        <button class="btn add-to-cart">Añadir al Carrito</button>
                                    </div>
                                </div>
                        <?php endwhile;   
                                }  
                        ?>
                                 
                    </div>
                </div>
                
                <button class="slider-arrow next-arrow">
                    <i class="fas fa-chevron-right"></i>
                </button>
                
                <div class="slider-dots">
                    <!-- Los dots se generarán dinámicamente con JavaScript -->
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta">
        <div class="container">
            <h2>¿Listo para comprar?</h2>
            <p>Explora nuestra colección completa de productos</p>
            <a href="pages/productos.html" class="btn">Ver Todos los Productos</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Mi Tienda</h3>
                    <p>Ofrecemos los mejores productos con la mejor calidad para nuestros clientes.</p>
                </div>
                <div class="footer-section">
                    <h3>Enlaces</h3>
                    <ul>
                        <li><a href="index.html">Inicio</a></li>
                        <li><a href="productos.html">Productos</a></li>
                        <li><a href="quienes-somos.html">Quiénes Somos</a></li>
                        <li><a href="contacto.html">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Síguenos</h3>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; <span id="year"></span> Mi Tienda. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <!-- Overlay para cuando el carrito está abierto -->
    <div class="overlay"></div>

    <script src="js/script.js"></script>
</body>
</html>