<?php
include("../Config/conexion.php");
session_start();

if (!isset($_SESSION['cliente_id'])) {
    header("Location:../View/VSesionD.php");
    exit;
}

$cliente_id = $_SESSION['cliente_id'];

// Iniciar transacción
mysqli_begin_transaction($conectBd);

try {
    // 1. Obtener el pedido en estado 'carrito'
    $sql_pedido = "SELECT id FROM pedidos WHERE cliente_id = ? AND estado = 'carrito' FOR UPDATE";
    $stmt_pedido = $conectBd->prepare($sql_pedido);
    $stmt_pedido->bind_param("i", $cliente_id);
    $stmt_pedido->execute();
    $result_pedido = $stmt_pedido->get_result();
    
    if ($result_pedido->num_rows !== 1) {
        throw new Exception("No se encontró un carrito activo.");
    }
    
    $pedido = $result_pedido->fetch_assoc();
    $pedido_id = $pedido['id'];
    
    // 2. Calcular el total actualizado
    $sql_total = "SELECT SUM(pr.precio * dp.cantidad * (1 - IFNULL(prm.descuento_porcentaje, 0)/100) as total
                 FROM detalle_pedido dp
                 INNER JOIN productos pr ON dp.producto_id = pr.id
                 LEFT JOIN promocion_producto pp ON pr.id = pp.producto_id
                 LEFT JOIN promociones prm ON pp.promocion_id = prm.id
                 WHERE dp.pedido_id = ?";
    
    $stmt_total = $conectBd->prepare($sql_total);
    $stmt_total->bind_param("i", $pedido_id);
    $stmt_total->execute();
    $total_data = $stmt_total->get_result()->fetch_assoc();
    $total = $total_data['total'] ?? 0;
    
    // 3. Actualizar el pedido con el total calculado
    $sql_update = "UPDATE pedidos SET 
                  estado = 'pendiente',
                  total = ?,
                  fecha = NOW()
                  WHERE id = ?";
    
    $stmt_update = $conectBd->prepare($sql_update);
    $stmt_update->bind_param("di", $total, $pedido_id);
    $stmt_update->execute();
    
    // Confirmar transacción
    mysqli_commit($conectBd);
    
    header("Location: ../View/VConfirmacion.php");
    exit;
    
} catch (Exception $e) {
    // Revertir en caso de error
    mysqli_rollback($conectBd);
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../View/Carrito.php");
    exit;
}
?>