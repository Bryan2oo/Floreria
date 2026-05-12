<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Public/css/stylesNav.css">
    <link rel="stylesheet" href="../../Public/css/stylesLog.css">
    <link rel="stylesheet" href="../../Public/css/stylesFondo.css">
    <link rel="stylesheet" href="../../Public/css/stylesUsuario.css">
    <link rel="stylesheet" href="../../Public/css/stylesMenuNavAdmin.css">
</head>
<body>
    <?php
        // Aquí puedes cambiar la visibilidad de los botones según el estado del usuario
        $showOrderButton = true;  // Mostrar el botón de pedido
        $showAccountButton = false; // Mostrar el botón de cuenta
        $showLogoutButton = false; // No mostrar el botón de cerrar sesión
        $showExitButton = true; // Mostrar el botón de salir

        include("../../Model/MAdministrador/MMenuNavAdmin3.php"); 
        include("../../Config/conexion.php");
$sql = "SELECT p.*, pr.descuento_porcentaje 
        FROM productos p 
        INNER JOIN producto_categoria pc ON p.id = pc.producto_id 
        LEFT JOIN promocion_producto pp ON p.id = pp.producto_id 
        LEFT JOIN promociones pr ON pp.promocion_id = pr.id 
        WHERE pc.categoria_id = 2"; 
               $resultado = mysqli_query($conectBd, $sql);

    ?>
     <!-- Nuestros Productos Favoritos (Dinámicos) -->
    <section id="featured-products" class="py-5">
    <h2 class="text-center">San Valentín</h2>
    <div class="row">
        <?php while ($producto = mysqli_fetch_assoc($resultado)) {
            $precioOriginal = floatval($producto['precio']);
            $descuento = isset($producto['descuento_porcentaje']) ? floatval($producto['descuento_porcentaje']) : 0;
            $precioFinal = $descuento > 0 ? $precioOriginal * (1 - $descuento / 100) : $precioOriginal;
        ?>
            <div class="col-md-3 mt-4">
                <div class="card h-100">
                    <?php if (!empty($producto['imagen'])): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($producto['imagen']); ?>"
                             class="card-img-top"
                             alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
                             style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <img src="../Img/default.jpg"
                             class="card-img-top"
                             alt="Imagen no disponible"
                             style="height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($producto['descripcion']); ?></p>

                        <?php if ($descuento > 0): ?>
                            <p class="card-text text-danger">
                                <strong>¡<?php echo $descuento; ?>% de descuento!</strong>
                            </p>
                            <p class="card-text">
                                <del>$<?php echo number_format($precioOriginal, 2); ?></del>
                                <strong class="text-success">$<?php echo number_format($precioFinal, 2); ?></strong>
                            </p>
                        <?php else: ?>
                            <p class="card-text"><strong>Precio: $<?php echo number_format($precioOriginal, 2); ?></strong></p>
                        <?php endif; ?>

                        <a href="../verProducto.php?id=<?php echo $producto['id']; ?>" class="btn btn-success mt-auto">Comprar</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>


        <!-- WhatsApp Contacto -->
        <section id="whatsapp" class="text-center py-4">
            <h3>¿Tienes alguna duda? ¡Contáctanos por WhatsApp!</h3>
            <a href="https://wa.me/+593998326415" target="_blank" class="btn btn-success">Chat en WhatsApp</a>
        </section>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>