<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $conn = new mysqli('localhost', 'root', '', 'sistema_web');

    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }

    // Uso seguro con consultas preparadas
    $sql = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? AND contrasena = ?");
    $sql->bind_param("ss", $usuario, $contrasena);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['usuario'] = $usuario;
        header("Location: ../ICE/web1.php");
        exit();
    } else {
        header("Location: web.html?error=1");
        exit();
    }

    $conn->close();
} else {
    header("Location: web.html");
    exit();
}
?>
