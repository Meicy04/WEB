<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode([]);
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'sistema_web');
if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión: ' . $conn->connect_error]);
    exit();
}

$sql = "SELECT id, nombre, grupo, creditos, seriada, horario FROM materias_reinscripcion";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => 'Error en la consulta: ' . $conn->error]);
    exit();
}

$materias = [];
while ($row = $result->fetch_assoc()) {
    $materias[] = $row;
}

echo json_encode($materias);
$conn->close();
?>
