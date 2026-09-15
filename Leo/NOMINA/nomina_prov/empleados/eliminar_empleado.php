<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/funcionesCrud.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../auth/login.php');
    exit;
}

$id = $_GET['id'] ?? null;
if ($id) {
    eliminarEmpleado($conexion, $id);
}
header('Location: ../index.php');
exit;