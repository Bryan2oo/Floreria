<?php
session_start();
include("../Model/MUsuario.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["Correo"];
    $clave = $_POST["Clave"];

    $usuario = new MUsuario();
    $resultado = $usuario->validarAdmin($correo, $clave);

    if ($resultado === "correo_incorrecto") {
        $error = "El correo electrónico es incorrecto. Por favor, inténtalo de nuevo.";
        include("../View/VAdminLogin.php");
        exit();
    } elseif ($resultado === "clave_incorrecta") {
        $error = "La contraseña es incorrecta. Por favor, ingresa la contraseña nuevamente.";
        $correo_guardado = $correo; // Mantener el correo en el campo
        include("../View/VAdminLogin.php");
        exit();
    } elseif ($resultado === "ambos_incorrectos") {
        $error = "El correo electrónico y la contraseña son incorrectos. Por favor, inténtalo de nuevo.";
        include("../View/VAdminLogin.php");
        exit();
    } elseif ($resultado === true) {
        $_SESSION["admin"] = true;
        header("Location: ../View/VAdmin.php");
        exit();
    } else {
        $error = "Ocurrió un error inesperado.";
        include("../View/VAdminLogin.php");
        exit();
    }
}
?>