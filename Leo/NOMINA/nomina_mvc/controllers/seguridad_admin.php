<?php
// controllers/seguridad_admin.php
session_start();

// Validamos usando isset que la sesión exista y que el rol sea el correcto
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    // Si no es admin, lo expulsamos al login
    header("Location: ../../index.php");
    exit;
}
?>