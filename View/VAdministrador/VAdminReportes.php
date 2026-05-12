<?php
// VAdminReportes.php
include('../../Model/MAdministrador/MMenuNavAdmin2.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Administrador</title>
    <link rel="stylesheet" href="../../Public/css/stylesMenuNavAdmin.css">
    <link rel="stylesheet" href="../../Public/css/stylesFondo.css">
    <link rel="stylesheet" href="../../Public/css/stylesReportes.css">
    <link rel="stylesheet" href="../../Public/css/CssAdministrador/stylesNavAdmin.css">
</head>
<body>
    <div class="reportes-container">
    <!-- Reporte 1 -->
    <div class="reporte-card">
        <h3>Todos los Productos</h3>
        <p>Reporte completo del inventario de productos.</p>
        <button class="btn-generar-pdf"onclick="window.open('../../Controller/GenerarReporteProductos.php', '_blank')">Generar PDF</button>
    </div>
    
    <!-- Reporte 2 -->
    <div class="reporte-card">
        <h3>Productos Más Vendidos</h3>
        <p>Listado de los productos con mayores ventas.</p>
        <button class="btn-generar-pdf"onclick="window.open('../../Controller/GenerarReporteMasVendidos.php', '_blank')">Generar PDF</button>
    </div>
    
    <!-- Reporte 3 -->
    <div class="reporte-card">
        <h3>Productos con Descuento</h3>
        <p>Información de productos con promociones activas.</p>
        <button class="btn-generar-pdf"onclick="window.open('../../Controller/GenerarReporteDescuentos.php', '_blank')">Generar PDF</button>
    </div>
    
    <!-- Reporte 4 -->
    <div class="reporte-card">
        <h3>Reporte por Categorías</h3>
        <p>Análisis de ventas y stock por categoría de producto.</p>
         <button class="btn-generar-pdf"onclick="window.open('../../Controller/GenerarReporteCategorias.php', '_blank')">Generar PDF</button>
    </div>
</div>
</body>
</html>