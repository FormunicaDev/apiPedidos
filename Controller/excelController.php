<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);

require 'vendor/autoload.php';
require 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Spreadsheet.php';

class ExcelPedido
{
    static public function generateExcel($detalles, $pedido)
    {
        $detalles = json_decode($detalles,true);
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("FORMUNICA S.A")
                                        ->setLastModifiedBy("FORMUNICA S.A")
                                        ->setTitle("Pedidos de clientes")
                                        ->setSubject("Pedidos")
                                        ->setDescription("Listado de pedidos de clientes.")
                                        ->setKeywords("pedidos clientes excel");


        // Crear una nueva hoja de cálculo
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Pedidos');


        // Escribir los encabezados de las columnas
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Codigo Cliente')
                                        ->setCellValue('B1', 'Cliente')
                                        ->setCellValue('C1', 'Fecha')
                                        ->setCellValue('D1', 'No Pedido')
                                        ->setCellValue('E1', 'Articulo')
                                        ->setCellValue('F1', 'Descripcion')
                                        ->setCellValue('G1', 'Cantidad')
                                        ->setCellValue('H1', 'Nombre y telefono')
                                        ->setCellValue('I1', 'Direccion de entrega');

        // Escribir los datos de los registros
        $fila = 2;

        foreach ($detalles as $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$fila,$pedido[0]["codCliente"])
                                            ->setCellValue('B'.$fila,$pedido[0]["cliente"])
                                            ->setCellValue('C'.$fila,$pedido[0]["FechaEmision"])
                                            ->setCellValue('D'.$fila,$pedido[0]["IdPedido"])
                                            ->setCellValue('E'.$fila,$value["CodProducto"])
                                            ->setCellValue('F'.$fila,$value["DESCRIPCION"])
                                            ->setCellValue('G'.$fila,$value["Cantidad"])
                                            ->setCellValue('H'.$fila,"-")
                                            ->setCellValue('I'.$fila,$pedido[0]["Comentarios"]);

            $fila++;
        }

        // Ajustar el ancho de las columnas automáticamente
        foreach(range('A', 'I') as $columna) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setAutoSize(true);
        }

        // Guardar el archivo Excel en disco
        $ruta = "files/";
        $fecha = date('Y-m-d');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $fileName = 'pedido_'.$fecha." ".$pedido[0]["IdPedido"].'.xlsx';
        $objWriter->save($ruta.$fileName);

        return strval($fileName);

    }
}


