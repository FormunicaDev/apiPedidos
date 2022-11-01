<?php
require_once 'conexion.php';


class ModelUsuario {

  static public function obtenerInfoUser($usuario){
      $stmt = BD::conexion()->prepare("SELECT USUARIO,DESCR,
                                          case
                                          	when ACTIVO=1 then 'Activo'
                                          else
                                          	'Inactivo'
                                          end as Estado
                                          from USUARIO
                                          where USUARIO = '$usuario'");
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_CLASS);
      $stmt->close();
      $stmt=null;
  }

  static public function updatePass($usuario,$data) {
    $stmt = BD::conexion()->prepare("UPDATE USUARIO set PASSWORD=:password where USUARIO = '$usuario'");

    $stmt -> bindParam(":password",$data["password"],PDO::PARAM_STR);

    if($stmt->execute())
    {
      $json = array(
        "mensaje"=> "Contraseña actualizada con exito",
        "StatusCode"=>"200"
      );

      return json_encode($json);
    }
    else
    {
      $json = array(
        "mensaje"=>"Error al actualizar el registro",
        "statusCode"=>"400",
        "error"=>BD::conexion()->errorInfo()
      );

      return json_encode($json);
    }
  }

}


 ?>
