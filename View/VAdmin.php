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
    <link rel="stylesheet" href="../Public/css/CssAdministrador/stylesPanelAdmin.css">
    <link rel="stylesheet" href="../Public/css/stylesFondo.css">
    
    <!-- NUEVO CSS SEGÚN CCB-2026-001 -->
    <style>
        /* ============================================ */
        /* CAMBIOS APROBADOS CCB-2026-001 - Dashboard UI */
        /* Fecha: 02/06/2026 - Implementado por Walter Reyes */
        /* ============================================ */
        
        /* Cambio 1: Fondo del Dashboard - slate-100 */
        body {
            background-color: #F1F5F9 !important;
        }
        
        .admin-container {
            background-color: #F1F5F9;
        }
        
        /* Cambio 2: Tarjetas KPI - borde superior teal y hover */
        .kpi-card {
            border-top: 4px solid #0D9488 !important;
            transition: transform 0.2s ease-in-out;
        }
        
        .kpi-card:hover {
            transform: translateY(-5px);
        }
        
        /* Cambio 3: Tarjetas KPI - tipografía grande y negrita */
        .kpi-number {
            font-size: 2rem !important;
            font-weight: 700 !important;
            margin: 15px 0;
            color: #0D9488;
        }
        
        /* Cambio 4: Botón Nuevo Pedido - estilo primary (#2563EB) */
        .btn-new-order {
            background-color: #2563EB !important;
            border-color: #2563EB !important;
            color: white !important;
            width: 100%;
            margin-bottom: 8px;
        }
        
        .btn-new-order:hover {
            background-color: #1d4ed8 !important;
        }
        
        /* Cambio 5: Separador para sección Reportes */
        .reports-separator {
            margin: 2rem 0 1.5rem 0;
            border-top: 2px solid #e9ecef;
        }
        
        /* Cambio 6: Responsividad según RNF-USA-01 */
        @media (max-width: 768px) {
            .kpi-number {
                font-size: 1.5rem !important;
            }
        }
        
        /* Tarjeta de Accesos Rápidos */
        .quick-actions-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            height: 100%;
        }
        
        .quick-actions-card a {
            display: block;
            text-decoration: none;
        }
        
        /* Tabla de últimos pedidos */
        .table-custom {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .section-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .section-title-custom {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }
    </style>
</head>
<body>
    <?php 
    session_start();
    if (!isset($_SESSION["admin"])) {
        header("Location: ../View/VIngresar.php");
        exit();
    }
    include("../Model/MAdministrador/MMenuNavAdmin.php"); 
    
    // =============================================
    // CONSULTAS PARA DATOS REALES (Base de datos)
    // =============================================
    include_once("../Model/conexion.php");
    
    // 1. Pedidos Pendientes
    $queryPedidos = "SELECT COUNT(*) as total FROM pedidos WHERE estado IN ('pendiente', 'procesando')";
    $resultPedidos = mysqli_query($conexion, $queryPedidos);
    $pedidosPendientes = mysqli_fetch_assoc($resultPedidos)['total'] ?? 0;
    
    // 2. Resumen de Ventas del Mes
    $queryVentas = "SELECT COALESCE(SUM(total), 0) as total FROM pedidos 
                    WHERE MONTH(fecha) = MONTH(CURDATE()) 
                    AND YEAR(fecha) = YEAR(CURDATE())
                    AND estado = 'completado'";
    $resultVentas = mysqli_query($conexion, $queryVentas);
    $ventasMes = mysqli_fetch_assoc($resultVentas)['total'] ?? 0;
    
    // 3. Stock Bajo (productos con stock < 10)
    $queryStock = "SELECT COUNT(*) as total FROM productos WHERE stock < 10 AND stock > 0";
    $resultStock = mysqli_query($conexion, $queryStock);
    $stockBajo = mysqli_fetch_assoc($resultStock)['total'] ?? 0;
    
    // 4. Stock Agotado (alerta adicional)
    $queryAgotado = "SELECT COUNT(*) as total FROM productos WHERE stock <= 0";
    $resultAgotado = mysqli_query($conexion, $queryAgotado);
    $stockAgotado = mysqli_fetch_assoc($resultAgotado)['total'] ?? 0;
    
    // 5. Últimos Pedidos (para Fila 2 - col-md-8)
    $queryUltimosPedidos = "SELECT p.id, p.total, p.fecha, p.estado, 
                                   u.nombre as cliente 
                            FROM pedidos p 
                            JOIN usuarios u ON p.usuario_id = u.id 
                            ORDER BY p.fecha DESC 
                            LIMIT 5";
    $ultimosPedidos = mysqli_query($conexion, $queryUltimosPedidos);
    
    // 6. Ventas por Categoría (para Fila 2 - col-md-4)
    $queryCategorias = "SELECT c.nombre as categoria, 
                               COALESCE(SUM(dp.subtotal), 0) as total 
                        FROM categorias c
                        LEFT JOIN productos pr ON c.id = pr.categoria_id
                        LEFT JOIN detalle_pedido dp ON pr.id = dp.producto_id
                        LEFT JOIN pedidos p ON dp.pedido_id = p.id
                        GROUP BY c.id
                        LIMIT 5";
    $ventasCategorias = mysqli_query($conexion, $queryCategorias);
    ?>
    
    <main class="admin-container" style="padding: 20px; max-width: 1400px; margin: 0 auto;">
        
        <!-- ============================================= -->
        <!-- FILA 1: 4 TARJETAS KPI (col-md-3 cada una)    -->
        <!-- SEGÚN CCB-2026-001 - Prioridad ALTA/CRÍTICA   -->
        <!-- ============================================= -->
        <div class="row g-4 mb-4">
            <!-- 1. Pedidos Pendientes (CRÍTICO) -->
            <div class="col-md-3">
                <div class="section-card kpi-card">
                    <div style="text-align: center;">
                        <i class="fas fa-clipboard-list" style="font-size: 2rem; color: #0D9488;"></i>
                        <div class="kpi-number"><?php echo $pedidosPendientes; ?></div>
                        <p style="color: #6c757d; margin: 0;">Pedidos Pendientes</p>
                        <a href="../View/VAdministrador/VAdminPedidos.php" class="btn btn-sm btn-outline-primary mt-3">
                            <i class="fas fa-arrow-right"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- 2. Resumen de Ventas del Mes (CRÍTICO) -->
            <div class="col-md-3">
                <div class="section-card kpi-card">
                    <div style="text-align: center;">
                        <i class="fas fa-chart-line" style="font-size: 2rem; color: #0D9488;"></i>
                        <div class="kpi-number">$<?php echo number_format($ventasMes, 2); ?></div>
                        <p style="color: #6c757d; margin: 0;">Ventas del Mes</p>
                        <a href="../View/VAdministrador/VAdminReportes.php" class="btn btn-sm btn-outline-primary mt-3">
                            <i class="fas fa-chart-bar"></i> Ver Reportes
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- 3. Stock Bajo (CRÍTICO - Alerta) -->
            <div class="col-md-3">
                <div class="section-card kpi-card">
                    <div style="text-align: center;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: #f59e0b;"></i>
                        <div class="kpi-number" style="color: #f59e0b;"><?php echo $stockBajo; ?></div>
                        <p style="color: #6c757d; margin: 0;">Productos con Stock Bajo</p>
                        <?php if($stockAgotado > 0): ?>
                            <small style="color: red;">⚠️ <?php echo $stockAgotado; ?> agotados</small>
                        <?php endif; ?>
                        <a href="../View/VAdministrador/VAdminMostrarD.php" class="btn btn-sm btn-outline-warning mt-3">
                            <i class="fas fa-boxes"></i> Revisar Stock
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- 4. Accesos Rápidos (OPERATIVO) -->
            <div class="col-md-3">
                <div class="quick-actions-card">
                    <div style="text-align: center; margin-bottom: 15px;">
                        <i class="fas fa-bolt" style="font-size: 2rem; color: #2563EB;"></i>
                        <h5 style="margin-top: 10px;">Accesos Rápidos</h5>
                    </div>
                    <!-- Botón Nuevo Pedido con estilo primary según CCB-2026-001 -->
                    <a href="../View/VAdministrador/VAdminPedidos.php?action=nuevo" class="btn btn-new-order">
                        <i class="fas fa-plus-circle"></i> Nuevo Pedido
                    </a>
                    <a href="../View/VAdministrador/VAdminIngresarD.php" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="fas fa-plus"></i> Nuevo Producto
                    </a>
                    <a href="../View/VAdministrador/VAdminMostrarD.php" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="fas fa-edit"></i> Editar Inventario
                    </a>
                    <a href="" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-users"></i> Gestionar Clientes
                    </a>
                </div>
            </div>
        </div>
        
        <!-- ============================================= -->
        <!-- FILA 2: ÚLTIMOS PEDIDOS (col-md-8) +          -->
        <!--         GRÁFICO VENTAS CATEGORÍA (col-md-4)   -->
        <!-- SEGÚN CCB-2026-001 - Prioridad MEDIA          -->
        <!-- ============================================= -->
        <div class="row g-4 mb-4">
            <!-- Columna Izquierda: Últimos Pedidos - Tabla (col-md-8) -->
            <div class="col-md-8">
                <div class="section-card">
                    <h5 class="section-title-custom">
                        <i class="fas fa-shopping-cart"></i> Últimos Pedidos
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($ultimosPedidos) > 0): ?>
                                    <?php while($pedido = mysqli_fetch_assoc($ultimosPedidos)): ?>
                                    <tr>
                                        <td>#<?php echo $pedido['id']; ?></td>
                                        <td><?php echo htmlspecialchars($pedido['cliente']); ?></td>
                                        <td>$<?php echo number_format($pedido['total'], 2); ?></td>
                                        <td>
                                            <?php
                                            $badgeClass = '';
                                            switch($pedido['estado']) {
                                                case 'pendiente': $badgeClass = 'badge bg-warning'; break;
                                                case 'procesando': $badgeClass = 'badge bg-info'; break;
                                                case 'completado': $badgeClass = 'badge bg-success'; break;
                                                default: $badgeClass = 'badge bg-secondary';
                                            }
                                            ?>
                                            <span class="<?php echo $badgeClass; ?>"><?php echo ucfirst($pedido['estado']); ?></span>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($pedido['fecha'])); ?></td>
                                        <td>
                                            <a href="../View/VAdministrador/VAdminPedidos.php?id=<?php echo $pedido['id']; ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No hay pedidos registrados</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="../View/VAdministrador/VAdminPedidos.php" class="btn btn-outline-primary">
                            <i class="fas fa-list"></i> Ver todos los pedidos
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Columna Derecha: Gráfico Ventas por Categoría (col-md-4) -->
            <div class="col-md-4">
                <div class="section-card">
                    <h5 class="section-title-custom">
                        <i class="fas fa-chart-pie"></i> Ventas por Categoría
                    </h5>
                    <canvas id="ventasChart" style="max-height: 250px; width: 100%;"></canvas>
                    <hr>
                    <div class="mt-3">
                        <?php 
                        mysqli_data_seek($ventasCategorias, 0);
                        while($categoria = mysqli_fetch_assoc($ventasCategorias)): 
                        ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="fas fa-flower"></i> <?php echo htmlspecialchars($categoria['categoria']); ?></span>
                            <span class="badge bg-primary rounded-pill">$<?php echo number_format($categoria['total'], 2); ?></span>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- ============================================= -->
        <!-- FILA 3: REPORTES ESTADÍSTICOS (col-md-12)     -->
        <!-- SEGÚN CCB-2026-001 - Prioridad BAJA          -->
        <!-- Ubicado al final con separador                -->
        <!-- ============================================= -->
        <div class="reports-separator"></div>
        
        <div class="row">
            <div class="col-12">
                <div class="section-card">
                    <h5 class="section-title-custom">
                        <i class="fas fa-file-alt"></i> Reportes Estadísticos
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="../View/VAdministrador/VAdminReportes.php?tipo=ventas" class="text-decoration-none">
                                <div class="text-center p-3 border rounded hover-shadow">
                                    <i class="fas fa-chart-line" style="font-size: 2rem; color: #0D9488;"></i>
                                    <p class="mt-2 mb-0 fw-bold">Reporte de Ventas</p>
                                    <small class="text-muted">Diarias, semanales, mensuales</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="../View/VAdministrador/VAdminReportes.php?tipo=productos" class="text-decoration-none">
                                <div class="text-center p-3 border rounded hover-shadow">
                                    <i class="fas fa-trophy" style="font-size: 2rem; color: #f59e0b;"></i>
                                    <p class="mt-2 mb-0 fw-bold">Productos Más Vendidos</p>
                                    <small class="text-muted">Top productos y tendencias</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="../View/VAdministrador/VAdminReportes.php?tipo=clientes" class="text-decoration-none">
                                <div class="text-center p-3 border rounded hover-shadow">
                                    <i class="fas fa-crown" style="font-size: 2rem; color: #8b5cf6;"></i>
                                    <p class="mt-2 mb-0 fw-bold">Clientes Frecuentes</p>
                                    <small class="text-muted">Clientes con más compras</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="../View/VAdministrador/VAdminReportes.php?tipo=inventario" class="text-decoration-none">
                                <div class="text-center p-3 border rounded hover-shadow">
                                    <i class="fas fa-boxes" style="font-size: 2rem; color: #ec489a;"></i>
                                    <p class="mt-2 mb-0 fw-bold">Reporte de Inventario</p>
                                    <small class="text-muted">Rotación y stock crítico</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <script>
        // Gráfico de Ventas por Categoría según CCB-2026-001
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('ventasChart');
            if(ctx) {
                // Datos desde PHP
                const categorias = <?php 
                    mysqli_data_seek($ventasCategorias, 0);
                    $nombres = [];
                    while($row = mysqli_fetch_assoc($ventasCategorias)) {
                        $nombres[] = $row['categoria'];
                    }
                    echo json_encode($nombres);
                ?>;
                
                const valores = <?php 
                    mysqli_data_seek($ventasCategorias, 0);
                    $totales = [];
                    while($row = mysqli_fetch_assoc($ventasCategorias)) {
                        $totales[] = $row['total'];
                    }
                    echo json_encode($totales);
                ?>;
                
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: categorias,
                        datasets: [{
                            label: 'Ventas ($)',
                            data: valores,
                            backgroundColor: '#0D9488',
                            borderRadius: 8,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: { font: { size: 11 } }
                            }
                        },
                        scales: {
                            y: { beginAtZero: true, title: { display: true, text: 'Monto ($)' } },
                            x: { ticks: { font: { size: 10 } } }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>