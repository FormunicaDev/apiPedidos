<?php

class ControllerBanco{

  static public function postBanco($data) {
    $banco = ModelBanco::registrarBanco($data);
    echo $banco;
    return;
  }

  static public function getBanco(){
    $banco=ModelBanco::listarBancos();
    $json = array(
      "data"=>$banco,
      "statusCode"=>200,
    );
    echo json_encode($json,true);

    return;
  }

  static public function getBancoById($ID){
    $banco=ModelBanco::buscarBanco($ID);
    if($banco == null) {
      $json =array(
          "mensaje"=>"Registro no encontrado",
          "StatusCode"=>404
      );

      echo json_encode($json);
      return;
    }else {
      $json = array(
        "data"=>$banco,
        "statusCode"=>200,
      );
      echo json_encode($json,true);

      return;
    }

  }

}


 ?>
