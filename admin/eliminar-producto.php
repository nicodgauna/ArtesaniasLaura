<?php
require("../includes/auth.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['mensaje'] = "❌ ID de producto no válido.";
    header("Location: admin-productos.php");
    exit;
}

$id = intval($_GET['id']);
include("../config/conndb.php");
$sql = "DELETE FROM productos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    $_SESSION['mensaje'] = "✅ Producto eliminado con éxito.";
} else {
    $_SESSION['mensaje'] = "❌ Error al eliminar el producto: " . $conexion->error;
}
header("Location: admin-productos.php");
?>

