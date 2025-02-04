<?php
session_start(); 

require_once '../includes/conexion.php'; 
require_once '../includes/Producto.php';

// Verifica si el usuario ha iniciado sesión, si no, lo redirige al inicio
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $nombre = trim(strip_tags($_POST['nombre'])) ?? null;
    $descripcion = trim(strip_tags($_POST['descripcion'])) ?? null;
    $precio = $_POST['precio'] ?? null;

    //Validaciones
    if (!$nombre) {
        $errors[] = 'No has introducido el nombre del producto';
    }

    if (strlen($nombre) < 3) {
        $errors[] = 'El nombre debe tener como mínimo 3 caracteres';
    }

    if (!$descripcion) {
        $errors[] = 'No has introducido la descripción del producto';
    }

    if (!$precio) {
        $errors[] = 'No has introducido el precio del producto';
    }

    if ($precio < 0) {
        $errors[] = 'El precio debe ser mayor a cero';
    }

    // Crea una instancia de la clase Producto
    $productoObj = new Producto($pdo);
    if (empty($errors)) {
        if ($productoObj->crear($nombre, $descripcion, $precio)) {
            header('Location: ../src/listado.php');
            exit;
        } else {
            $errors[] = "Error al crear el producto";
        }
    } 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="../css/styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Crear Producto</h1>
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre">
            <textarea name="descripcion" placeholder="Descripción"></textarea>
            <input type="number" name="precio" placeholder="Precio" id="precio" step=".01">
            <button type="submit" class="btn-create">Crear</button>
        </form>

        <?php 
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='error'>Error: $error</p>";
                }
            }
        ?>

        <a href="../src/listado.php">Volver al listado</a> 
    </div>
</body>
</html>
