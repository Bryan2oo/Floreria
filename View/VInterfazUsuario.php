<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Florería - Flores Frescas y Arreglos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/css/stylesNav.css">
    <link rel="stylesheet" href="../Public/css/stylesLog.css">
    <link rel="stylesheet" href="../Public/css/stylesFondo.css">
    <link rel="stylesheet" href="../Public/css/stylesUsuario2.css">
</head>
<body>
    <?php
        // Aquí puedes cambiar la visibilidad de los botones según el estado del usuario
        $showOrderButton = true;  // Mostrar el botón de pedido
        $showAccountButton = false; // Mostrar el botón de cuenta
        $showLogoutButton = false; // No mostrar el botón de cerrar sesión
        $showExitButton = true; // Mostrar el botón de salir

        include("../Model/MMenuNav.php"); 

        include("../Config/conexion.php");
       $sql = "SELECT p.*, pr.descuento_porcentaje 
        FROM productos p
        LEFT JOIN promocion_producto pp ON p.id = pp.producto_id
        LEFT JOIN promociones pr ON pp.promocion_id = pr.id";
$resultado = mysqli_query($conectBd, $sql);

    ?>

    <div class="container">
       <header class="text-center py-5">
    <h1>¡Bienvenido a Nuestra Florería!</h1>
    <h2>Flores frescas y hermosos arreglos, directamente de los mejores cultivos de Ecuador. ¡Descubre la belleza natural para cada ocasión!</h2>
    <div class="mt-3">
        <a href="Carrito.php" class="btn btn-primary">Ver Carrito 🛒</a>
    </div>
</header>

        <!-- Beneficios de Comprar con Nosotros -->
        <section id="benefits" class="mb-5">
            <h2 class="text-center">¿Por qué elegirnos?</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <h3>Flores Frescas y Naturales</h3>
                    <p>Nos aseguramos de que todas nuestras flores estén siempre frescas, traídas directamente de los mejores cultivos del Ecuador.</p>
                </div>
                <div class="col-md-4">
                    <h3>Envíos Rápidos y Cuidadosos</h3>
                    <p>Entregamos tus arreglos y flores en tiempo récord, garantizando que lleguen en perfectas condiciones para tu evento especial.</p>
                </div>
                <div class="col-md-4">
                    <h3>Precios Competitivos</h3>
                    <p>Ofrecemos precios accesibles sin sacrificar calidad. ¡Haz que tus momentos sean inolvidables con nuestras ofertas!</p>
                </div>
            </div>
        </section>

        <!-- Ofertas y Promociones en Días Especiales -->
        <section id="promotions" class="bg-light py-5">
    <h2 class="text-center">Ofertas y Promociones en Días Especiales</h2>
    <div class="row">
        <?php
        $categorias = mysqli_query($conectBd, "SELECT * FROM categorias_ocasion LIMIT 3"); // Limita a 3 promociones visibles
        while ($cat = mysqli_fetch_assoc($categorias)):
            $img = $cat['imagen'] ? 'data:image/jpeg;base64,' . base64_encode($cat['imagen']) : '../Img/default.jpg';
            $enlace = ''; // Personaliza el enlace según el ID o nombre
            switch ($cat['id']) {
                case 1: $enlace = '../View/VFloreria/diamadre.php'; break;
                case 2: $enlace = '../View/VFloreria/sanvalentin.php'; break;
                case 3: $enlace = '../View/VFloreria/cumple.php'; break;
                default: $enlace = '#';
            }
        ?>
        <div class="col-md-4">
            <div class="card">
                <img src="<?php echo $img; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($cat['nombre']); ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($cat['nombre']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($cat['descripcion']); ?></p>
                    <a href="<?php echo $enlace; ?>" class="btn btn-primary">¡Ver Promoción!</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>


        <!-- Nuestros Productos Favoritos (Dinámicos) -->
        <section id="featured-products" class="py-5">
    <h2 class="text-center">Flores y Arreglos Recomendados</h2>
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

                        <a href="verProducto.php?id=<?php echo $producto['id']; ?>" class="btn btn-success mt-auto">Comprar</a>
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