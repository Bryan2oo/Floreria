<?php
// Incluir archivos con rutas absolutas
require_once(__DIR__.'/../View/Reporte3.php');
require_once(__DIR__.'/../Config/conexion.php');

// Conexión a BD
$conectBd = mysqli_connect(hostname: 'localhost', username: 'root', password: '', database: 'floreria_db');
if (!$conectBd) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta SQL de productos con descuento (versión corregida)
$sql = "SELECT p.id, p.nombre, p.tipo, pr.descuento_porcentaje, p.precio, p.stock, 
               GROUP_CONCAT(DISTINCT c.nombre SEPARATOR ', ') AS categorias
        FROM productos p
        JOIN promocion_producto pp ON p.id = pp.producto_id
        JOIN promociones pr ON pp.promocion_id = pr.id
        LEFT JOIN producto_categoria pc ON p.id = pc.producto_id
        LEFT JOIN categorias_ocasion c ON pc.categoria_id = c.id
        GROUP BY p.id
        ORDER BY pr.descuento_porcentaje DESC, p.nombre ASC";

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
$pdf->SetFillColor(204, 255, 204); // Color verde claro para el encabezado
$pdf->SetFont('','B');
$pdf->Cell(15,8,"ID",1,0,'C',1);
$pdf->Cell(45,8,"NOMBRE",1,0,'C',1);
$pdf->Cell(25,8,"TIPO",1,0,'C',1);
$pdf->Cell(25,8,"DESCUENTO",1,0,'C',1);
$pdf->Cell(25,8,"PRECIO",1,0,'C',1);
$pdf->Cell(45,8,"CATEGORIAS",1,1,'C',1);

// Datos de la tabla
$pdf->SetFont('Times','',10);
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $pdf->Cell(15,8,$fila['id'],1,0,'C');
        $pdf->Cell(45,8,utf8_decode($fila['nombre']),1,0,'L');
        $pdf->Cell(25,8,ucfirst($fila['tipo']),1,0,'C');
        $pdf->Cell(25,8,$fila['descuento_porcentaje'].'%',1,0,'C');
        $pdf->Cell(25,8,'$'.number_format($fila['precio'],2),1,0,'R');
        $pdf->Cell(45,8,utf8_decode($fila['categorias'] ?: 'Sin categoría'),1,1,'L');
    }
}
// Pie de página
$pdf->Ln(10);
$pdf->SetFont('Arial','I',8);
// Salida del PDF
$pdf->Output('I', 'Reporte_Productos_Descuento_'.date('Ymd_His').'.pdf');
exit;
?>