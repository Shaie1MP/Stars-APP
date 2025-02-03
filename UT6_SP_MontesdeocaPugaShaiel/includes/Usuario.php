<?php
require_once 'conexion.php';

class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para validar las credenciales de un usuario
    public function validar($email, $contraseña) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        // Verifica que el usuario exista y que la contraseña sea correcta
        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            return $usuario; 
        }
        return false; 
    }

    // Método para registrar un nuevo usuario
    public function registrar($nombre, $email, $contraseña) {
        try {
            // Encripta la contraseña antes de guardarla en la base de datos
            $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)");
            $stmt->execute([$nombre, $email, $contraseña_hash]);

            return $this->pdo->lastInsertId(); 

        } catch (PDOException $e) {
            return 0; 
        }
    }
}
