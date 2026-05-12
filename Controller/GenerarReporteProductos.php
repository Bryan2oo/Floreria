<?php
// Incluir archivos con rutas absolutas
require_once(__DIR__.'/../View/Reporte1.php');
require_once(__DIR__.'/../Config/conexion.php');

// Conexión a BD
$conectBd=mysqli_connect(hostname: 'localhost', username:'root', password:'', database:'floreria_db');
if (!$conectBd) {
    die("Error de conexión: " . mysqli_connect_error());
}
// Consulta SQL
$sql = "SELECT id, nombre, tipo, precio, stock FROM productos";
$resultado = mysqli_query($conectBd, $sql) or die("Error en consulta: " . mysqli_error($conexion));
// Crear PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Encabezados de tabla
$pdf->SetFont('Times','',12);
$pdf->SetFillColor(204, 255, 204);
$pdf->SetFont('','B');
$pdf->Cell(30,6,"ID",1,0,'C',1);
$pdf->Cell(60,6,"NOMBRE",1,0,'C',1);
$pdf->Cell(40,6,"TIPO",1,0,'C',1);
$pdf->Cell(30,6,"PRECIO",1,0,'C',1);
$pdf->Cell(20,6,"STOCK",1,0,'C',1);

// Datos de la tabla
while($fila = mysqli_fetch_array($resultado)){
    $pdf->Ln();
    $pdf->Cell(30,6,$fila['id'],1,0,'C');
    $pdf->Cell(60,6,$fila['nombre'],1,0,'C');
    $pdf->Cell(40,6,$fila['tipo'],1,0,'C');
    $pdf->Cell(30,6,'$'.number_format($fila['precio'],2),1,0,'C');
    $pdf->Cell(20,6,$fila['stock'],1,0,'C');
}

// Salida del PDF
$pdf->Output('I', 'Reporte_Productos_'.date('Ymd').'.pdf');
exit;
?>