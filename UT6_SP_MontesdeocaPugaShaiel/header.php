<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?? 'Mi Aplicación'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>STARS APP</h1>
            <?php if (isset($_SESSION['usuario'])): ?>
                <nav>
                    <span>Bienvenido, <?php echo $_SESSION['usuario']; ?></span>
                    <a href="logout.php" class="btn-logout">Cerrar sesión</a>
                </nav>
            <?php endif; ?>
        </div>
    </header>
    <main class="container">