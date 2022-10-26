<?php

class ControllerVendedor{
  static public function getVendedor(){
    $vendedor = ModelVendedores::listarVendedores();

    if($vendedor==null)
    {
      $data = array(
        "data" => "No existen registros en la base de datos" ,
        "StatusCode" => 404
      );

      echo json_encode($data);
      return;
    }
    else {
      $data = array(
        "data" => $vendedor ,
        "StatusCode" => 200
      );

      echo json_encode($data);
      return;
    }
  }

  static public function getVendedorById($ID){
    $vendedor = ModelVendedores::buscarVendedor($ID);
    if($vendedor==null)
    {
      $data = array(
        "mensaje"=>"No se encontro el registro solicitado",
        "statusCode"=>404
      );

      echo json_encode($data);
      return;
    }
    else {
      $data = array(
        "data"=>$vendedor,
        "statusCode"=>200,
      );

      echo json_encode($data,true);

      return;
    }
  }
}

 ?>
