<?php

class ControllerPedidos {

  public function PostPedido($data){



    if(!preg_match("/^[[:digit:]]+$/",$data["codigo"]))
    {

      $json = array(
        "error"=>"El campo codigo solo acepta numeros",
        "statusCode"=>"400"
      );

      echo json_encode($json);
      return;
    }

    else if(!preg_match("/^[[:digit:]]+$/",$data["total"]))
    {
      
      $json = array(
        "error"=>"El campo total solo acepta numeros",
        "statusCode"=>"400"
      );

      echo json_encode($json);
      return;
    }

    else if(!preg_match("/^[[:digit:]]+$/",$data["totalDescuento"]))
    {

      $json = array(
        "error"=>"El campo descuento solo acepta numeros",
        "statusCode"=>"400"
      );

      echo json_encode($json);
      return;
    }

    else {
      $pedidos=ModelPedidos::postPedidos($data);
    }

  }

}
 ?>
