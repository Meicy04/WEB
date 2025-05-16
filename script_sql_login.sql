CREATE DATABASE IF NOT EXISTS sistema_web CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sistema_web;

CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  contrasena VARCHAR(50) NOT NULL
);

INSERT INTO usuarios (usuario, contrasena) VALUES
('admin', '12345'),
('202223013', '202223013');

CREATE TABLE IF NOT EXISTS materias_reinscripcion (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  grupo VARCHAR(10),
  creditos INT,
  seriada ENUM('Sí', 'No'),
  horario VARCHAR(100)
);

INSERT INTO materias_reinscripcion (nombre, grupo, creditos, seriada, horario) VALUES
('Matemáticas I', 'A', 6, 'No', 'Lunes 8:00-10:00'),
('Física I', 'A', 6, 'No', 'Lunes 10:00-12:00'),
('Programación I', 'A', 8, 'No', 'Martes 8:00-10:00'),
('Química', 'A', 6, 'No', 'Martes 10:00-12:00'),
('Introducción a la Ingeniería', 'A', 4, 'No', 'Miércoles 8:00-10:00'),
('Dibujo Técnico', 'A', 4, 'No', 'Miércoles 10:00-12:00'),
('Comunicación Oral', 'A', 3, 'No', 'Jueves 8:00-9:30'),
('Taller de Ética', 'A', 2, 'No', 'Jueves 9:30-11:00'),
('Matemáticas I', 'B', 6, 'No', 'Lunes 12:00-14:00'),
('Física I', 'B', 6, 'No', 'Lunes 14:00-16:00'),
('Programación I', 'B', 8, 'No', 'Martes 12:00-14:00'),
('Química', 'B', 6, 'No', 'Martes 14:00-16:00'),
('Introducción a la Ingeniería', 'B', 4, 'No', 'Miércoles 12:00-14:00'),
('Dibujo Técnico', 'B', 4, 'No', 'Miércoles 14:00-16:00'),
('Comunicación Oral', 'B', 3, 'No', 'Jueves 12:00-13:30'),
('Taller de Ética', 'B', 2, 'No', 'Jueves 13:30-15:00');

CREATE TABLE IF NOT EXISTS horarios_seleccionados (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50),
  materias TEXT,
  fecha_seleccion DATETIME DEFAULT CURRENT_TIMESTAMP
);
