<?php
session_start();

require_once 'includes/conexion.php';
require_once 'includes/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Validaciones 
    if (!$nombre) {
        $errors[] = 'No has introducido el nombre';
    }

    if (strlen($nombre) < 3) {
        $errors[] = 'El nombre debe tener como mínimo 3 caracteres';
    }

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
    $result = $usuarioObj->registrar($nombre, $email, $contraseña);

    // Si el registro es exitoso te guarda el nombre, el id de usuario y  te redirige al listado
    if ($result && $result != 0 && empty($errors)) { 
        $_SESSION['usuario'] = $nombre;
        $_SESSION['id'] = $result;
        header('Location: listado.php');
        exit;
    } else {
        $errors[] = "Error al registrar el usuario. El email podría estar ya en uso."; 
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="css/styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Registro</h1>
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="contraseña" placeholder="Contraseña">
            <button type="submit" class="btn-sign">Registrarse</button>
        </form>

        <?php                
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='error'>Error: $error</p>";
                }
            }
        ?>

        <p>¿Ya tienes una cuenta? <a href="index.php">Inicia sesión</a></p>
    </div>
</body>
</html>
