<?php
include("../Config/conexion.php");
session_start();
if (!isset($_SESSION['cliente_id'])) {
    header("Location:../View/InterfazUsuario.php");
    exit;
}
$cliente_id = $_SESSION['cliente_id'];

$sql = "SELECT pp.*, p.nombre, p.precio AS precio_original, p.imagen, pr.descuento_porcentaje
        FROM detalle_pedido pp
        INNER JOIN pedidos ped ON pp.pedido_id = ped.id
        INNER JOIN productos p ON pp.producto_id = p.id
        LEFT JOIN promocion_producto ppr ON p.id = ppr.producto_id
        LEFT JOIN promociones pr ON ppr.promocion_id = pr.id
        WHERE ped.cliente_id = $cliente_id AND ped.estado = 'carrito'";


$resultado = mysqli_query($conectBd, $sql);
$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Carrito</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Public/css/stylesNav.css">
    <link rel="stylesheet" href="../Public/css/stylesLog.css">
    <link rel="stylesheet" href="../Public/css/stylesFondo.css">
    <link rel="stylesheet" href="../Public/css/stylesUsuario.css">
    <link rel="stylesheet" href="../Public/css/stylesCarrito2.css">
</head>
<body class="container mt-4">
    <h1>🛒 Mi Carrito</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Imagen</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = mysqli_fetch_assoc($resultado)) {
    $precioOriginal = floatval($item['precio_original']);
    $descuento = isset($item['descuento_porcentaje']) ? floatval($item['descuento_porcentaje']) : 0;
    $precioFinal = $descuento > 0 ? $precioOriginal * (1 - $descuento / 100) : $precioOriginal;
    $subtotal = $precioFinal * $item['cantidad'];
    $total += $subtotal;
?>
<tr>
    <td><?php echo htmlspecialchars($item['nombre']); ?></td>
    <td>
        <?php if (!empty($item['imagen'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($item['imagen']); ?>" width="80">
        <?php else: ?>
            Sin imagen
        <?php endif; ?>
    </td>
    <td><?php echo $item['cantidad']; ?></td>
    <td>
        <?php if ($descuento > 0): ?>
            <small><del>$<?php echo number_format($precioOriginal, 2); ?></del></small><br>
            <strong class="text-success">$<?php echo number_format($precioFinal, 2); ?></strong><br>
            <span class="badge bg-danger"><?php echo $descuento; ?>% desc</span>
        <?php else: ?>
            $<?php echo number_format($precioOriginal, 2); ?>
        <?php endif; ?>
    </td>
    <td>$<?php echo number_format($subtotal, 2); ?></td>
    <td>
        <form method="post" action="../Model/eliminarDelCarrito.php">
            <input type="hidden" name="detalle_id" value="<?php echo $item['id']; ?>">
            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
        </form>
    </td>
</tr>
<?php } ?>

        </tbody>
    </table>

    <h3>Total: $<?php echo number_format($total, 2); ?></h3>
    <form action="../View/VConfirmacion.php" method="post">
    <button type="submit" class="btn btn-success">Reservar</button>
</form>
</body>
</html>
