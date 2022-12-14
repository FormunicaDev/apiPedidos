<?php

class ControllerTipoVenta{

  static public function getTipoVenta(){
    $tipoVenta = ModelTipoVenta::listarTipoVenta();

    if($tipoVenta == null)
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
        "data"=>$tipoVenta,
        "statusCode"=>200,
      );

      echo json_encode($data,true);

      return;
    }
  }

  static public function getTipoVentaById($ID){
    $tipoVenta = ModelTipoVenta::buscarTipoVenta($ID);

    if($tipoVenta==null)
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
        "data"=>$tipoVenta,
        "statusCode"=>200,
      );

      echo json_encode($data,true);

      return;
    }
  }

  static public function postTipoVenta($data){
    $tipoVenta=ModelTipoVenta::registrarTipoVenta($data);
    echo $tipoVenta;
    return;
  }

}
 ?>
