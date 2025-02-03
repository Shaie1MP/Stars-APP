<?php
session_start(); 

require_once 'includes/conexion.php';
require_once 'includes/Usuario.php';

// Verifica si el formulario ha sido enviado por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Validaciones 
    if (!$email) {
        $errors[] = 'No has introducido el email';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Formato de email incorrecto';
    }
    
    if (!$contraseña) {
        $errors[] = 'No has introducido la contraseña';
    }

    if (strlen($contraseña) < 3) {
        $errors[] = 'La contraseña debe tener como mínimo 3 caracteres';
    }

    $usuarioObj = new Usuario($pdo); 
    $result = $usuarioObj->validar($email, $contraseña);

     // Si el usuario es válido, inicia sesión
    if ($result && empty($errors)) {
        $_SESSION['usuario'] = $result['nombre']; 
        $_SESSION['id'] = $result['id'];
        header('Location: listado.php');
        exit;
    } else {
        $errors[] = "Credenciales Erróneas";
    }
}

$titulo = "Iniciar Sesión"; 
include 'header.php';
?>

<h2>Iniciar Sesión</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="contraseña" placeholder="Contraseña">
    <button type="submit" class="btn-login">Iniciar sesión</button>
</form>

<?php 
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p class='error'>Error: $error</p>";
        }
    }
?>

<p>¿No tienes una cuenta? <a href="registro.php">Regístrate</a></p>

<?php include 'footer.php';?>
