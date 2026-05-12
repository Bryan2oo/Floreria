<?php
include("../../Config/conexion.php");

// Mostrar errores para desarrollo (quitar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Asegura que sea entero

    // Verificar que exista el producto
    $stmt_check = $conectBd->prepare("SELECT id FROM productos WHERE id = ?");
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Eliminar el producto
        $stmt_delete = $conectBd->prepare("DELETE FROM productos WHERE id = ?");
        $stmt_delete->bind_param("i", $id);
        
        if ($stmt_delete->execute()) {
            // Redirigir al listado con mensaje de éxito
            header("Location: ../../View/VAdministrador/VAdminMostrarD.php?eliminado=true");
            exit();
        } else {
            // Redirigir con mensaje de error
            header("Location: ../../View/VAdministrador/VAdminMostrarD.php?error_eliminar=true");
            exit();
        }
    } else {
        // Producto no encontrado
        header("Location: ../../View/VAdministrador/VAdminMostrarD.php?error_no_encontrado=true");
        exit();
    }
} else {
    // Si no es POST o no tiene ID, redirigir
    header("Location: ../../View/VAdministrador/VAdminMostrarD.php");
    exit();
}
?>