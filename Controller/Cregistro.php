<?php
session_start();

// Incluir el modelo de usuario
include("../Model/Musuario.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["Nombre"];
    $email = $_POST["Correo"];
    $telefono = $_POST["Telefono"];
    $direccion = $_POST["Direccion"];
    $password = $_POST["Clave"];
    $confirmarPassword = $_POST["ConfirmarClave"];

    // Validar que las contraseñas coincidan
    if ($password !== $confirmarPassword) {
        $error = "Las contraseñas no coinciden.";
        include("../View/VRegistro.php");
        exit();
    }

    // Crear un nuevo usuario
    $usuario = new MUsuario();
    $resultado = $usuario->crearUsuario($nombre, $email, $telefono, $direccion, $password);

    if ($resultado === true) {
        // Mostrar mensaje de éxito en la vista de registro
        $success = "¡Registro exitoso! Ahora puedes iniciar sesión.";
        include("../View/VRegistro.php");
        exit();
    } else {
        $error = $resultado; // Mensaje de error
        include("../View/VRegistro.php");
        exit();
    }
}
?>