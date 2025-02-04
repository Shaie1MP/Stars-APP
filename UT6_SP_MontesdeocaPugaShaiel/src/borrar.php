<?php
session_start(); 

require_once '../includes/conexion.php'; 
require_once '../includes/Producto.php'; 

// Verifica si el usuario ha iniciado sesión, si no, lo redirige al inicio
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

// Obtiene el ID del producto desde la URL
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: ../src/listado.php');
    exit;
}

$productoObj = new Producto($pdo);

// Intenta borrar el producto y redirige al listado si tiene éxito
if ($productoObj->borrar($id)) {
    header('Location: ../src/listado.php');
} else {
    echo "Error al borrar el producto";
}
