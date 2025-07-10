<?php
session_start();
include("../Config/conexion.php");

if (!isset($_SESSION['cliente_id'])) {
    header("Location: VInterfazUsuario.php");
    exit;
}
$cliente_id = $_SESSION['cliente_id'];

// Buscar el pedido en carrito
$sqlPedido = "SELECT id FROM pedidos WHERE cliente_id = ? AND estado = 'carrito' LIMIT 1";
$stmtPedido = $conectBd->prepare($sqlPedido);
$stmtPedido->bind_param("i", $cliente_id);
$stmtPedido->execute();
$resultPedido = $stmtPedido->get_result();

if ($pedido = $resultPedido->fetch_assoc()) {
    $pedido_id = $pedido['id'];

    // Obtener los productos del pedido
    $sqlDetalles = "SELECT producto_id, cantidad FROM detalle_pedido WHERE pedido_id = ?";
    $stmtDetalles = $conectBd->prepare($sqlDetalles);
    $stmtDetalles->bind_param("i", $pedido_id);
    $stmtDetalles->execute();
    $resultDetalles = $stmtDetalles->get_result();

    // Descontar stock de cada producto
    while ($detalle = $resultDetalles->fetch_assoc()) {
        $producto_id = $detalle['producto_id'];
        $cantidad = $detalle['cantidad'];
        $updateStock = "UPDATE productos SET stock = stock - ? WHERE id = ?";
        $stmtUpdate = $conectBd->prepare($updateStock);
        $stmtUpdate->bind_param("ii", $cantidad, $producto_id);
        $stmtUpdate->execute();
        $stmtUpdate->close();
    }
    $stmtDetalles->close();

    // Cambiar estado del pedido a 'reservado'
    $updatePedido = "UPDATE pedidos SET estado = 'reservado' WHERE id = ?";
    $stmtUpdatePedido = $conectBd->prepare($updatePedido);
    $stmtUpdatePedido->bind_param("i", $pedido_id);
    $stmtUpdatePedido->execute();
    $stmtUpdatePedido->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva confirmada</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h1 class="text-success">✅ ¡Reserva realizada con éxito!</h1>
    <a href="../View/VInterfazUsuario.php" class="btn btn-primary mt-3">Volver al inicio</a>
</body>
</html>