<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Florería JyA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Public/css/CssAdministrador/stylesNavAdmin.css">
    <link rel="stylesheet" href="../Public/css/CssAdministrador/stylesIndexAdmin.css">
    <link rel="stylesheet" href="../Public/css/CssAdministrador/stylesPanelAdmin.css">
    <link rel="stylesheet" href="../Public/css/stylesFondo.css">
</head>
<body>
    <?php 
    session_start();
    if (!isset($_SESSION["admin"])) {
        header("Location: ../View/VIngresar.php");
        exit();
    }
    include("../Model/MAdministrador/MMenuNavAdmin.php"); 
    ?>
    
    <!-- Contenido principal del panel de administrador -->
    <main class="admin-container">
        <!-- Encabezado del panel -->
        <header class="admin-header">
            <h1 class="admin-title">🌺 Panel de Administración</h1>
            <p class="admin-subtitle">Bienvenido, administrador. Gestiona tu floristería con elegancia.</p>
        </header>

        <!-- Estadísticas rápidas -->
        <section class="admin-stats">
            <h2 class="section-title">📊 Estadísticas Rápidas</h2>
            <div class="stats-grid">
                <div class="stat-card card-flores">
                    <h3 class="stat-title"><i class="fas fa-spa"></i> Flores Disponibles</h3>
                    <p class="stat-value">85 variedades</p>
                    <a href="../View/VAdministrador/VAdminMostrarD.php" class="btn btn-stat">
                        <i class="fas fa-arrow-right"></i> Ver Inventario
                    </a>
                </div>
                <div class="stat-card card-arreglos">
                    <h3 class="stat-title"><i class="fas fa-bouquet"></i> Arreglos Vendidos</h3>
                    <p class="stat-value">42 este mes</p>
                    <a href="" class="btn btn-stat">
                        <i class="fas fa-arrow-right"></i> Ver Arreglos
                    </a>
                </div>
                <div class="stat-card card-pedidos">
                    <h3 class="stat-title"><i class="fas fa-clipboard-list"></i> Pedidos Pendientes</h3>
                    <p class="stat-value">7 por preparar</p>
                    <a href="../View/VAdministrador/VAdminPedidos.php" class="btn btn-stat">
                        <i class="fas fa-arrow-right"></i> Gestionar Pedidos
                    </a>
                </div>
            </div>
        </section>

        <!-- Acciones rápidas -->
        <section class="admin-actions">
            <h2 class="section-title">🚀 Acciones Rápidas</h2>
            <div class="actions-grid">
                <a href="../View/VAdministrador/VAdminIngresarD.php" class="action-card card-agregar">
                    <div class="action-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h3 class="action-title">Agregar Flores</h3>
                    <p class="action-desc">Añade nuevas variedades al catálogo</p>
                </a>
                <a href="" class="action-card card-clientes">
                    <div class="action-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="action-title">Gestionar Clientes</h3>
                    <p class="action-desc">Administra la base de clientes</p>
                </a>
                <a href="../AyudaAdmin.php" class="action-card card-eventos">
                    <div class="action-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="action-title">Ayuda</h3>
                    <p class="action-desc">Conoce de mejor manera tu página</p>
                </a>
            </div>
        </section>

        <!-- Últimas actividades -->
        <section class="admin-activities">
            <h2 class="section-title">🕒 Actividad Reciente</h2>
            <div class="activities-list">
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text"><strong>Pedido entregado:</strong> Arreglo "Amor Eterno"</p>
                        <small class="activity-time">Hace 1 hora</small>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text"><strong>Nuevo cliente registrado:</strong> María González</p>
                        <small class="activity-time">Hace 3 horas</small>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-spa"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text"><strong>Flor agregada:</strong> Rosas azules (nueva variedad)</p>
                        <small class="activity-time">Ayer, 14:30</small>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>