<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Rol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/css/stylesNav.css">
    <link rel="stylesheet" href="../Public/css/stylesRol.css">
    <link rel="stylesheet" href="../Public/css/stylesFondo.css">
</head>
<body>
    <?php
        // Configuración de visibilidad de botones
    $showOrderButton = false;  // No mostrar el botón de pedido
    $showAccountButton = false; // Mostrar el botón de cuenta
    $showLogoutButton = false; // No mostrar el botón de cerrar sesión
    $showExitButton = true; // Mostrar el botón de salir
    include("../Model/MMenuNav.php"); 
    ?>

    <div class="role-header">
        <h1>Florería J&A</h1>
        <h2>Selecciona tu rol</h2>
    </div>

    <div class="roles-container">
        <!-- Cuadro de Cliente -->
        <div class="role-box usuario" onclick="window.location.href='../View/VSesionD.php'">
            <img src="../Public/Img/User.jpg" alt="Cliente">
            <h3>Cliente</h3>
            <p>Accede para comprar nuestros hermosos arreglos florales.</p>
            <button>Ingresar</button>
        </div>

        <!-- Cuadro de Administrador -->
        <div class="role-box administrador" onclick="window.location.href='../View/VAdminLogin.php'">
            <img src="../Public/Img/Admin.png" alt="Admin">
            <h3>Administrador</h3>
            <p>Accede para gestionar el inventario y pedidos de la florería.</p>
            <button>Ingresar</button>
        </div>
    </div>
</body>
</html>