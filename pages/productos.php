<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Mi Tienda Online</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/productos.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="../index.html">
                    <img src="https://via.placeholder.com/150" alt="Logo de Mi Tienda">
                    <span>Mi Tienda</span>
                </a>
            </div>
            
            <nav class="nav">
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-menu">
                    <li><a href="../index.html">Inicio</a></li>
                    <li class="dropdown">
                        <a href="productos.html" class="active">Productos <i class="fas fa-chevron-down"></i></a>
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html">Inicio</a>
                <span><i class="fas fa-chevron-right"></i></span>
                <span>Productos</span>
            </div>
            <h1>Todos los Productos</h1>
            <p>Descubre nuestra amplia selección de productos de alta calidad</p>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="filters-section">
        <div class="container">
            <div class="filters-header">
                <h3>Filtrar Productos</h3>
                <button class="filters-toggle">
                    <i class="fas fa-filter"></i>
                    Filtros
                </button>
            </div>
            
            <div class="filters-content">
                
                <div class="filter-group">
                    <h4>Precio</h4>
                    <div class="price-range">
                        
                        <input type="range" id="price-max" min="0" max="100" value="100">
                        <div class="price-values">
                            <span>$<span id="min-value">0</span></span>
                            <span>$<span id="max-value">100</span></span>
                        </div>
                    </div>
                </div>
                
                <div class="filter-group">
                    <h4>Ordenar por</h4>
                    <select id="sort-select">
                        <option value="default">Por defecto</option>
                        <option value="price-low">Precio: Menor a Mayor</option>
                        <option value="price-high">Precio: Mayor a Menor</option>
                        <option value="name">Nombre A-Z</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="products-grid-section">
        <div class="container">
            <div class="products-header">
                <div class="results-count">
                    Mostrando <span id="results-count">24</span> productos
                </div>
                <div class="view-toggle">
                    <button class="view-btn active" data-view="grid">
                        <i class="fas fa-th"></i>
                    </button>
                    <button class="view-btn" data-view="list">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>
            
            <div class="products-grid" id="products-container">

                <?php
                    include ("../config/conndb.php")  ;
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
                                <!-- Carga de productos -->
                                <div class="product-card" data-id=<?=$resultado['id']?> data-name=<?=$resultado['nombre']?> data-price=<?=$resultado['precio']?> data-category="categoria1">
                                    <div class="product-image">
                                        <img src="../<?=$resultado['imagen_url']?>" alt=<?=$resultado['nombre']?>>
                                        <div class="product-badges">
                                            <span class="badge new">Nuevo</span>
                                        </div>
                                        <div class="product-actions">
                                            <button class="action-btn quick-view" data-id="1">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="action-btn add-to-wishlist" data-id="1">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <div class="product-category">Categoría 1</div>
                                        <h3><?=$resultado['nombre']?></h3>
                                        <p><?=$resultado['descripcion']?></p>
                                        <div class="product-price">$<?=$resultado['precio']?></div>
                                        <button class="btn add-to-cart">Añadir al Carrito</button>
                                    </div>
                                </div>
                                <?php endwhile; 
                                }  
                                ?>  
                
                <!-- Continuar con más productos hasta completar 24 -->
                <!-- Productos adicionales para demostrar la funcionalidad completa -->
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                <button class="pagination-btn prev" disabled>
                    <i class="fas fa-chevron-left"></i>
                    Anterior
                </button>
                <div class="pagination-numbers">
                    <button class="pagination-number active">1</button>
                    <button class="pagination-number">2</button>
                    <button class="pagination-number">3</button>
                    <span class="pagination-dots">...</span>
                    <button class="pagination-number">8</button>
                </div>
                <button class="pagination-btn next">
                    Siguiente
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
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

    <script src="../js/script.js"></script>
    
</body>
</html>
