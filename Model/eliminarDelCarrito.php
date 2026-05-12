<?php
include("../Config/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['detalle_id'])) {
    $detalle_id = intval($_POST['detalle_id']);

    $sql = "DELETE FROM detalle_pedido WHERE id = ?";
    $stmt = $conectBd->prepare($sql);
    $stmt->bind_param("i", $detalle_id);
    $stmt->execute();

    // Redirigir de vuelta al carrito
    header("Location: ../View/Carrito.php");
    exit;
} else {
    echo "Acción inválida.";
}
