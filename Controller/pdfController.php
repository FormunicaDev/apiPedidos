<?php
header('Content-type: text/plain; charset=utf-8');
header('Content-type: text/html; charset=utf-8');
header('Content-type: text/html; charset=ISO-8859-1');
date_default_timezone_set('America/Managua');
date_default_timezone_set('UTC');
setlocale(LC_ALL, 'es_NI');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);


require 'vendor/autoload.php';
require('vendor/setasign/fpdf/fpdf.php');

class PDF extends FPDF
{

// Cargar los datos
function LoadData($file)
{
    // Leer las líneas del fichero
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

function Header()
{
    // Logo
    $this->Image('files/logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'FORMUNICA - Tomador de Pedidos',1,0,'C');
    // Salto de línea
    $this->Ln(20);
}

function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Pagina '.$this->PageNo().'- Formunica Honduras',0,0,'C');
}

// Una tabla más completa
function ImprovedTable($header,$detalles)
{
    // Anchuras de las columnas
    $w = array(80, 28, 25, 30,25);
    // Cabeceras
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Datos
        $data = json_decode($detalles,true);
        foreach($data as $row)
        {
            $this->SetFont('Arial', 'B', 10);
            $this->Cell($w[0],6,utf8_decode($row["DESCRIPCION"]),'LR');
            $this->Cell($w[1],6,number_format($row["Cantidad"]),'LR');
            $this->Cell($w[2],6,number_format($row["Precio"]),'LR',0,'R');
            $this->Cell($w[3],6,number_format($row["Descuento"]),'LR',0,'R');
            $this->Cell($w[4],6,number_format($row["totalLemp"]),'LR',0,'R');
            $this->Ln();
        }

    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
    $this->Ln();
  }

}

class pdfPedido {
    public function generatePDF($IdPedido,$data,$detail) {
        $pdf = new PDF();

        $datos = json_decode($data,true); 
        $cliente = $datos[0]["cliente"];
        $FechaEmision = $datos[0]["FechaEmision"];
        $vendedor = utf8_decode($datos[0]["vendedor"]);
        $direccion = utf8_decode($datos[0]["direccion"]);
        $celular = $datos[0]["TELEFONO1"];
        $TotalDescuento = $datos[0]["TotalDescuento"];
        $total = $datos[0]["Total"];
        $totalNeto = $datos[0]["TotalNeto"];
        // Títulos de las columnas
        $header = array('Producto', 'Cantidad', 'P.(HNL)', 'Desc.Unit','T.(HNL)');
        // Carga de datos
        //$data = $pdf->LoadData('paises.txt');
        $pdf->SetFont('Arial','',11);
        $pdf->AddPage();
        $pdf->Cell(0,10,'N# Orden de Pedido: '.$IdPedido ,0,1);
        $pdf->Cell(0,10,'Cliente: '.$cliente,0,1);
        $pdf->Cell(0,10,'Fecha: '.$FechaEmision,0,1);
        $pdf->Cell(0,10,'Vendedor: '.$vendedor,0,1);
        $pdf->Cell(0,10,'Direccion de entrega: '.$direccion,0,1);
        $pdf->Cell(0,10,'Contacto: '.$celular,0,1);
        $pdf->Cell(0,10,' ',0,1);
        $pdf->ImprovedTable($header,$detail);
        $pdf->Cell(0,10,' ',0,1);
        $pdf->Cell(0,10,' ',0,1);
        $pdf->setX(110);
        $pdf->Cell(0,10,'Total Descuento: '.number_format($TotalDescuento),0,1);
        $pdf->setX(110);
        $pdf->Cell(0,10,'Total Lempiras: '.number_format($total),0,1);
        $pdf->setX(110);
        $pdf->Cell(0,10,'Total: '.number_format($totalNeto),0,1);
        $fecha = date('Y-m-d H:i:s');
        $nameFile = "pedido ".$IdPedido.".pdf";
        $pdf->Output("./files/".$nameFile,"F");

        return strval($nameFile);
    }
}


 ?>
