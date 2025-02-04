<?php
require_once 'conexion.php';

class Producto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para obtener todos los productos de la base de datos
    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM productos");
        return $stmt->fetchAll();
    }

    // Método para obtener un producto por su ID
    public function obtener($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Método para crear un nuevo producto
    public function crear($nombre, $descripcion, $precio) {
        $stmt = $this->pdo->prepare("INSERT INTO productos (nombre, descripción, precio) VALUES (?, ?, ?)");
        return $stmt->execute([$nombre, $descripcion, $precio]);
    }

    // Método para actualizar un producto por su ID
    public function actualizar($id, $nombre, $descripcion, $precio) {
        $stmt = $this->pdo->prepare("UPDATE productos SET nombre = ?, descripción = ?, precio = ? WHERE id = ?");
        return $stmt->execute([$nombre, $descripcion, $precio, $id]);
    }

    // Método para eliminar un producto por su ID
    public function borrar($id) {
        $stmt = $this->pdo->prepare("DELETE FROM productos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
