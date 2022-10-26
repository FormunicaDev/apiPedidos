<?php
require_once 'Controller/route.controller.php';
require_once 'Controller/clienteController.php';
require_once 'Controller/productoController.php';
require_once 'Controller/vendedorController.php';
require_once 'Controller/pedidosController.php';
require_once 'Controller/bancoController.php';
require_once 'Models/clienteModel.php';
require_once 'Models/pedidosModel.php';
require_once 'Models/bancoModel.php';

$rutas = new ControllerRoute();

$rutas->inicio();
