<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Florería JyA</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="./Public/css/stylesNav.css">
    <link rel="stylesheet" href="./Public/css/stylesIndex.css">
</head>
<body>
    <?php 
    $showOrderButton = false; // Ocultar el botón de "Haz tu pedido"
    $showLogoutButton = false; // Ocultar el botón de "Cerrar sesión"
    $showAccountButton = true; // Asegurarse de que el botón de "Cuenta" se muestre
    $showExitButton = false;
    include("./Model/MMenuNav.php"); 
    ?>

    <!-- Portada -->
    <section class="portada">
        <!-- Contenido de la portada -->
        <div class="portada-content">
            <!-- Texto de bienvenida -->
            <div class="portada-texto">
                <h1>Bienvenido a Florería J&A 🌻</h1>
                <p>Flores frescas que llenan de alegría tu vida.</p>
                <div class="texto-dinamico">Arreglos florales para cada ocasión especial.</div>
            </div>

            <!-- Productos destacados -->
            <div class="productos-destacados">
                <h2>Nuestros Arreglos Destacados</h2>
                <div class="card">
                    <img src="./Public/Img/Rosas.jpg" alt="Ramos de Rosas">
                    <div>
                        <h3>Ramos de Rosas</h3>
                        <p>Las rosas más frescas y hermosas para expresar tus sentimientos.</p>
                    </div>
                </div>
                <div class="card">
                    <img src="./Public/Img/Temporada.jpg" alt="Arreglos de Temporada">
                    <div>
                        <h3>Arreglos de Temporada</h3>
                        <p>Diseños únicos con las flores más frescas de cada estación.</p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>