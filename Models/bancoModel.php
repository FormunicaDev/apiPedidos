<?php
require_once "conexion.php";

class ModelBanco {
  static public function registrarBanco($data){
    $stmt=BD::conexion()->prepare("INSERT INTO bancos (Banco,UsuarioRegistro) values(:Banco, :UsuarioRegistro)");

    $stmt -> bindParam(":Banco",$data["Banco"],PDO::PARAM_STR);
    $stmt -> bindParam(":UsuarioRegistro",$data["UsuarioRegistro"],PDO::PARAM_STR);

    if($stmt->execute())
    {
      $json = array(
        "mensaje"=>"Registro creado con exito",
        "StatusCode"=>"200"
      );

      return json_encode($json);

    } else {
      $json = array(
        "mensaje"=>"Error al completar el registro",
        "statusCode"=>"400",
        "error"=>BD::conexion()->errorInfo()
      );

      return json_encode($json);
    }

    $stmt->close();
    $stmt = null;

  }

  static public function listarBancos(){
    $stmt = BD::conexion()->prepare("SELECT * FROM bancos where status = 1");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);

    $stmt->close();

    $stmt=null;
  }

  static public function buscarBanco($ID){
    $stmt = BD::conexion()->prepare("SELECT * FROM bancos where IdBanco = $ID and status = 1");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);

    $stmt->close();

    $stmt=null;
  }

}


 ?>
