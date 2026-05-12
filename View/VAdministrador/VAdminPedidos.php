<?php
include("../../Config/conexion.php");
include("../../Model/MAdministrador/MMenuNavAdmin2.php");

// Consulta principal modificada para evitar errores
$sql = "SELECT p.id, p.fecha, p.estado, 
               c.nombre_completo AS cliente_nombre, 
               c.correo
        FROM pedidos p
        INNER JOIN clientes c ON p.cliente_id = c.id
        WHERE p.estado != 'carrito'
        ORDER BY p.fecha DESC";

$resultado = mysqli_query($conectBd, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conectBd));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos de Clientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../Public/css/CssAdministrador/stylesNavAdmin.css">
    <link rel="stylesheet" href="../../Public/css/stylesFondo.css">
    <link rel="stylesheet" href="../../Public/css//stylesPedidos.css">
    <style>
        .pedido-header {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .detalle-pedido {
            margin-left: 30px;
            margin-bottom: 30px;
            border-left: 3px solid #dee2e6;
            padding-left: 15px;
        }
        .estado-pendiente {
            color: #ffc107;
            font-weight: bold;
        }
        .estado-completado {
            color: #28a745;
            font-weight: bold;
        }
        .estado-cancelado {
            color: #dc3545;
            font-weight: bold;
        }
        .estado-reservado {
            color: #17a2b8;
            font-weight: bold;
        }
        .table-detalle {
            background-color: white;
        }
        .badge-descuento {
            font-size: 0.75em;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">📋 Pedidos de Clientes</h1>
        
        <?php if(mysqli_num_rows($resultado) == 0): ?>
            <div class="alert alert-info">No hay pedidos registrados</div>
        <?php else: ?>
            <?php while($pedido = mysqli_fetch_assoc($resultado)): ?>
                <div class="pedido-header">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Pedido #<?php echo htmlspecialchars($pedido['id']); ?></h5>
                            <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?></p>
                            <p><strong>Estado:</strong> 
                                <span class="estado-<?php echo strtolower($pedido['estado']); ?>">
                                    <?php echo htmlspecialchars($pedido['estado']); ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <h5>Cliente</h5>
                            <p><?php echo htmlspecialchars($pedido['cliente_nombre']); ?></p>
                            <p><?php echo htmlspecialchars($pedido['correo']); ?></p>
                        </div>
                        <div class="col-md-4">
                            <h5>Total</h5>
                            <?php
                            // Calcular el total sumando los subtotales de los productos
                            $sql_detalle = "SELECT dp.cantidad, pr.precio, COALESCE(prm.descuento_porcentaje, 0) AS descuento
                                            FROM detalle_pedido dp
                                            INNER JOIN productos pr ON dp.producto_id = pr.id
                                            LEFT JOIN promocion_producto pp ON pr.id = pp.producto_id
                                            LEFT JOIN promociones prm ON pp.promocion_id = prm.id
                                            WHERE dp.pedido_id = ?";
                            $stmt_detalle = $conectBd->prepare($sql_detalle);
                            $stmt_detalle->bind_param("i", $pedido['id']);
                            $stmt_detalle->execute();
                            $resultado_detalle = $stmt_detalle->get_result();
                            $total_pedido = 0;
                            while($detalle = $resultado_detalle->fetch_assoc()) {
                                $precio_final = $detalle['precio'] * (1 - ($detalle['descuento'] / 100));
                                $subtotal = $precio_final * $detalle['cantidad'];
                                $total_pedido += $subtotal;
                            }
                            $stmt_detalle->close();
                            ?>
                            <p class="h5">$<?php echo number_format($total_pedido, 2); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="detalle-pedido">
                    <h5 class="mb-3">📦 Productos:</h5>
                    <table class="table table-sm table-detalle">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Consulta segura para detalles del pedido
                            $sql_detalle = "SELECT dp.cantidad, pr.nombre, pr.precio, 
                                                   COALESCE(prm.descuento_porcentaje, 0) AS descuento
                                            FROM detalle_pedido dp
                                            INNER JOIN productos pr ON dp.producto_id = pr.id
                                            LEFT JOIN promocion_producto pp ON pr.id = pp.producto_id
                                            LEFT JOIN promociones prm ON pp.promocion_id = prm.id
                                            WHERE dp.pedido_id = ?";
                            
                            $stmt_detalle = $conectBd->prepare($sql_detalle);
                            $stmt_detalle->bind_param("i", $pedido['id']);
                            $stmt_detalle->execute();
                            $resultado_detalle = $stmt_detalle->get_result();
                            
                            while($detalle = $resultado_detalle->fetch_assoc()):
                                $precio_final = $detalle['precio'] * (1 - ($detalle['descuento'] / 100));
                                $subtotal = $precio_final * $detalle['cantidad'];
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($detalle['nombre']); ?></td>
                                <td><?php echo $detalle['cantidad']; ?></td>
                                <td>
                                    <?php if($detalle['descuento'] > 0): ?>
                                        <span class="text-success">$<?php echo number_format($precio_final, 2); ?></span>
                                        <small class="text-muted"><del>$<?php echo number_format($detalle['precio'], 2); ?></del></small>
                                        <span class="badge bg-danger badge-descuento"><?php echo $detalle['descuento']; ?>% OFF</span>
                                    <?php else: ?>
                                        $<?php echo number_format($detalle['precio'], 2); ?>
                                    <?php endif; ?>
                                </td>
                                <td>$<?php echo number_format($subtotal, 2); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-end mt-3">
                        <form method="post" action="../../Controller/CAdministrador/CAdminCambiarEstadoPedido.php" class="me-2">
                            <input type="hidden" name="pedido_id" value="<?php echo $pedido['id']; ?>">
                            <div class="input-group">
                                <select name="nuevo_estado" class="form-select form-select-sm" style="width: auto;">
                                    <option value="pendiente" <?php echo $pedido['estado'] == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                    <option value="reservado" <?php echo $pedido['estado'] == 'reservado' ? 'selected' : ''; ?>>Reservado</option>
                                    <option value="completado" <?php echo $pedido['estado'] == 'completado' ? 'selected' : ''; ?>>Completado</option>
                                    <option value="cancelado" <?php echo $pedido['estado'] == 'cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>