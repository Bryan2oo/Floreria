<?php
include("../../Config/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pedido_id = $_POST['pedido_id'];
    $nuevo_estado = $_POST['nuevo_estado'];
    
    // Validar y sanitizar los datos
    $pedido_id = mysqli_real_escape_string($conectBd, $pedido_id);
    $nuevo_estado = mysqli_real_escape_string($conectBd, $nuevo_estado);
    
    // Actualizar el estado del pedido
    $sql = "UPDATE pedidos SET estado = '$nuevo_estado' WHERE id = $pedido_id";
    
    if (mysqli_query($conectBd, $sql)) {
        header("Location: ../../View/VAdministrador/VAdminPedidos.php?exito=estado_actualizado");
        exit();
    } else {
        header("Location: ../../View/VAdministrador/VAdminPedidos.php?error=error_actualizacion");
        exit();
    }
} else {
    header("Location: ../../View/VAdministrador/VAdminPedidos.php");
    exit();
}
?>