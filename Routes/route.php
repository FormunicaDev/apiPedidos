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
            $json = array(
              "Detalle"=>"Vista Vendedores",
              "StatusCode"=>"200"
            );
            echo json_encode($json,true);

            return;
          break;
        //endpoint pedidos
        case 'pedidos':

            $pedidos = new ControllerPedidos();

            if($metodo == "POST")
            {

              $datos = array(
                "codigo" => $_POST["codigo"],
                "codVendedor" => $_POST["codVendedor"],
                "codCliente" => $_POST["codCliente"],
                "TipoVenta" => $_POST["tipoVenta"],
                "Comentarios" => $_POST["comentarios"],
                "total" => $_POST["total"],
                "totalDescuento" => $_POST["totalDesc"],
                "TotalNeto" => $_POST["totalNeto"],
                "numCheque" => $_POST["cheque"],
                "fechaCheque" => date($_POST["fechaCheque"])
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
                echo "entro";
              }
            }
          break;
        case 'banco':
          break;
        case 'formapago':
          break;
        case 'tipoventa':
          break;
        case 'estadovisualizacion':
          break;
        // sin llamada a un endpoint valido
        default:

          break;
      }
    }
  }
