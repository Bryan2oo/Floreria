<?php
include("../Config/conexion.php");

// Verificar si se pasó un ID por GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h2>Producto no encontrado.</h2>";
    exit;
}

$id = intval($_GET['id']);

// Consulta del producto por ID
$sql = "SELECT p.*, pr.descuento_porcentaje 
        FROM productos p
        LEFT JOIN promocion_producto pp ON p.id = pp.producto_id
        LEFT JOIN promociones pr ON pp.promocion_id = pr.id
        WHERE p.id = $id";
        $resultado = mysqli_query($conectBd, $sql);

if (mysqli_num_rows($resultado) == 0) {
    echo "<h2>Producto no encontrado.</h2>";
    exit;
}

$producto = mysqli_fetch_assoc($resultado);
$precioOriginal = floatval($producto['precio']);
$descuento = isset($producto['descuento_porcentaje']) ? floatval($producto['descuento_porcentaje']) : 0;
$precioFinal = $descuento > 0 ? $precioOriginal * (1 - $descuento / 100) : $precioOriginal;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($producto['nombre']); ?> - Detalles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/css/stylesCarrito.css">
    <style>
        .producto-detalle {
            margin-top: 50px;
        }
        .imagen-producto {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .btn-group-actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
<div class="container producto-detalle">
    <div class="row">
        <div class="col-md-6">
            <?php if (!empty($producto['imagen'])): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($producto['imagen']); ?>"
                     class="imagen-producto"
                     alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
            <?php else: ?>
                <img src="../Img/default.jpg" class="imagen-producto" alt="Sin imagen">
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>
            <p><strong>Tipo:</strong> <?php echo ucfirst($producto['tipo']); ?></p>
            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($producto['descripcion']); ?></p>
<?php if ($descuento > 0): ?>
    <p><strong class="text-danger"><?php echo $descuento; ?>% de descuento</strong></p>
    <p>
        <del>Precio original: $<?php echo number_format($precioOriginal, 2); ?></del><br>
        <strong class="text-success">Precio con descuento: $<?php echo number_format($precioFinal, 2); ?></strong>
    </p>
<?php else: ?>
    <p><strong>Precio:</strong> $<?php echo number_format($precioOriginal, 2); ?></p>
<?php endif; ?>
            <p><strong>Stock disponible:</strong> <?php echo $producto['stock']; ?></p>

            <form action="procesarPedido.php" method="post">
                <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" max="<?php echo $producto['stock']; ?>" required>
                </div>
                <div class="btn-group-actions">
                    <button type="submit" class="btn btn-success">Agregar al carrito</button>
                    <a href="../View/VInterfazUsuario.php" class="btn btn-primary">Regresar</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>