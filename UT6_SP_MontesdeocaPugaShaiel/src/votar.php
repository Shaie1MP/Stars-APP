<?php
session_start();

require_once '../includes/conexion.php'; 
require_once '../includes/Voto.php';

header('Content-Type: application/json');

// Verifica si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']); 
    exit;
}

// Obtiene los datos enviados en la solicitud POST en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

$idProducto = $data['idProducto'] ?? null;
$valoracion = $data['valoracion'] ?? null;

// Si no se recibe el ID del producto, responde con un error
if(!$idProducto){
    echo json_encode(['success' => false, 'message' => 'ID producto no recibido.']);
    exit;
}

// Si no se recibe la valoración, responde con un error
if (!$valoracion) {
    echo json_encode(['success' => false, 'message' => 'Valoración no recibida.']);
    exit;
}

$votoObj = new Voto($pdo);

$resultado = $votoObj->miVoto($idProducto, $_SESSION['id'], $valoracion);

// Si el voto se registra correctamente, responde con las estrellas actualizadas
if ($resultado) {
    $estrellas = $votoObj->pintarEstrellas($idProducto); 
    echo json_encode(['success' => true, 'estrellas' => $estrellas]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al registrar el voto.']);
}
