<?php
session_start();

// Verifica si el usuario ha iniciado sesión, si no, lo redirige al inicio de sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

require_once 'includes/conexion.php'; 
require_once 'includes/Producto.php'; 
require_once 'includes/Voto.php'; 

// Crea instancias de Producto y Voto
$productoObj = new Producto($pdo);
$votoObj = new Voto($pdo);

// Obtiene la lista de productos de la base de datos
$productos = $productoObj->obtenerTodos();

$titulo = "Listado de Productos"; 
include 'header.php';
?>

<h2>Listado de Productos</h2>

<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Valoración</th>
            <th>Valorar</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?php echo $producto['id']; ?></td> 
            <td><?php echo $producto['nombre']; ?></td> 
            
            <td id="valoracion-<?php echo $producto['id']; ?>">
                <?php echo $votoObj->pintarEstrellas($producto['id']); ?>
            </td>

            <!-- Desplegable para valorar el producto -->
            <td>
                <select id="select-<?php echo $producto['id']; ?>" 
                        onchange="votar(<?php echo $producto['id']; ?>)" 
                        <?php echo $votoObj->usuarioHaVotado($producto['id'], $_SESSION['usuario']) ? 'disabled' : ''; ?>>
                    <option value="">Seleccionar</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </td>

            <td>
                <a href="detalle.php?id=<?php echo $producto['id']; ?>" class="btn btn-view">Ver</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="crear.php" class="btn btn-create">Crear nuevo producto</a>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="js/main.js"></script>

<?php include 'footer.php'; ?>
