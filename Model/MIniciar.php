<?php
include 'Model/MMenuNav.php';
// login.php
session_start();
include '../Config/conexion.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['Correo'];
    $clave = $_POST['Clave'];

    $stmt = $conn->prepare("SELECT * FROM clientes WHERE Email = :Email AND Password = :Password");
    $stmt->bindParam(':Correo', $correo);
    $stmt->bindParam(':Clave', $clave);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['Correo'] = $correo;
        header("../View/VSesionD.php");
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>