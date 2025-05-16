<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode([]);
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'sistema_web');
if ($conn->connect_error) {
    echo json_encode([]);
    exit();
}

// Obtener materias disponibles para reinscripción
// Ejemplo: id, nombre, grupo, créditos, horario
$sql = "SELECT * FROM materias_reinscripcion";
$result = $conn->query($sql);

$materias = [];
while ($row = $result->fetch_assoc()) {
    $materias[] = [
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'grupo' => $row['grupo'],
        'creditos' => $row['creditos'],
        'seriada' => $row['seriada'],
        'horario' => $row['horario']
    ];
}

echo json_encode($materias);
$conn->close();
?>
