<?php
// MMenuNav.php

// Variable para controlar si se muestra el botón de "Cuenta"
$hideAccountButton = $hideAccountButton ?? false;
?>

<header>
    <link rel="stylesheet" href="../../Public/css/stylesMenuNavAdmin.css">
    <!-- Barra de navegación principal -->
    <nav class="navbar" style="font-family: 'Poppins', sans-serif; background-color: #fff9fb;">
        <!-- Logo de la florería -->
        <div class="logo" style="font-family: 'Montserrat', cursive; font-size: 2.5rem; color: #c71585;">
            🌸 Florería J&A
        </div>

        <!-- Botones de navegación -->
        <div class="nav-buttons">
            <!-- Botón de Administrador con Menú Desplegable -->
            <div class="dropdown-container">
                <div id="adminDropdown" class="dropdown-content floral-dropdown">
                    <a href="./../View/VAdministrador/VAdminConfiguracion.php">Configuración</a>
                    <a href="./../View/VAdministrador/VAdminGestionUsuarios.php">Gestionar Usuarios</a>
                    <a href="./../View/VAdministrador/VAdminInventario.php">Inventario Flores</a>
                </div>
            </div>
        <!-- Botón Salir con color naranja original -->
        <div class="dropdown-container">
            <a href="<?php echo dirname(dirname($_SERVER['PHP_SELF'])) . '/IndexP.php'; ?>" 
            class="dropdown-btn" 
            style="background-color: #FFA500; color: white; padding: 8px 15px; border-radius: 20px; text-decoration: none; display: inline-block; font-family: 'Poppins', sans-serif; transition: all 0.3s;">
                🚪 Salir
            </a>
        </div>
    </nav>

    <!-- Menú de navegación floral -->
    <div class="main-menu floral-menu">
        <ul class="nav-menu">
            <li><a href="./../View/VAdmin.php">Inicio</a></li>
            <li><a href="./../View/VAdministrador/VAdminIngresarD.php">Agregar Flores</a></li>
            <li><a href="./../View/VAdministrador/VAdminMostrarD.php">Catálogo</a></li>
            <li><a href="./../View/VAdministrador/VAdminBuscarD.php">Buscar Flores</a></li>
            <li><a href="./../View/VAdministrador/VAdminPedidos.php">Pedidos de Clientes</a></li>
            <li><a href="./../View/VAdministrador/VAdminIngresarCat.php">Modificar categorias</a></li>
            <li><a href="./../View/VAdministrador/VAdminReportes.php">Reportes</a></li>

            
        </ul>
    </div>
</header>