<?php
require_once 'conexion.php';

class ModelEmail {
  static public function registerConfigEmail($data) {
    $stmt= BD::conexion()->prepare("INSERT INTO configuracionEmail (email,UsuarioRegistro,password) values(:email, :usuario, :password)");
    //$password = base64_encode($data["password"]);

    $stmt -> bindParam(":email",$data["email"],PDO::PARAM_STR);
    $stmt -> bindParam(":usuario",$data["usuario"],PDO::PARAM_STR);
    $stmt -> bindParam(":password",$data["password"],PDO::PARAM_STR);

    if($stmt -> execute())
    {
      $data = array(
        "mensaje" => "Registro completado con exito",
        "statusCode" => 200
      );

      return json_encode($data);
    }
    else
    {
      $data = array(
        "mensaje" => "Erro al completar el registro",
        "statusCode" => 400
      );

      return json_encode($data);
    }

    $stmt->close();
    $stmt = null;

  }

  static public function getConfigEmail(){
    $stmt = BD::conexion()->prepare("SELECT top 1 * FROM configuracionEmail where status = 1");
    $stmt -> execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->close();
    $stmt=null;
  }

  static public function getListEmail(){
    $stmt = BD::conexion()->prepare("SELECT IdEmail,Email,FechaRegistro,case when status = 1 then 'Activo' else 'Inactivo' end as status FROM listaEmail");
    $stmt -> execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);
    $stmt ->close();
    $stmt = null;
  }

  static public function postListEmail($data){
    $stmt = BD::conexion()->prepare("INSERT INTO listaEmail (Email,UsuarioRegistro) values (:email, :UsuarioRegistro)");

    $stmt -> bindParam(":email",$data["email"],PDO::PARAM_STR);
    $stmt -> bindParam(":UsuarioRegistro",$data["usuario"],PDO::PARAM_STR);

    if($stmt->execute())
    {
      $data = array(
        "mensaje" => "Registro completado con exito",
        "statusCode" => 200
      );

      return json_encode($data);

    }
    else
    {
      $data = array("mensaje" => "Error al completar el registro", "statusCode" => 401 );
      return json_encode($data);
    }

    $stmt->close();
    $stmt = null;

  }

  static public function deleteEmail($IdEmail){
    $stmt = BD::conexion()->prepare("UPDATE listaEmail set status = 0 where IdEmail = $IdEmail");

    if($stmt -> execute())
    {
      $data = array("mensaje" =>  "Correo eliminado con exito", "statusCode" => 200);
      return json_encode($data);
    }
    else
    {
      $data = array("mensaje" => "Error al eliminar correo", "statusCode" => 401);
      return json_encode($data);
    }

    $stmt->close();
    $stmt = null;
  }

  static public function reactiveEmail($IdEmail) {
    $stmt = BD::conexion()->prepare("UPDATE listaEmail set status = 1 where IdEmail = $IdEmail");

    if($stmt -> execute())
    {
      $data = array("mensaje" =>  "Correo activado con exito", "statusCode" => 200);
      return json_encode($data);
    }
    else
    {
      $data = array("mensaje" => "Error al reactivar correo", "statusCode" => 401);
      return json_encode($data);
    }

    $stmt->close();
    $stmt = null;
  }

  static public function obtenerEmailActivos() {
    $stmt = BD::conexion()->prepare("SELECT Email FROM listaEmail where status = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt ->close();
    $stmt = null;
  }
}




 ?>
