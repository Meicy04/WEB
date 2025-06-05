<?php
session_start();
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

$usuario = $conn->real_escape_string($_SESSION['usuario']);
$sql = "SELECT materias FROM horarios_seleccionados WHERE usuario = '$usuario' LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $materias = json_decode($row['materias'], true);
    echo json_encode($materias);
} else {
    echo json_encode([]);
}

$conn->close();
?>
