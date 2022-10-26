<?php

class ControllerCliente{
  public function getClientes(){

    $cliente=ModelCliente::getCliente();
    $json = array(
      "data"=>$cliente,
      "statusCode"=>"200",
    );
    echo json_encode($json,true);

    return;
  }

  public function getById($Id) {
    $cliente=ModelCliente::getClienteById($Id);

    $json = array(
      "data"=>$cliente,
      "StatusCode"=>"200"
    );
    echo json_encode($json,true);

    return;
  }
}

 ?>
