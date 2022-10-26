<?php

class ControllerFormaPago {

  static public function getFormaPago(){
    $formapago = ModelFormaPago::listarFormaPago();

    if($formapago==null)
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
        "data"=>$formapago,
        "statusCode"=>200,
      );

      echo json_encode($data,true);

      return;
    }
  }

  static public function postFormaPago($data){
    $formapago=ModelFormaPago::registrarFormaPago($data);
    echo $formapago;
    return;
  }

  static public function getFormaPagoGetById($ID){
    $formapago= ModelFormaPago::buscarFormaPago($ID);

    if($formapago==null)
    {
      $data = array(
        "mensaje"=>"No se encontro el registro solicitado",
        "statusCode"=>404
      );

      echo json_encode($data);
      return;
    }
    else
    {
      $data = array(
        "data"=>$formapago,
        "statusCode"=>200,
      );

      echo json_encode($data,true);

      return;
    }

  }

}

 ?>
