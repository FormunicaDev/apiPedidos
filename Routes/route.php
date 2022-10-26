<?php
$arrayRutas=explode("/",$_SERVER["REQUEST_URI"]);

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

            }
            if($metodo == 'GET')
            {
              //valida si se envia un parametro despues del endpoint y si este es un ID nu
              if($ID != null || $ID != 0)
              {
                $clientes->getById($ID);
              }
              else
              {
                  $clientes->getClientes();
              }

            }
          break;
        //endpoint productos
        case 'productos':

          break;
        //endpoint vendedores
        case 'vendedores':

          break;
        //endpoint pedidos
        case 'pedidos':

            $pedidos = new ControllerPedidos();

            if($metodo == "POST")
            {

              $datos = array(
                "Codigo" => $_POST["codigo"],
                "codVendedor" => $_POST["codVendedor"],
                "codCliente" => $_POST["codCliente"],
                "TipoVenta" => $_POST["tipoVenta"],
                "Comentarios" => $_POST["comentarios"],
                "Total" => $_POST["total"],
                "TotalDescuento" => $_POST["totalDesc"],
                "TotalNeto" => $_POST["totalNeto"],
                "numCheque" => $_POST["cheque"],
                "fechaCheque" => $_POST["fechaCheque"],
                "Banco"=> $_POST['Banco'],
                "FormaPago"=>$_POST['FormaPago']
              );

              $pedidos->PostPedido($datos);

            }
            if($metodo == "GET")
            {
              if($ID != null || $ID != 0)
              {

              }
              else
              {

              }
            }
          break;
        case 'banco':
            $banco = new ControllerBanco();

            if($metodo == "POST")
            {
              $datos = array(
                "Banco"=>$_POST["Banco"],
                "UsuarioRegistro"=>$_POST["usuario"]
              );

              $banco->postBanco($datos);

            }

            if($metodo == "GET")
            {
              if($ID != null || $ID != 0)
              {
                $banco->getBancoById($ID);
              }
              else
              {
                $banco->getBanco();
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
              $formaPago->getFormaPagoGetById($ID);
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
                $tipoVenta->getTipoVentaById($ID);
              }
              else
              {
                $tipoVenta->getTipoVenta();
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
                $vendedor->getVendedorById($ID);
              }
              else
              {
                $vendedor->getVendedor();
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
