<?php
session_start();
include("../Model/Musuario.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST["Correo"]);
    $clave = trim($_POST["Clave"]);

    // Validar que los campos no estén vacíos
    if (empty($correo) || empty($clave)) {
        $error = "Por favor, complete todos los campos.";
        $_SESSION["correo_ingresado"] = $correo;
        include("../View/VSesionD.php");
        exit();
    }

    $usuario = new MUsuario();

    // La función verificarUsuario debería recibir correo y clave,
    // y devolver true si la contraseña es correcta,
    // o un mensaje de error si no es así.
    $resultado = $usuario->verificarUsuario($correo, $clave);

    if ($resultado === true) {
        // Supongamos que MUsuario también tiene un método para obtener datos del usuario por correo:
        $datosUsuario = $usuario->obtenerPorCorreo($correo); // Debes implementarlo

        // Guardar datos importantes en sesión:
        $_SESSION['cliente_id'] = $datosUsuario['id'];
        $_SESSION['correo'] = $correo;
        $_SESSION['cliente_nombre'] = $datosUsuario['nombre']; // si quieres guardar el nombre

        // Redirigir
        header("Location: ../View/VInterfazUsuario.php");
        exit();
    } else {
        // Error de validación (contraseña incorrecta o usuario no encontrado)
        $error = $resultado;
        $_SESSION["correo_ingresado"] = $correo;
        include("../View/VSesionD.php");
        exit();
    }
}
