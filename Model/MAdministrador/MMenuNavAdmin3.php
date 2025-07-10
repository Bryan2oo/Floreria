<?php
// MMenuNav.php

// Configuración de rutas
$adminMainPage = '../../View/VInterfazUsuario.php'; // Ruta a la página principal del admin
$logoutPage = '../../IndexP.php'; // Ruta para cerrar sesión

// Variables de control
$showBackButton = $showBackButton ?? true;
$showLogoutButton = $showLogoutButton ?? true;
?>

<header>
    <link rel="stylesheet" href="../../Public/css/stylesMenuNavAdmin2.css">
    <!-- Barra de navegación principal -->
    <nav class="navbar admin-navbar">
        <!-- Logo con enlace a inicio -->
        <a href="<?= $adminMainPage ?>" class="logo-link">
            <div class="logo">
                <span class="logo-icon">🌸</span>
                <span class="logo-text">Florería J&A</span>
            </div>
        </a>

        <!-- Botones de navegación -->
        <div class="nav-buttons">
            <?php if ($showBackButton): ?>
            <!-- Botón de Regresar simple -->
            <a href="<?= $adminMainPage ?>" class="back-btn">
                <span class="btn-icon">🌷</span>
                <span class="btn-text">Regresar</span>
            </a>
            <?php endif; ?>

            <?php if ($showLogoutButton): ?>
            <?php endif; ?>
        </div>
    </nav>
</header>

<script>
// Función solo para el dropdown de salida
function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    dropdown.classList.toggle('show');
}

// Cerrar dropdown al hacer clic fuera
document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown-container')) {
        document.querySelectorAll('.dropdown-content.show').forEach(dropdown => {
            dropdown.classList.remove('show');
        });
    }
});
</script>