<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'msg' => 'No autorizado']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['materias']) || !is_array($data['materias'])) {
    echo json_encode(['success' => false, 'msg' => 'Datos inválidos']);
    exit();
}

$usuario = $_SESSION['usuario'];
$materias = $data['materias'];

$conn = new mysqli('localhost', 'root', '', 'sistema_web');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'msg' => 'Error de conexión']);
    exit();
}

// Tabla para guardar horario por usuario, por ejemplo:
// horarios_seleccionados(usuario VARCHAR, materia_id INT)
// Primero borramos lo que tenía el usuario
$stmt = $conn->prepare("DELETE FROM horarios_seleccionados WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->close();

// Insertamos las materias seleccionadas
$stmt = $conn->prepare("INSERT INTO horarios_seleccionados (usuario, materia_id) VALUES (?, ?)");
foreach ($materias as $id) {
    $stmt->bind_param("si", $usuario, $id);
    $stmt->execute();
}
$stmt->close();

echo json_encode(['success' => true]);
$conn->close();
?>
