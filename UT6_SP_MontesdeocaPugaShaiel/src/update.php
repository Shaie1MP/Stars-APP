<?php
session_start();

require_once '../includes/conexion.php'; 
require_once '../includes/Producto.php'; 

// Verifica si el usuario está logueado, si no lo redirige a la página de inicio de sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_GET['id'] ?? null;

// Si no se proporciona el ID, redirige al listado de productos
if (!$id) { 
    header('Location: listado.php');
    exit;
}

$productoObj = new Producto($pdo); 
$producto = $productoObj->obtener($id); 

// Si el producto no existe, redirige al listado de productos
if (!$producto) {
    header('Location: listado.php');
    exit;
}

// Verifica si se ha enviado el formulario por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $nombre = $_POST['nombre'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    $precio = $_POST['precio'];

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
        $errors[] = 'El precio debe ser mayor a 0';
    }

    // Si la actualización es exitosa, redirige al listado de productos
    if (empty($errors)) {
        if ($productoObj->actualizar($id, $nombre, $descripcion, $precio)) {
            header('Location: listado.php');
            exit;
        } else {
            $errors[] = "Error al actualizar el producto";
        }
    } 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <link rel="stylesheet" href="../css/styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Actualizar Producto</h1>
        <form method="POST">
            <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>">
            <textarea name="descripcion" ><?php echo $producto['descripción']; ?></textarea> 
            <input type="number" name="precio" value="<?php echo $producto['precio']; ?>" step=".01">
            <button type="submit" class="btn-update">Actualizar</button>
        </form>

        <?php 
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='error'>Error: $error</p>";
                }
            }
        ?>

        <a href="listado.php">Volver al listado</a>
    </div>
</body>
</html>
