<?php

class ControllerPedidos {

  public function PostPedido($data){


    //validar que el campo codigo sea numerico
    if(!preg_match("/^[[:digit:]]+$/",$data["Codigo"]))
    {

      $json = array(
        "error"=>"El campo codigo solo acepta numeros",
        "statusCode"=>"400"
      );

      echo json_encode($json);
      return;
    }
    //validar que el campo total sea numerico
    else if(!preg_match("/^[[:digit:]]+$/",$data["Total"]))
    {

      $json = array(
        "error"=>"El campo total solo acepta numeros",
        "statusCode"=>"400"
      );

      echo json_encode($json);
      return;
    }
    //validar que el campo descuento sea numerico
    else if(!preg_match("/^[[:digit:]]+$/",$data["TotalDescuento"]))
    {

      $json = array(
        "error"=>"El campo descuento solo acepta numeros",
        "statusCode"=>"400"
      );

      echo json_encode($json);
      return;
    }
    //si se cumplen las validaciones anteriores, se envia la data al modelo
    else {
      $pedidos=ModelPedidos::postPedidos($data);
      echo $pedidos;
      return;
    }

  }

  public function getPedidos(){
    $pedidos = ModelPedidos::listarPedidos();
    $count = ModelPedidos::countRegPedidos();
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
        "totalRegistros" => $count
      );

      echo json_encode($data,true);

      return;
    }
  }

}
 ?>
