<?php
require_once 'conexion.php';

class ModelFormaPago{

  static public function listarFormaPago() {
    $stmt= BD::conexion()->prepare("SELECT * FROM formaPago");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);

    $stmt->close();

    $stmt=null;
  }

  static public function registrarFormaPago($data){
    $stmt=BD::conexion()->prepare("INSERT INTO formaPago (FormaPago,UsuarioRegistro) values(:FormaPago, :UsuarioRegistro)");
    $stmt -> bindParam(":FormaPago",$data["FormaPago"],PDO::PARAM_STR);
    $stmt -> bindParam(":UsuarioRegistro",$data["usuario"],PDO::PARAM_STR);

    if($stmt->execute())
    {
      $data = array(
        "mensaje"=>"Registro creado con exito",
        "StatusCode"=>200
      );

      return json_encode($data);
    }
    else {
      $data = array(
          "mensaje"=>"Error al completar el registro",
          "statusCode"=>"400",
          "error"=>BD::conexion()->errorInfo()
        );

        return json_encode($data);
    }
  }

  static public function buscarFormaPago($ID){
    $stmt = BD::conexion()->prepare("SELECT * FROM formapago where IdFormaPago = $ID and status = 1");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);
    $stmt->close();
    $stmt=null;
  }

}

 ?>
