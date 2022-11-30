<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS, post, get');
header("Access-Control-Max-Age", "8600");
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Access-Control-Allow-Credentials", "true");
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

$arrayRutas=explode("/",$_SERVER["REQUEST_URI"]);
$login = new loginController();
$jwt = null;
$cantidad = null;
$page = null;

if (preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
    $jwt = $matches[1];
}

if(isset($_GET["cantidad"]))
{
  $cantidad = $_GET["cantidad"];
  $page = $_GET["page"];
}
else
{
  $cantidad = 0;
  $page = 0;
}

  if(count(array_filter($arrayRutas)) == 1) {
      $json = array(
        "Detalle"=>"No Encontrado",
        "StatusCode"=>"404"
      );
      echo json_encode($json,true);

      return;

  }else {
    if(count(array_filter($arrayRutas))>=2) {

      // parametros capturados por la ruta - endpoint y id
      $ruta = array_filter($arrayRutas)[2];
      $ruta = explode("?",$ruta);
      $ruta = $ruta[0];
      $ID = null;

      if(isset(array_filter($arrayRutas)[3])) {
        $ID = array_filter($arrayRutas)[3];
      }

      // saber que tipo de solicitud http se esta recibiendo
      $metodo = $_SERVER['REQUEST_METHOD'];

      switch ($ruta) {
        // endpoint cliente
        case 'clientes':
            $clientes = new ControllerCliente();

            if ($metodo == 'POST')
            {
              if($login->validaToken($jwt))
              {

              }
              else
              {
                $login->validaToken($jwt);
              }
            }
            if($metodo == 'GET')
            {
              //valida si se envia un parametro despues del endpoint y si este es un ID
              if($ID != null || $ID != 0)
              {
                  if($login->validaToken($jwt))
                  {
                      $clientes->getById($ID);
                  }else{
                      $login->validaToken($jwt);
                  }
              }
              else
              {
                  if($login->validaToken($jwt) == "ok")
                  {
                      $clientes->getClientes();
                  }
                  else{
                      echo $login->validaToken($jwt);
                  }

              }

            }
          break;
        //endpoint pedidos
        case 'pedidos':

            $pedidos = new ControllerPedidos();

            if($metodo == "POST")
            {
              if($login->validaToken($jwt) == "ok")
              {
                $request_body = file_get_contents('php://input');
                $data = json_decode($request_body,true);
                //var_dump($data["detallePedido"]);
                $datos = array(
                  "codigo" => $data["codigo"],
                  "codVendedor" => $data["vendedor"],
                  "codCliente" => $data["cliente"],
                  "TipoVenta" => $data["tipoVenta"],
                  "Comentarios" => $data["comentarios"],
                  "Total" => floatval($data["total"]),
                  "TotalDescuento" => $data["totalDescuento"],
                  "TotalNeto" => $data["totalNeto"],
                  "numCheque" => $data["cheque"],
                  "fechaCheque" => $data["fechaCheque"],
                  "Banco"=> $data['banco'],
                  "UsuarioRegistro" => $data['UsuarioRegistro'],
                  "FormaPago"=>$data['formaPago']
                );

                $detalle = $data["detallePedido"];
                $detalleJson = json_encode($detalle);
                $obj = new ArrayObject($detalle);

                //echo($detalle);
                $pedidos->PostPedido($datos,$detalle);
              }
              else
              {
                $login->validaToken($jwt);
              }

            }
            if($metodo == "GET")
            {
              if($ID != null || $ID != 0)
              {
                if($login->validaToken($jwt) == "ok")
                {
                  $cantidad = $_GET["cantidad"];
                  $pagina = $_GET["page"];
                  $pedidos->getDetallePedido($ID,$cantidad,$pagina);
                }
                else
                {
                  $login->validaToken($jwt);
                }
              }
              else
              {
                if($login->validaToken($jwt) == "ok")
                {
                  $cantidad = $_GET["cantidad"];
                  $pagina = $_GET["page"];
                  $usuario = $_GET["user"];
                  if($usuario==null)
                  {
                    $usuario = '';
                  }

                  $pedidos->getPedidos($usuario,$cantidad,$pagina);
                }
                else
                {
                  $login->validaToken($jwt);
                }
              }
            }

            if($metodo == "DELETE")
            {
              if($login->validaToken($jwt) == "ok")
                {
                  $pedidos->deletePedido($ID);
                }
                else
                {
                  $login->validaToken($jwt);
                }
            }
          break;
        case 'detallepedido':
            $pedidos = new ControllerPedidos();
            if($metodo == "GET")
            {
              if($ID != null || $ID != 0)
              {

              }
              else
              {
                if($login->validaToken($jwt) == "ok")
                {
                  $cantidad = $_GET["cantidad"];
                  $pagina = $_GET["page"];
                  $IdPedido= $_GET["IdPedido"];
                  $pedidos->getDetallePedido($IdPedido,$cantidad,$pagina);
                }
                else
                {
                  $login->validaToken($jwt);
                }
              }
            }

            if($metodo = "DELETE")
            {
              if($ID != null || $ID != 0)
              {
                $pedidos->deleteDetallePedido($ID);
              }
            }
          break;
        case 'banco':
            $banco = new ControllerBanco();

            if($metodo == "POST")
            {
              if($login->validaToken($jwt) == "ok")
              {
                $datos = array(
                  "Banco"=>$_POST["Banco"],
                  "UsuarioRegistro"=>$_POST["usuario"]
                );

                $banco->postBanco($datos);
              }
              else
              {
                $login->validaToken($jwt);
              }
            }

            if($metodo == "GET")
            {
              if($ID != null || $ID != 0)
              {
                if($login->validaToken($jwt) == "ok")
                {
                  $banco->getBancoById($ID);
                }
                else
                {
                  $login->validaToken($jwt);
                }
              }
              else
              {
                if($login->validaToken($jwt)=="ok")
                {
                  $banco->getBanco();
                }
                else
                {
                  $login->validaToken($jwt);
                }
              }
            }
          break;
        case 'formapago':

          $formaPago= new ControllerFormaPago();

          if($metodo == "POST")
          {
            $datos  = array(
              "FormaPago"=>$_POST["FormaPago"],
              "usuario"=>$_POST["usuario"]
            );

            $formaPago->postFormaPago($datos);
          }
          if($metodo == "GET")
          {
            if($ID != null || $ID != 0)
            {
              if($login->validaToken($jwt) == "ok")
              {
                $formaPago->getFormaPagoGetById($ID);
              }
              else
              {
                $login->validaToken($token);
              }

            }
            else
            {
              $formaPago->getFormaPago();
            }
          }
          break;
        case 'tipoventa':
            $tipoVenta = new ControllerTipoVenta();

            if($metodo == "POST")
            {
              $data = array(
                "TipoVenta" => $_POST["TipoVenta"],
                "usuario" => $_POST["usuario"]
              );

              $tipoVenta->postTipoVenta($data);
            }

            if($metodo == "GET")
            {
              if($ID != null || $ID != 0)
              {
                if($login->validaToken($jwt) == "ok")
                {
                  $tipoVenta->getTipoVentaById($ID);
                }
                else
                {
                  $login->validaToken($jwt);
                }
              }
              else
              {
                if($login->validaToken($jwt) == "ok")
                {
                  $tipoVenta->getTipoVenta();
                }
                else
                {
                  $login->validaToken($jwt);
                }
              }
            }
          break;
        case 'estadovisualizacion':
          break;
        case 'vendedor':
            $vendedor = new ControllerVendedor();
            if($metodo == "POST")
            {

            }
            if($metodo == "GET")
            {
              if($ID != null || $ID != 0)
              {
                if($tipoVenta->getTipoVenta() == "ok")
                {
                  $vendedor->getVendedorById($ID);
                }
                else
                {
                  $tipoVenta->getTipoVenta();
                }

              }
              else
              {
                if($login->validaToken($jwt) == "ok")
                {
                  $vendedor->getVendedor();
                }
                else
                {
                  $login->validaToken($jwt);
                }
              }
            }
          break;
        case 'producto':
            $productos = new ControllerProductos();

            if($metodo == "GET")
            {
              if($ID != null || $ID != 0)
              {
                $productos->getProductosById($ID);
              }
              else
              {
                $productos->getProductos();
              }
            }
          break;
        case 'articulo':
            $productos = new ControllerProductos();

            if($metodo == "GET")
            {
                if($ID != null || $ID !=0)
                {
                  $productos->getArticuloExactus($ID);
                }
                else
                {
                  $data = array("mensaje" => "Codigo de Articulo no especificado","StatusCode" => 404 );
                  echo json_encode($data);
                  return;
                }
            }
          break;
        case 'login':
            $login = new loginController();
            if ($metodo == "POST") {
              $request_body = file_get_contents('php://input');
              $data = json_decode($request_body,true);

              $data = array(
                "usuario" => $data["usuario"],
                "password" => $data["password"]
              );

              $login->iniciarSesion($data);
            }

            if ($metodo == "GET") {
              $data = array(
                "mensaje" => "No Data",
                "StatusCode" => 404
              );

              echo json_encode($data);
              return;
            }
          break;
        case 'usuario':
            $usuario=new ControllerUsuario();

            if($metodo == "GET")
            {
              if($login->validaToken($jwt) == "ok")
              {

                $user = $_GET["usuario"];
                $usuario->getUsuarioByUser($user);
              }
              else {
                $login->validaToken($jwt) == "ok";
              }
            }

            if($metodo == "PUT")
            {
              if($login->validaToken($jwt) == "ok")
              {
                $user = $_GET["usuario"];
                $request_body = file_get_contents('php://input');
                $datos = json_decode($request_body,true);
                $data = array(
                  "password" => $datos["contraseña"]
                );
                $usuario->putUserPass($user,$data);
              }
              else {
                $login->validaToken($jwt) == "ok";
              }
            }
          break;
        case 'estadistica':
            $estadistica = new ControllerEstadistica();

            if($metodo == "GET")
            {
              if($login->validaToken($jwt) == "ok")
              {
                $user = $_GET["usuario"];
                $estadistica->getEstadistica($user);
              }
              else
              {
                $login->validaToken($jwt);
              }
            }
          break;
        case 'email':
            $email = new ControllerEmail();
            if($metodo == "GET")
            {

            }
            if($metodo == "POST")
            {
              if($login->validaToken($jwt))
              {
                $request_body = file_get_contents('php://input');
                $data = json_decode($request_body,true);

                $datos = array(
                  "email" => $data["email"],
                  "password" => $data["password"],
                  "usuario" => $data["usuario"]
                );

                $email->postEmailConfig($datos);
              }
              else {
                $login->validaToken($jwt);
              }
            }
          break;
        case 'pdf':
            $pdf = new PDF();
            if($metodo == "GET")
            {
              //$pdf->getPDF();
            }
          break;
        case 'config':
            $config = new ControllerConfig();
            if($metodo == "GET")
            {
                if($ID != null || $ID !=0)
                {
                  if($login->validaToken($jwt) == "ok")
                  {

                  }
                  else
                  {
                    $login->validaToken($jwt);
                  }
                }
                else
                {
                  if($login->validaToken($jwt) == "ok")
                  {
                    $config->getConfig();
                  }
                  else {
                    $login->validaToken($jwt);
                  }
                }
            }
            if($metodo == "POST")
            {
              if($login->validaToken($jwt) == "ok")
              {
                $request_body = file_get_contents('php://input');
                $datos = json_decode($request_body,true);

                $data = array(
                  "email" => $datos["email"],
                  "password" => $datos["password"],
                  "usuario" => $datos["usuario"]
                );

                $config->postConfig($data);
              }
            }
            if($metodo == "DELETE")
            {
              if($login->validaToken($jwt))
              {
                $IdConfig=$_GET["IdConfig"];
                $usuario=$_GET["usuario"];
                $config->deleteConfig($IdConfig,$usuario);
              }
              else
              {
                $login->validaToken($jwt);
              }
            }
          break;
        case 'listaemail':
            $email = new ControllerEmail();

            if($metodo == "GET")
            {
              if($ID != null || $ID !=0)
              {
                if($login->validaToken($jwt) == "ok")
                {

                }
                else
                {
                  $login->validaToken($jwt);
                }
              }
              else
              {
                if($login->validaToken($jwt) == "ok")
                {
                  $email->getEmailLista();
                }
                else
                {
                  $login->validaToken($jwt);
                }
              }
            }

            if($metodo == "POST")
            {
              if($login->validaToken($jwt) == "ok")
              {

                $request_body = file_get_contents('php://input');
                $datos = json_decode($request_body,true);

                $data = array(
                  "email" => $datos["email"],
                  "usuario" => $datos["usuario"]
                );

                $email->postEmailLista($data);
              }
              else
              {
                $login->validaToken($jwt);
              }
            }

            if($metodo == "DELETE")
            {
              if($login->validaToken($jwt) == "ok")
              {
                $IdEmail = $_GET["IdEmail"];
                $email->deleteListEmailById($IdEmail);
              }
              else
              {
                $login->validaToken($jwt);
              }
            }

            if($metodo == "PUT")
            {
              if($login->validaToken($jwt) == "ok")
              {
                $IdEmail = $_GET["IdEmail"];
                $email->putEmailList($IdEmail);
              }
              else
              {
                $login->validaToken($jwt);
              }
            }
          break;
          case 'uservendedor':
              $usarioVendedor = new ControllerUsuarioVendedor();
              if($metodo == "GET") 
              {
                if($login->validaToken($jwt) == "ok")
                {
                  $user = $_GET["user"];
                  $usarioVendedor->getVendedorByUser($user);
                }
                else
                {
                  $login->validaToken($jwt);
                }
              }
            break;
        // sin llamada a un endpoint valido
        default:
            $json = array(
              "Detalle"=>"Ruta no existente",
              "StatusCode"=>"404"
            );
            echo json_encode($json,true);

            return;
          break;
      }
    }
  }
