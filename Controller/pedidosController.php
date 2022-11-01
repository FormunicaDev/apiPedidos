<?php
require_once './Common/paginacion.php';

class ControllerPedidos {

  public function PostPedido($data,$detalle){


    //validar que el campo codigo sea numerico
    if(!preg_match("/^[[:digit:]]+$/",$data["codigo"]))
    {

      $json = array(
        "mensaje"=>"El campo codigo solo acepta numeros",
        "statusCode"=>"400"
      );

      echo json_encode($json);
      return;
    }
    //validar que el campo total sea numerico
    else if(!preg_match("/^[[:digit:]]+$/",$data["Banco"]))
    {

      $json = array(
        "mensaje"=>"El campo total solo acepta numeros",
        "statusCode"=>"400"
      );

      echo json_encode($json);
      return;
    }
    //validar que el campo descuento sea numerico
    else if(!preg_match("/^[[:digit:]]+$/",$data["TipoVenta"]))
    {

      $json = array(
        "mensaje"=>"El campo descuento solo acepta numeros",
        "statusCode"=>"400"
      );

      echo json_encode($json);
      return;
    }
    else if(!preg_match("/^[[:digit:]]+$/",$data["numCheque"]))
    {

      $json = array(
        "mensaje"=>"El campo descuento solo acepta numeros",
        "statusCode"=>"400"
      );

      echo json_encode($json);
      return;
    }
    //si se cumplen las validaciones anteriores, se envia la data al modelo
    else {
      $pedidos=ModelPedidos::crearPedidos($data,$detalle);
      echo $pedidos;
      return;
    }

  }

  public function getPedidos($cantidad,$pagina){


    $count = ModelPedidos::countRegPedidos();
    $pagination = pagination::paginacion("pedidos",$cantidad,$pagina,$count[0]["totalRegistros"]);
    $pedidos = ModelPedidos::listarPedidos($pagination);
    if($pedidos==null)
    {
      $data = array(
        "mensaje"=>"No existen registros en la base de datos",
        "statusCode"=>404
      );

      echo json_encode($data);
      return;
    }
    else
    {
      $data = array(
        "data"=>$pedidos,
        "statusCode"=>200,
        "paginacion" => $pagination
      );

      echo json_encode($data,true);

      return;
    }
  }

}
 ?>
