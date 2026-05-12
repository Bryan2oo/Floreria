<?php
// Incluir archivos con rutas absolutas
require_once(__DIR__.'/../View/Reporte4.php');
require_once(__DIR__.'/../Config/conexion.php');

// Conexión a BD
$conectBd = mysqli_connect(hostname: 'localhost', username: 'root', password: '', database: 'floreria_db');
if (!$conectBd) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta SQL para reporte por categorías
$sql = "SELECT c.id, c.nombre AS categoria, COUNT(pc.producto_id) AS cantidad_productos
        FROM categorias_ocasion c
        LEFT JOIN producto_categoria pc ON c.id = pc.categoria_id
        GROUP BY c.id, c.nombre
        ORDER BY c.nombre";

$resultado = mysqli_query($conectBd, $sql) or die("Error en consulta: " . mysqli_error($conectBd));

// Crear PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Título del reporte
$pdf->SetFont('Arial','B',16);
$pdf->Ln(10);

// Encabezados de tabla
$pdf->SetFont('Times','',12);
$pdf->SetFillColor(204, 255, 204);
$pdf->SetFont('','B');
$pdf->Cell(30,6,"ID",1,0,'C',1);
$pdf->Cell(80,6,"CATEGORIA",1,0,'C',1);
$pdf->Cell(60,6,"CANTIDAD DE PRODUCTOS",1,0,'C',1);

// Datos de la tabla
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_array($resultado)) {
        $pdf->Ln();
        $pdf->Cell(30,6,$fila['id'],1,0,'C');
        $pdf->Cell(80,6,$fila['categoria'],1,0,'C');
        $pdf->Cell(60,6,$fila['cantidad_productos'],1,0,'C');
    }
} else {
    $pdf->Ln(10);
    $pdf->SetFont('Arial','I',12);
}

// Salida del PDF
$pdf->Output('I', 'Reporte_Categorias_'.date('Ymd').'.pdf');
exit;
?>