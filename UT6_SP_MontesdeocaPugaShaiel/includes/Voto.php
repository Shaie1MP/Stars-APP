<?php
require_once 'conexion.php';

class Voto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para registrar o actualizar un voto
    public function miVoto($idPr, $idUs, $cantidad) {
        try {
            $this->pdo->beginTransaction();

            // Verifica si el usuario ya ha votado por el producto
            if ($this->usuarioHaVotado($idPr, $idUs)) {
                $stmt = $this->pdo->prepare("UPDATE votos SET cantidad = ? WHERE idPr = ? AND idUs = ?");
                $stmt->execute([$cantidad, $idPr, $idUs]);
            } else {
                // Si no ha votado, se inserta un nuevo registro
                $stmt = $this->pdo->prepare("INSERT INTO votos (idPr, idUs, cantidad) VALUES (?, ?, ?)");
                $stmt->execute([$idPr, $idUs, $cantidad]);
            }

            $this->pdo->commit(); 
            return $this->obtenerValoracion($idPr); 
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Error in miVoto: " . $e->getMessage()); 
            return false;
        }
    }

    // Método para obtener la valoración promedio de un producto
    public function obtenerValoracion($idPr) {
        $stmt = $this->pdo->prepare("SELECT AVG(cantidad) as valoracion, COUNT(*) as num_votos FROM votos WHERE idPr = ?");
        $stmt->execute([$idPr]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    // Método para generar HTML con estrellas representando la valoración de un producto
    public function pintarEstrellas($idPr) {
        $valoracion = $this->obtenerValoracion($idPr);
        $estrellas = round($valoracion['valoracion'] * 2) / 2;
        $num_votos = $valoracion['num_votos'];

        // Genera el HTML con la cantidad de votos
        $html = "<span class='num-votos'>$num_votos valoraciones</span> ";
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $estrellas) {
                $html .= '<i class="fas fa-star"></i>'; 
            } elseif ($i - 0.5 == $estrellas) {
                $html .= '<i class="fas fa-star-half-alt"></i>'; 
            } else {
                $html .= '<i class="far fa-star"></i>'; 
            }
        }
        return $html;
    }

    // Método para verificar si un usuario ya ha votado por un producto
    public function usuarioHaVotado($idPr, $idUs) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM votos WHERE idPr = ? AND idUs = ?");
        $stmt->execute([$idPr, $idUs]);
        return $stmt->fetchColumn() > 0; 
    }
}
