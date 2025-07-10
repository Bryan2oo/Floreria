<?php
session_start();
require_once '../Config/conexion.php'; // Incluye la conexión a la base de datos

$esAdmin = false; // Por defecto, asumimos que no es administrador

// Verificamos si el usuario está logueado
if (isset($_SESSION['usuario'])) {
    $email = $_SESSION['usuario']; // Obtenemos el correo del usuario de la sesión

    // Consultamos la base de datos para verificar si es administrador
    $query = "SELECT * FROM administradores WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si encontramos al administrador, cambiamos $esAdmin a true
    if ($admin) {
        $esAdmin = true;
    }
}

// Devolvemos la respuesta en formato JSON
echo json_encode(['esAdmin' => $esAdmin]);
?>