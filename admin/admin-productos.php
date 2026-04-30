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
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
  <link rel="icon" href="../IMAGENES/LOGO1.png">
</head>
<body>
 
  <header class="header">
    <div class="container">
      <div class="logo">
        <a href="dashboard.php">
          <img src="../IMAGENES/LOGO.png" alt="Logo">
        </a>
      </div>
      <nav class="nav">
        <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
        </div>
        <ul class="nav-menu">
          <li><a href="admin-productos.php">Productos</a></li>
          <li><a href="../includes/logout.php">Cerrar Sesión</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Contenido principal -->
  <main class="dashboard">
    <div class="container">
      <h1>Gestión de Productos</h1>
      <?php if (isset($_SESSION['mensaje'])): ?>
        <p class="<?= strpos($_SESSION['mensaje'], '✅') !== false ? 'success-message' : 'error-message' ?>">
          <?= htmlspecialchars($_SESSION['mensaje']) ?>
        </p>
        <?php unset($_SESSION['mensaje']); ?>
      <?php endif; ?>
      <p><a href="producto-nuevo.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Producto
      </a></p>

      <div class="table-responsive"> 
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
                      <a href="editar-productos.php?id=<?=$resultado['id']?>" class="btn btn-sm"><i class="fas fa-edit"></i> Editar</a>
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
    </div>
  </main>

  <footer class="footer">
    <div class="container">
      <div class="footer-bottom">
        &copy; <span id="year"></span> Artesanias Laura - Panel Admin
      </div>
    </div>
  </footer>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();

    function confirmarEliminar(id) {
      if (confirm("¿Seguro que querés eliminar este producto?")) {
        window.location.href = "eliminar-producto.php?id=" + id;
      }
    }
  </script>
  <script src="../js/script.js"></script>
</body>
</html>
