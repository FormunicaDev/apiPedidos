<?php
require_once 'conexion.php';

class ModelTipoVenta {

  static public function listarTipoVenta(){
    $stmt=BD::conexion()->prepare("SELECT * FROM TipoVenta where status = 1");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);
    $stmt->close();
    $stmt=null;
  }

  static public function buscarTipoVenta($ID){
    $stmt=BD::conexion()->prepare("SELECT * FROM TipoVenta where IdTipoVenta=$ID and status = 1");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);
    $stmt->close();
    $stmt=null;
  }

  static public function registrarTipoVenta($data){
    $stmt=BD::conexion()->prepare("INSERT INTO TipoVenta (TipoVenta,UsuarioRegistro) values (:TipoVenta, :UsuarioRegistro)");

    $stmt -> bindParam(":TipoVenta",$data["TipoVenta"],PDO::PARAM_STR);
    $stmt -> bindParam(":UsuarioRegistro",$data["usuario"],PDO::PARAM_STR);

    if($stmt->execute())
    {
        $data = array(
          "mensaje" => "Registro crado con exito",
          "statusCode" => 200
        );

        return json_encode($data);
    }
    else
    {
      $data = array(
        "mensaje" => "Error al completar el registro",
        "statusCode" => 400,
        "error"=>BD::conexion()->errorInfo()
      );

      return json_encode($data);
    }
  }

}


 ?>
