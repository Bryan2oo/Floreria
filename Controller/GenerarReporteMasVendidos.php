<?php
// Incluir archivos con rutas absolutas
require_once(__DIR__.'/../View/Reporte2.php');
require_once(__DIR__.'/../Config/conexion.php');

// Conexión a BD
$conectBd = mysqli_connect(hostname: 'localhost', username: 'root', password: '', database: 'floreria_db');
if (!$conectBd) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta SQL para productos más vendidos (según tu estructura real)
$sql = "SELECT p.id, p.nombre, p.tipo, SUM(dp.cantidad) AS ventas, p.stock
        FROM productos p
        LEFT JOIN detalle_pedido dp ON p.id = dp.producto_id
        LEFT JOIN pedidos pe ON dp.pedido_id = pe.id
        WHERE pe.fecha >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
        GROUP BY p.id
        ORDER BY ventas DESC
        LIMIT 10";

$resultado = mysqli_query($conectBd, $sql) or die("Error en consulta: " . mysqli_error($conectBd));

// Crear PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
// Título del reporte
$pdf->SetFont('Arial','B',16);
//$pdf->Cell(0,10,'Reporte de Productos Mas Vendidos',0,1,'C');
$pdf->Ln(10);

// Encabezados de tabla
$pdf->SetFont('Times','',12);
$pdf->SetFillColor(204, 255, 204);
$pdf->SetFont('','B');
$pdf->Cell(30,6,"ID",1,0,'C',1);
$pdf->Cell(60,6,"NOMBRE",1,0,'C',1);
$pdf->Cell(40,6,"TIPO",1,0,'C',1);
$pdf->Cell(30,6,"VENTAS",1,0,'C',1);
$pdf->Cell(30,6,"STOCK",1,0,'C',1);

// Verificar si hay datos
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $pdf->Ln();
        $pdf->Cell(30,6,$fila['id'],1,0,'C');
        $pdf->Cell(60,6,$fila['nombre'],1,0,'C');
        $pdf->Cell(40,6,$fila['tipo'],1,0,'C');
        $pdf->Cell(30,6,$fila['ventas'] ?? '0',1,0,'C');
        $pdf->Cell(30,6,$fila['stock'],1,0,'C');
    }
}
// Salida del PDF
$pdf->Output('I', 'Reporte_Productos_Mas_Vendidos_'.date('Ymd').'.pdf');
exit;
?>