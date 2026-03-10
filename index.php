<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artesanias Laura - Artesanías y decoración para jardín</title>
    <meta name="description" content="Artesanías Laura ofrece productos artesanales en madera, decoración y regalos únicos hechos a mano. Consultanos por WhatsApp.">
    <meta name="keywords" content="artesanías, decoración de jardín, muebles de jardín, artesanías en madera, Merlo Buenos Aires">
    <link rel="stylesheet" href="css/styles.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="icon" href="IMAGENES/LOGO1.png">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="index.php">
                    <img src="IMAGENES/LOGO.png" alt="Logo de Artesanias Laura">
                    
                </a>
            </div>
            
            <nav class="nav">
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-menu">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="pages/productos.php">Productos</a></li>
                    <li><a href="https://wa.me/5491138784077?text=Hola!%20Quiero%20consultar%20por%20sus%20productos">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Artesanias Laura</h1>
            <h2>Muebles y adornos para jardín</h2>
            <a href="pages/productos.php" class="btn">Ver Productos</a>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products">
        <div class="container">
            <h3>Nuestros Productos</h3>
            
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
                                
                                <div class="product-card" data-id="<?=$resultado['id']?>" data-name="<?=$resultado['nombre']?>" data-price="<?=$resultado['precio']?>">
                                    <a href="pages/producto.php?id=<?=$resultado['id']?>">
                                        <div class="product-image">
                                            <img src="<?=$resultado['imagen_url']?>" alt="<?=$resultado['descripcion']?>">
                                        </div>
                                        <div class="product-info">
                                            <h3><?=$resultado['nombre']?></h3>
                                            <p><?=$resultado['descripcion']?></p>
                                            <div class="product-price">$<?=number_format($resultado['precio'], 0, ',', '.')?></div>
                                        </div>
                                    </a>
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
        <div class="prod-btn">
            <a href="pages/productos.php" class="btn">Ver Todos los Productos</a>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta">
        <div class="container">
            <h3>¿Listo para comprar?</h3>
            <p>Explora nuestra colección completa de productos</p>
            <a href="https://wa.me/5491138784077?text=Hola!%20Quiero%20consultar%20por%20sus%20productos" class="btn">Contactanos por Whatsapp</a>
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
    <div class="whatsapp-container">

        <div class="whatsapp-text">
            Hola 👋 ¿En qué podemos ayudarte?
        </div>
        <a href="https://wa.me/5491138784077?text=Hola!%20Quiero%20consultar%20por%20sus%20productos" target="_blank">
            <img src="IMAGENES/whatsapp-logo.png" alt="WhatsApp">
        </a>
    </div>                                
    <!-- Overlay para cuando el carrito está abierto -->
    <div class="overlay"></div>

    <script src="js/script.js"></script>
</body>
</html>
