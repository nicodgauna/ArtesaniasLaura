<?php
session_start();

// Si no hay sesión de admin, redirigir al login
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['error'] = "Debes iniciar sesión para acceder al panel.";
    header("Location: admin-login.php");
    exit;
}
?>