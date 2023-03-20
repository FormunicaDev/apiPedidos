<?php

require_once '../Models/pedidosModel.php';
require_once '../Models/conexion.php';
require_once 'excelController.php';


$pedidoId = $_REQUEST["pedido"];

$array = array("desde" => 1, "hasta" => 100);
$pedido = ModelPedidos::obtenerPedidoAssoc($pedidoId);
$detalles = ModelPedidos::listarDetallePedidoAssoc($pedidoId,$array);

//var_dump($pedido);
//echo $pedido[0]["codCliente"];

ExcelPedido::generateExcel($detalles,$pedido);