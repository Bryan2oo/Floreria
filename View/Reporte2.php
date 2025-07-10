<?php
require_once(__DIR__.'/../fpdf182/fpdf.php');

class PDF extends FPDF {
    function Header() {
        // Fondo verde
        $this->SetFillColor(26, 118, 55);
        $this->Rect(0, 0, 210, 30, 'F');
        
        // Logo con verificación
        $logoPath = __DIR__.'/../Public/Img/LogoEspoch.png';
        if(file_exists($logoPath)) {
            $this->Image($logoPath, 10, 6, 20);
        } else {
            $this->SetTextColor(255, 0, 0);
            $this->SetFont('Arial','',10); // 👈 AÑADIDO: Fuente antes de escribir texto
            $this->Text(10, 20, utf8_decode('Error: Logo no encontrado'));
        }
        
        // Texto institucional con utf8_decode para mostrar bien tildes y caracteres especiales
        $this->SetFont('Arial','B',12);
        $this->SetTextColor(255,255,255);
        $this->SetXY(35,8);
        $this->Cell(0,5,utf8_decode('ESCUELA SUPERIOR POLITÉCNICA DE CHIMBORAZO'),0,1,'L');
        $this->SetX(35);
        $this->SetFont('Arial','',10);
        $this->Cell(0,5,utf8_decode('Sistema de Gestión Académica - ESPOCH Virtual'),0,1,'L');
        
        // Línea separadora
        $this->SetDrawColor(255,255,255);
        $this->Line(10,30,200,30);
        $this->Ln(20);
        
        // Título
        $this->SetFont('Arial','B',14);
        $this->SetTextColor(0,0,0);
        $this->Cell(0,10,utf8_decode('REPORTE DE PRODUCTOS MAS VENDIDOS'),0,1,'C');
        $this->Ln(5);
    }

    function Footer() {
        // Fondo rojo
        $this->SetFillColor(178,34,34);
        $this->Rect(0, 280, 210, 17, 'F');
        
        // Texto pie de página
        $this->SetY(-12);
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(255,255,255);
        $this->Cell(0,5,utf8_decode('Reporte generado el ').date('d/m/Y'),0,0,'L');
        $this->Cell(0,5,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');
    }
}
?>