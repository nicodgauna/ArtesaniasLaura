<?php

include("../config/conndb.php");

// Obtener el ID del producto desde la URL
$producto_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($producto_id <= 0) {
    header("Location: productos.php");
    exit();
}

// Obtener datos del producto
$sql = "SELECT * FROM productos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $producto_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: productos.php");
    exit();
}

$producto = $result->fetch_assoc();

// Obtener productos relacionados (excluyendo el actual)
$sql_relacionados = "SELECT * FROM productos WHERE id != ? ORDER BY RAND() LIMIT 4";
$stmt_rel = $conexion->prepare($sql_relacionados);
$stmt_rel->bind_param("i", $producto_id);
$stmt_rel->execute();
$productos_relacionados = $stmt_rel->get_result();

// Formatear precio
$precio = number_format($producto['precio'], 0, ',', '.');
$precio_original = number_format(($producto['precio'] * 100)/80, 0, ',', '.'); // Simular precio anterior con 20% más

// Calcular cuotas
$cuota_12 = number_format($producto['precio'] / 12, 0, ',', '.');
$cuota_6 = number_format($producto['precio'] / 6, 0, ',', '.');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($producto['nombre']) ?> - Artesanias Laura</title>
    <meta name="description" content="<?= htmlspecialchars($producto['descripcion']) ?>">
    <meta name="keywords" content="artesanías, decoración de jardín, <?= htmlspecialchars($producto['nombre']) ?>">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/productos.css">
    <link rel="stylesheet" href="../css/producto.css">
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
                    <img src="../IMAGENES/LOGO.png" alt="Logo de Artesanias Laura">
                </a>
            </div>
            <nav class="nav">
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-menu">
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="productos.php" >Productos</a></li>
                    <li><a href="https://wa.me/5491138784077?text=Hola!%20Quiero%20consultar%20por%20sus%20productos">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Breadcrumb -->
    <section class="page-header1">
        <div class="container">
            <div class="breadcrumb">
                <a href="../index.php">Inicio</a>
                <span><i class="fas fa-chevron-right"></i></span>
                <a href="productos.php">Productos</a>
                <span><i class="fas fa-chevron-right"></i></span>
                <span class="current"><?= htmlspecialchars($producto['nombre']) ?></span>
            </div>
        </div>
    </section>

    <!-- Product Detail -->
    <section class="product-detail-section">
        <div class="container">
            <div class="product-detail-container">
                
                <!-- Image Gallery -->
                <div class="product-gallery">
                    <div class="main-image">
                        <img src="../<?= htmlspecialchars($producto['imagen_url']) ?>" 
                             alt="<?= htmlspecialchars($producto['nombre']) ?>" 
                             id="main-product-image">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="product-info-detail">
                    <span class="product-brand">Artesanias Laura</span>
                    <h1 class="product-title"><?= htmlspecialchars($producto['nombre']) ?></h1>

                    <!-- Price Section -->
                    <div class="price-section">
                        <div class="price-original">
                            <span class="price-old">$<?= $precio_original ?></span>
                            <span class="discount-badge">20% OFF</span>
                        </div>
                        <div class="price-current">$<?= $precio ?></div>
                        <p class="price-note">Precio final. Impuestos incluidos.</p>
                    </div>

                    <!-- Promotions 
                    <div class="promotions-section">
                        <h4 class="promotions-title">Opciones de pago</h4>
                        
                        <div class="promotion-item">
                            <i class="fas fa-credit-card" style="color: #4a6de5;"></i>
                            <div class="promotion-installments">
                                <strong>12 cuotas</strong> de <span>$<?= $cuota_12 ?></span>
                            </div>
                        </div>

                        <div class="promotion-item">
                            <i class="fas fa-credit-card" style="color: #4a6de5;"></i>
                            <div class="promotion-installments">
                                <strong>6 cuotas</strong> de <span>$<?= $cuota_6 ?></span>
                            </div>
                        </div>

                        <div class="payment-methods">
                            <span style="font-size: 12px; color: #666; width: 100%; margin-bottom: 5px;">Aceptamos:</span>
                            <i class="fab fa-cc-visa" style="font-size: 28px; color: #1a1f71;"></i>
                            <i class="fab fa-cc-mastercard" style="font-size: 28px; color: #eb001b;"></i>
                            <i class="fab fa-cc-amex" style="font-size: 28px; color: #006fcf;"></i>
                        </div>
                    </div>-->

                    <!-- Shipping -->
                    <div class="shipping-section">
                        <div class="shipping-item">
                            <i class="fas fa-truck shipping-icon"></i>
                            <div class="shipping-info">
                                <h4>Envio a domicilio</h4>
                                <p>Consultanos por WhatsApp para conocer costos de envio</p>
                            </div>
                        </div>

                        <div class="shipping-item">
                            <i class="fas fa-store shipping-icon"></i>
                            <div class="shipping-info">
                                <h4>Retiro <span class="free">GRATIS</span> en nuestro local</h4>
                                <p>Berazategui, Buenos Aires</p>
                                <a href="https://wa.me/5491138784077?text=Hola!%20Quiero%20coordinar%20el%20retiro%20de%20<?= urlencode($producto['nombre']) ?>">Coordinar retiro</a>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Status -->
                    <div class="stock-status in-stock">
                        <i class="fas fa-check-circle"></i>
                        <span>Stock disponible</span>
                    </div>

                    <!-- Quantity Selector 
                    <div class="quantity-section">
                        <label>Cantidad:</label>
                        <div class="quantity-selector">
                            <button class="quantity-btn" onclick="changeQuantity(-1)">-</button>
                            <input type="number" class="quantity-input" id="quantity" value="1" min="1" max="10">
                            <button class="quantity-btn" onclick="changeQuantity(1)">+</button>
                        </div>
                    </div>-->

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="https://wa.me/5491138784077?text=Hola!%20Quiero%20comprar%20<?= urlencode($producto['nombre']) ?>%20($<?= $precio ?>)" 
                           class="btn-buy btn-whatsapp" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                            Comprar por WhatsApp
                        </a>
                        <a href="https://wa.me/5491138784077?text=Hola!%20Quiero%20consultar%20sobre%20<?= urlencode($producto['nombre']) ?>" 
                           class="btn-buy btn-buy-secondary" target="_blank">
                            Consultar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product Description -->
            <div class="product-description-section">
                <h3>Descripcion del producto</h3>
                <p><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>

                <div class="product-features">
                    <h4>Caracteristicas</h4>
                    <ul class="features-list">
                        <li>
                            <i class="fas fa-check"></i>
                            Hecho a mano con materiales de alta calidad
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Ideal para decorar tu jardin o espacio exterior
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Resistente a la intemperie
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Producto artesanal unico
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <?php if ($productos_relacionados->num_rows > 0): ?>
    <section class="related-products-section">
        <div class="container">
            <h3>Productos relacionados</h3>
            <div class="related-products-grid">
                <?php while($relacionado = $productos_relacionados->fetch_assoc()): ?>
                <div class="product-card">
                    <a href="producto.php?id=<?= $relacionado['id'] ?>">
                        <div class="product-image">
                            <img src="../<?= htmlspecialchars($relacionado['imagen_url']) ?>" 
                                 alt="<?= htmlspecialchars($relacionado['nombre']) ?>">
                        </div>
                        <div class="product-info">
                            <h3><?= htmlspecialchars($relacionado['nombre']) ?></h3>
                            <p><?= htmlspecialchars(substr($relacionado['descripcion'], 0, 80)) ?>...</p>
                            <div class="product-price">$<?= number_format($relacionado['precio'], 0, ',', '.') ?></div>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

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
                        <li><a href="../index.php">Inicio</a></li>
                        <li><a href="productos.php">Productos</a></li>
                        <li><a href="https://wa.me/5491138784077?text=Hola!%20Quiero%20consultar%20por%20sus%20productos">Contacto</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Siguenos</h3>
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

    <!-- WhatsApp Button -->
    <div class="whatsapp-container">
        <div class="whatsapp-text">
            Hola! En que podemos ayudarte?
        </div>
        <a href="https://wa.me/5491138784077?text=Hola!%20Quiero%20consultar%20por%20sus%20productos" target="_blank">
            <img src="../IMAGENES/whatsapp-logo.png" alt="WhatsApp">
        </a>
    </div>

    <script>
        // Cambiar imagen principal
        function changeImage(thumbnail) {
            const mainImage = document.getElementById('main-product-image');
            const thumbnailImg = thumbnail.querySelector('img');
            mainImage.src = thumbnailImg.src;
            
            // Actualizar clase activa
            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            thumbnail.classList.add('active');
        }

        // Selector de cantidad
        function changeQuantity(delta) {
            const input = document.getElementById('quantity');
            let value = parseInt(input.value) + delta;
            if (value < 1) value = 1;
            if (value > 10) value = 10;
            input.value = value;
        }

        // Año actual en footer
        document.getElementById('year').textContent = new Date().getFullYear();

        // Menu mobile toggle
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.nav-menu').classList.toggle('active');
        });
    </script>

</body>
</html>
