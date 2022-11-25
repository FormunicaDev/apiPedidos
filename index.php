<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

require_once 'Controller/route.controller.php';
require_once 'Controller/clienteController.php';
require_once 'Controller/vendedorController.php';
require_once 'Controller/pedidosController.php';
require_once 'Controller/bancoController.php';
require_once 'Controller/formapagoController.php';
require_once 'Controller/tipoventaController.php';
require_once 'Controller/vendedorController.php';
require_once 'Controller/productosController.php';
require_once 'Controller/loginController.php';
require_once 'Controller/usuarioController.php';
require_once 'Controller/estadisticaController.php';
require_once 'Controller/emailController.php';
require_once 'Controller/pdfController.php';
require_once 'Controller/configController.php';
require_once 'Models/clienteModel.php';
require_once 'Models/pedidosModel.php';
require_once 'Models/bancoModel.php';
require_once 'Models/formapagoModel.php';
require_once 'Models/tipoventaModel.php';
require_once 'Models/vendedorModel.php';
require_once 'Models/loginModel.php';
require_once 'Models/productosModel.php';
require_once 'Models/usuarioModel.php';
require_once 'Models/estadisticaModel.php';
require_once 'Models/emailModel.php';
require_once 'Models/configModel.php';
require_once 'Common/paginacion.php';

require_once 'Models/usuarioVendedor.php';
require_once 'Controller/usuarioVendedorController.php';

$rutas = new ControllerRoute();

$rutas->inicio();
