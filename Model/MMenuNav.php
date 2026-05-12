<?php
// Verifica si la variable está definida antes de usarla
$showOrderButton = isset($showOrderButton) ? $showOrderButton : false;
$showLogoutButton = isset($showLogoutButton) ? $showLogoutButton : false;
$showAccountButton = isset($showAccountButton) ? $showAccountButton : true;
$showExitButton = isset($showExitButton) ? $showExitButton : false;
?>
<header>
    <script src="../Public/js/index1.js"></script>
    <!-- Barra de navegación principal -->
    <nav class="navbar" style="font-family: 'Roboto', sans-serif;">
        <!-- Título de la florería con ícono de flor y tipografía Lobster -->
        <div class="logo" style="font-family: 'Lobster', cursive; font-size: 2.5rem; color: #FF6347;">
            🏵️ Florería J&A
        </div>

        <!-- Botones de navegación alineados a la derecha -->
        <div class="nav-buttons" style="float: right;">
            <?php if ($showAccountButton): ?>
                <button class="account-btn" onclick="window.location.href='Controller/usercontrolador.php?Opcion=1'" type="button" aria-label="Ir a la cuenta">
                    👤 Cuenta
                </button>
            <?php endif; ?>

            <?php if ($showLogoutButton): ?>    
                <button class="logout-btn" onclick="confirmLogout()" type="button" aria-label="Cerrar sesión">
                    ⬅️ Cerrar sesión
                </button>
            <?php endif; ?>

            <?php if ($showExitButton): ?>
                <button class="exit-btn" onclick="confirmExit()" type="button" aria-label="Salir del sitio">
                    🔑 Salir
                </button>
            <?php endif; ?>
        </div>
    </nav>
</header>