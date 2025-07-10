<?php
session_start();
include("../Config/conexion.php");

if (!isset($_SESSION['cliente_id'])) {
    header("Location: VInterfazUsuario.php");
    exit;
}

$cliente_id = $_SESSION['cliente_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación básica para evitar errores
    if (!isset($_POST['producto_id'], $_POST['cantidad'])) {
        header("Location: VInterfazUsuario.php?error=datos_faltantes");
        exit;
    }

    $producto_id = intval($_POST['producto_id']);
    $cantidad = intval($_POST['cantidad']);

    // Verificar stock disponible
    $sqlStock = "SELECT stock FROM productos WHERE id = ?";
    $stmtStock = $conectBd->prepare($sqlStock);
    $stmtStock->bind_param("i", $producto_id);
    $stmtStock->execute();
    $resultStock = $stmtStock->get_result();
    $rowStock = $resultStock->fetch_assoc();
    $stmtStock->close();

    if (!$rowStock || $rowStock['stock'] < $cantidad) {
        header("Location: verProducto.php?id=$producto_id&error=stock");
        exit;
    }

    // Buscar si ya existe un pedido "carrito" para este cliente
    $query = "SELECT id FROM pedidos WHERE cliente_id = ? AND estado = 'carrito' LIMIT 1";
    $stmtPedido = $conectBd->prepare($query);
    $stmtPedido->bind_param("i", $cliente_id);
    $stmtPedido->execute();
    $resultPedido = $stmtPedido->get_result();

    if ($pedido = $resultPedido->fetch_assoc()) {
        $pedido_id = $pedido['id'];
    } else {
        // Crear un nuevo pedido "carrito"
        $insertPedido = "INSERT INTO pedidos (cliente_id, estado) VALUES (?, 'carrito')";
        $stmtInsertPedido = $conectBd->prepare($insertPedido);
        $stmtInsertPedido->bind_param("i", $cliente_id);
        $stmtInsertPedido->execute();
        $pedido_id = $stmtInsertPedido->insert_id;
        $stmtInsertPedido->close();
    }
    $stmtPedido->close();

    // Insertar producto en el pedido
    $insertDetalle = "INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)";
    $stmtDetalle = $conectBd->prepare($insertDetalle);
    $stmtDetalle->bind_param("iii", $pedido_id, $producto_id, $cantidad);
    $stmtDetalle->execute();
    $stmtDetalle->close();
    // Redirigir al catálogo o a producto
    header("Location: VInterfazUsuario.php?agregado=1");
    exit;
}
?>