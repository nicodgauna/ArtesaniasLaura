<?php
require("../includes/auth.php"); // protege la página
require("../config/conndb.php");

$mensaje = "";
$id = $_GET['id'];

$sql = "SELECT * FROM productos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);

    // Configuración de subida
    $uploadDir = "../uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // crea carpeta si no existe
    }

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['imagen']['tmp_name'];
        $fileName = basename($_FILES['imagen']['name']);
        $fileSize = $_FILES['imagen']['size'];
        $fileType = mime_content_type($tmpName);

        // Validaciones
        $extensionesValidas = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $extensionesValidas)) {
            $mensaje = "❌ Solo se permiten imágenes JPG, PNG o GIF.";
        } elseif ($fileSize > 2 * 1024 * 1024) { // 2 MB máx
            $mensaje = "❌ La imagen es demasiado grande (máx 2MB).";
        } else {
            // Renombrar archivo
            $nuevoNombre = time() . "_" . preg_replace("/[^a-zA-Z0-9\._-]/", "_", $fileName);
            $rutaFinal = $uploadDir . $nuevoNombre;

            if (move_uploaded_file($tmpName, $rutaFinal)) {
                $imagenUrl = "uploads/" . $nuevoNombre;

                // Editar en la BD
                $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, imagen_url=?
                        WHERE id=?";
                $stmt = $conexion->prepare($sql);
                // nombre (s), descripcion (s), precio (d), stock (i), imagen (s)
                $stmt->bind_param("ssdisi", $nombre, $descripcion, $precio, $stock, $imagenUrl, $producto["id"]);

                if ($stmt->execute()) {
                    $_SESSION['mensaje'] = "✅ Producto Editado con éxito.";
                    header("Location: admin-productos.php");
                } else {
                    $mensaje = "❌ Error en la BD: " . $conexion->error;
                }
            } else {
                $mensaje = "❌ Error al mover la imagen.";
            }
        }
    } else {
        $mensaje = "❌ Debes seleccionar una imagen.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Producto - Admin</title>
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="stylesheet" href="../css/dashboard.css">
  <link rel="stylesheet" href="../css/producto-nuevo.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
  <link rel="icon" href="../IMAGENES/LOGO1.png">
</head>
<body>
  <!-- Header (igual al dashboard) -->
  <header class="header">
    <div class="container">
      <div class="logo">
        <a href="dashboard.php">
          <img src="../IMAGENES/LOGO.png" alt="Logo">
        </a>
      </div>
      <nav class="nav">
        <ul class="nav-menu">
          <li><a href="admin-productos.php"> Productos</a></li>
          <li><a href="../includes/logout.php"> Cerrar Sesión</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Main -->
  <main class="dashboard">
    <div class="container">
      <h1>Editar <?=$producto['nombre']?></h1>

      <?php if (!empty($mensaje)): ?>
        <p class="<?= strpos($mensaje, '✅') !== false ? 'success-message' : 'error-message' ?>">
          <?= htmlspecialchars($mensaje) ?>
        </p>
      <?php endif; ?>

      <form class="product-form" action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="nombre">Nombre:</label>
          <input type="text" id="nombre" name="nombre" value="<?=$producto['nombre']?>" required >
        </div>

        <div class="form-group">
          <label for="descripcion">Descripción:</label>
          <textarea id="descripcion" name="descripcion" rows="3"><?=$producto['descripcion']?></textarea>
        </div>

        <div class="form-group">
          <label for="precio">Precio:</label>
          <input type="number" id="precio" step="0.01" name="precio"value="<?=$producto['precio']?>" required>
        </div>

        <div class="form-group">
          <label for="stock">Stock:</label>
          <input type="number" min="0" id="stock" name="stock" value="<?=$producto['stock']?>" required>
        </div>

        <div class="form-group">
          <label for="imagen">Imagen:</label>
          <input type="file" id="imagen" name="imagen" accept="image/*" required>
        </div>

        <!-- Vista previa -->
        <div class="image-preview" id="imagePreview" style="display:none;">
          <img id="previewImg" src="#" alt="Vista previa">
          <div class="preview-info">
            <div id="previewName"></div>
            <small id="previewSize"></small>
          </div>
        </div>

        <button type="submit" class="btn"><i class="fas fa-save"></i> Guardar Edicion</button>
      </form>

      <p><a href="admin-productos.php">⬅ Volver a Productos</a></p>
    </div>
  </main>

  <!-- Footer (igual al dashboard) -->
  <footer class="footer">
    <div class="container">
      <div class="footer-bottom">
        &copy; <span id="year"></span> Mi Tienda - Panel Admin
      </div>
    </div>
  </footer>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();

    // Vista previa imagen
    document.addEventListener('DOMContentLoaded', function(){
      const input = document.getElementById('imagen');
      const previewWrapper = document.getElementById('imagePreview');
      const previewImg = document.getElementById('previewImg');
      const previewName = document.getElementById('previewName');
      const previewSize = document.getElementById('previewSize');

      if (!input) return;

      input.addEventListener('change', function(){
        const file = this.files[0];
        if (!file) { previewWrapper.style.display = 'none'; return; }

        const allowed = ['image/jpeg','image/png','image/gif'];
        const maxSize = 2 * 1024 * 1024; // 2MB

        if (!allowed.includes(file.type)) {
          alert('Solo se permiten imágenes JPG, PNG o GIF.');
          this.value = '';
          previewWrapper.style.display = 'none';
          return;
        }

        if (file.size > maxSize) {
          alert('La imagen supera el máximo permitido (2 MB).');
          this.value = '';
          previewWrapper.style.display = 'none';
          return;
        }

        // Vista previa
        previewImg.src = URL.createObjectURL(file);
        previewImg.onload = () => URL.revokeObjectURL(previewImg.src);
        previewName.textContent = file.name;
        previewSize.textContent = Math.round(file.size / 1024) + ' KB';
        previewWrapper.style.display = 'flex';
      });
    });
  </script>
</body>
</html>