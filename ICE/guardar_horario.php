<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['error' => 'No autenticado']);
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'sistema_web');
if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión: ' . $conn->connect_error]);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['materias'])) {
    echo json_encode(['error' => 'Datos de materias no recibidos']);
    exit();
}

$usuario = $conn->real_escape_string($_SESSION['usuario']);
$materias_json = $conn->real_escape_string(json_encode($data['materias']));

$sql_check = "SELECT id FROM horarios_seleccionados WHERE usuario = '$usuario' LIMIT 1";
$result = $conn->query($sql_check);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $sql_update = "UPDATE horarios_seleccionados SET materias = '$materias_json', fecha_seleccion = NOW() WHERE id = $id";
    if ($conn->query($sql_update)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Error al actualizar horario: ' . $conn->error]);
    }
} else {
    $sql_insert = "INSERT INTO horarios_seleccionados (usuario, materias, fecha_seleccion) VALUES ('$usuario', '$materias_json', NOW())";
    if ($conn->query($sql_insert)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Error al guardar horario: ' . $conn->error]);
    }
}

$conn->close();
?>
