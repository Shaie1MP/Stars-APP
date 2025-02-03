CREATE DATABASE IF NOT EXISTS UT6_SP_MontesdeocaPugaShaiel;
USE UT6_SP_MontesdeocaPugaShaiel;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripción TEXT,
    precio DECIMAL(10, 2) NOT NULL
);

CREATE TABLE votos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cantidad INT DEFAULT 0,
    idPr INT NOT NULL,
    idUs INT NOT NULL,
    CONSTRAINT fk_votos_usu FOREIGN KEY(idUs) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_votos_pro FOREIGN KEY(idPr) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO productos (nombre, descripción, precio) VALUES
('Iphone 12 PRO', 'Último modelo con cámara de alta resolución', 899.99),
('portátil ASUS', 'Potente laptop para trabajo y juegos', 999.99),
('AirPods', 'Con cancelación de ruido', 149.99),
('Smartwatch', 'Monitorea tu salud y actividad física', 199.99),
('IPad', 'Perfecta para entretenimiento y productividad', 449.99);