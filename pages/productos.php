<?php

include("../config/conndb.php");

$orden = $_GET['orden'] ?? 'default';
$pagina = max(1, (int)($_GET['pagina'] ?? 1));

$por_pagina = 12;
$offset = ($pagina - 1) * $por_pagina;

switch($orden){

    case 'price-low':
        $order_sql = "ORDER BY precio ASC";
        break;

    case 'price-high':
        $order_sql = "ORDER BY precio DESC";
        break;

    case 'name':
        $order_sql = "ORDER BY nombre ASC";
        break;

    default:
        $order_sql = "";
}

$sql = "SELECT * FROM productos $order_sql LIMIT $por_pagina OFFSET $offset";

$stmt = $conexion->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$sql_total = "SELECT COUNT(*) as total FROM productos";
$total = $conexion->query($sql_total)->fetch_assoc()['total'];

$total_paginas = ceil($total / $por_pagina);


/* RESPUESTA AJAX */
if(isset($_GET['ajax'])){

    echo '<div class="products-grid">';

    while($producto = $result->fetch_assoc()){

        $precio_formateado = number_format($producto['precio'], 0, ',', '.');
        echo '

        <div class="product-card">
            <a href="producto.php?id='.$producto['id'].'">
                <div class="product-image">
                    <img src="../'.$producto['imagen_url'].'" alt="'.$producto['nombre'].'">
                </div>

                <div class="product-info">
                    <h3>'.$producto['nombre'].'</h3>
                    <p>'.$producto['descripcion'].'</p>
                    <div class="product-price">$'.$precio_formateado.'</div>
                </div>
            </a>
        </div>

        ';

    }

    echo '</div>';

    echo '<div class="pagination">';

    $rango = 2;

    $inicio = max(1, $pagina - $rango);
    $fin = min($total_paginas, $pagina + $rango);

    if($inicio > 1){
        echo '<button class="pagination-number" data-page="1">1</button>';

        if($inicio > 2){
            echo '<span class="pagination-dots">...</span>';
        }
    }

    for($i = $inicio; $i <= $fin; $i++){

        $active = ($i == $pagina) ? 'active' : '';

        echo '<button class="pagination-number '.$active.'" data-page="'.$i.'">'.$i.'</button>';
    }

    if($fin < $total_paginas){

        if($fin < $total_paginas - 1){
            echo '<span class="pagination-dots">...</span>';
        }

        echo '<button class="pagination-number" data-page="'.$total_paginas.'">'.$total_paginas.'</button>';
    }

    echo '</div>';

    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Mi Tienda Online</title>
    <title>Artesanias Laura - Artesanías y decoración para jardín</title>
    <meta name="description" content="Artesanías Laura ofrece productos artesanales en madera, decoración y regalos únicos hechos a mano. Consultanos por WhatsApp.">
    <meta name="keywords" content="artesanías, decoración de jardín, muebles de jardín, artesanías en madera, Merlo Buenos Aires">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/productos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="icon" href="../IMAGENES/LOGO1.png">
</head>
<body>

    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="../index.php">
                <img src="../IMAGENES/LOGO.png">
                </a>
            </div>
            <nav class="nav">
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-menu">
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="productos.php">Productos</a></li>
                    <li><a href="https://wa.me/5491138784077?text=Hola!%20Quiero%20consultar%20por%20sus%20productos">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="page-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="../index.php">Inicio</a>
                <span><i class="fas fa-chevron-right"></i></span>
                <span>Productos</span>
            </div>
            <h1>Todos los Productos</h1>
            <p>Descubre nuestra amplia selección de productos para tu jardín.</p>
        </div>
    </section>

    <section class="filters-section">

        <div class="container">

            <div class="filters-header">
                <h3>Filtrar Productos</h3>
            </div>

            <div class="filters-content">

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


    <section class="products-grid-section">

        <div class="container">

            <div class="products-header">

                <div class="results-count">
                    Mostrando <span id="results-count"><?=$total?></span> productos
                </div>

            </div>


            <div id="products-container">

                <div class="products-grid">

                    <?php

                        if ($total == 0){

                        echo "Aún no se han cargado productos.";

                        }

                        else{

                        while($resultado = $result->fetch_assoc()){

                    ?>

                    <div class="product-card">
                        <a href="producto.php?id=<?=$resultado['id']?>">
                            <div class="product-image">
                                <img src="../<?=$resultado['imagen_url']?>" alt="<?=$resultado['nombre']?>">
                            </div>

                            <div class="product-info">
                                <h3><?=$resultado['nombre']?></h3>
                                <p><?=$resultado['descripcion']?></p>
                                <div class="product-price">$<?=number_format($resultado['precio'], 0, ',', '.')?></div>
                            </div>
                        </a>
                    </div>

                    <?php

                        }}
                    ?>

                </div>


                <div class="pagination">

                    <?php

                        $rango = 2;

                        $inicio = max(1, $pagina - $rango);
                        $fin = min($total_paginas, $pagina + $rango);

                        if($inicio > 1){

                        echo '<button class="pagination-number" data-page="1">1</button>';

                        if($inicio > 2){
                        echo '<span class="pagination-dots">...</span>';
                        }

                        }

                        for($i = $inicio; $i <= $fin; $i++){

                        $active = ($i == $pagina) ? 'active' : '';

                        echo '<button class="pagination-number '.$active.'" data-page="'.$i.'">'.$i.'</button>';

                        }

                        if($fin < $total_paginas){

                        if($fin < $total_paginas - 1){
                        echo '<span class="pagination-dots">...</span>';
                        }

                        echo '<button class="pagination-number" data-page="'.$total_paginas.'">'.$total_paginas.'</button>';

                        }

                    ?>

                </div>

            </div>

        </div>

    </section>

<footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Artesanias Laura</h3>
                    <p>Ofrecemos los mejores productos con la mejor calidad para decorar tu jardín.</p>
                </div>
                <div class="footer-section">
                    <h3>Enlaces</h3>
                    <ul>
                        <li><a href="../index.php">Inicio</a></li>
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

    <script>

        let ordenActual = "default";

        function cargarProductos(pagina = 1){

        fetch("productos.php?ajax=1&orden=" + ordenActual + "&pagina=" + pagina)

        .then(res => res.text())

        .then(data => {

        document.getElementById("products-container").innerHTML = data;

        });

        }


        document.getElementById("sort-select").addEventListener("change", function(){

        ordenActual = this.value;

        cargarProductos(1);

        });


        document.addEventListener("click", function(e){

        if(e.target.classList.contains("pagination-number")){

        e.preventDefault();

        let pagina = e.target.dataset.page;

        cargarProductos(pagina);

        window.scrollTo({

        top: document.getElementById("products-container").offsetTop - 100,
        behavior: "smooth"

        });

        }

        });

    </script>

</body>
</html>
