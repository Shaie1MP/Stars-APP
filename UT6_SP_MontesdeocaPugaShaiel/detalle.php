<?php
session_start();

// Verifica si el usuario ha iniciado sesión, si no, lo redirige al inicio
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

require_once 'includes/conexion.php'; 
require_once 'includes/Producto.php'; 
require_once 'includes/Voto.php'; 

// Obtiene el ID del producto desde la URL
$id = $_GET['id'] ?? null;

// Si no hay un ID válido, redirige al listado de productos
if (!$id) {
    header('Location: listado.php');
    exit;
}

// Crea instancias de las clases Producto y Voto
$productoObj = new Producto($pdo);
$votoObj = new Voto($pdo);

// Obtiene la información del producto
$producto = $productoObj->obtener($id);

// Si el producto no existe, redirige al listado
if (!$producto) {
    header('Location: listado.php');
    exit;
}

$titulo = "Detalle del Producto"; 
include 'header.php';
?>

<h2>Detalle del Producto</h2>

<div class="product-detail">
    <h3><?php echo $producto['nombre']; ?></h3> 
    <p><strong>Descripción:</strong> <?php echo $producto['descripción']; ?></p> 
    <p><strong>Precio:</strong> <?php echo number_format($producto['precio'], 2); ?>€</p>
    
    <p><strong>Valoración:</strong> 
        <span id="valoracion-<?php echo $producto['id']; ?>">
            <?php echo $votoObj->pintarEstrellas($producto['id']); ?>
        </span>
    </p>

    <div class="action-buttons">
        <a href="update.php?id=<?php echo $producto['id']; ?>" class="btn btn-edit">Editar</a>
        
        <a href="borrar.php?id=<?php echo $producto['id']; ?>" class="btn btn-delete" 
           onclick="return confirm('¿Estás seguro de que quieres borrar este producto?')">
            Borrar
        </a>
    </div>
</div>

<a href="listado.php" class="btn btn-back">Volver al listado</a>

<?php include 'footer.php'; ?>
