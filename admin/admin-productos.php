<?php
require("../includes/auth.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos - Admin</title>
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/admin-productos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <!-- Header igual al dashboard -->
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
          <li><a href="productos.php"><i class="fas fa-box"></i> Productos</a></li>
          <li><a href="ordenes.php"><i class="fas fa-shopping-cart"></i> Órdenes</a></li>
          <li><a href="../includes/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Contenido principal -->
  <main class="dashboard">
    <div class="container">
      <h1>Gestión de Productos</h1>

      <p><a href="producto-nuevo.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Producto
      </a></p>

      <table class="tabla-productos">
        <thead>
          <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Ejemplo: reemplazalo con loop en PHP -->
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
                <tr>
                    <td><img src="../<?=$resultado['imagen_url']?>" alt= "Producto" class="thumb"></td>
                    <td><?=$resultado['nombre']?></td>
                    <td>$ <?=$resultado['precio']?></td>
                    <td><?=$resultado['stock']?></td>
                    <td>
                    <a href="producto_editar.php?id=<?=$resultado['id']?>" class="btn btn-sm"><i class="fas fa-edit"></i> Editar</a>
                    <button class="btn btn-sm btn-danger" onclick="confirmarEliminar(<?=$resultado['id']?>)">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                    </td>
                 </tr>
          <?php endwhile;   
                }  
          ?>  
        </tbody>
      </table>
    </div>
  </main>

  <!-- Footer igual al dashboard -->
  <footer class="footer">
    <div class="container">
      <div class="footer-bottom">
        &copy; <span id="year"></span> Mi Tienda - Panel Admin
      </div>
    </div>
  </footer>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();

    function confirmarEliminar(id) {
      if (confirm("¿Seguro que querés eliminar este producto?")) {
        window.location.href = "producto_eliminar.php?id=" + id;
      }
    }
  </script>
  <script src="../js/script.js"></script>
</body>
</html>
