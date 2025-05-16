<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode([]);
    exit();
}

$usuario = $_SESSION['usuario'];

$conn = new mysqli('localhost', 'root', '', 'sistema_web');
if ($conn->connect_error) {
    echo json_encode([]);
    exit();
}

// Obtener materias guardadas por usuario
$sql = "SELECT m.nombre, m.grupo, m.horario FROM materias m
        JOIN horarios_seleccionados h ON m.id = h.materia_id
        WHERE h.usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

$materias = [];
while ($row = $result->fetch_assoc()) {
    $materias[] = [
        'nombre' => $row['nombre'],
        'grupo' => $row['grupo'],
        'horario' => $row['horario']
    ];
}
$stmt->close();
$conn->close();

echo json_encode($materias);
?>
