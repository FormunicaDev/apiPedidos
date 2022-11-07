<?php
require_once 'conexion.php';

class ModelConfig {

  static public function obtenerConfig() {
    $stmt= BD::conexion()->prepare("SELECT IdConfig, email,password,FechaRegistro,
                                      case
                                      	when status = 1 then 'Activo'
                                      	else 'Inactivo'
                                      end as status
                                      from
                                      configuracionEmail");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_CLASS);
    $stmt->close();
    $stmt = null;
  }

  static public function crearConfig($data) {
    $config = new ModelConfig();
    $ID=$config->validaConfiguracionActiva();
    if($ID[0]["email"] == "" || $ID[0]["email"] == null || $ID==null)
    {
      $stmt=BD::conexion()->prepare("INSERT INTO configuracionEmail (email,password,UsuarioRegistro) values (:email, :password, :UsuarioRegistro)");

      $stmt -> bindParam(":email",$data["email"],PDO::PARAM_STR);
      $stmt -> bindParam(":password",$data["password"],PDO::PARAM_STR);
      $stmt -> bindParam(":UsuarioRegistro",$data["usuario"],PDO::PARAM_STR);

      if($stmt->execute())
      {
        $data = array("mensaje" => "Registro crado con exito", "statusCode" => 200 );
        echo json_encode($data);
        return;

        $stmt->close();
        $stmt = null;
      }
      else {
        $data = array("mensaje" => "Error al completar el registro", "statusCode" => 401 );
        echo json_encode($data);
        return;
      }
    }
    else
    {
      $data = array("mensaje" => "Ya existe una configuracion activa","statusCode" => 401 );
      echo json_encode($data);
      return;
    }
  }

  private function validaConfiguracionActiva() {
    $stmt=BD::conexion()->prepare("SELECT * from configuracionEmail where status = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->close();
    $stmt = null;
  }

  static public function anularConfig($IdConfig,$usuario) {
    $stmt = BD::conexion()->prepare("UPDATE configuracionEmail set password = null, status = 0,UsuarioAnulo='$usuario' where IdConfig=$IdConfig");

    if($stmt -> execute())
    {
      $data = array("mensaje" => "Configuracion anulada con exito", "statusCode" => 200 );

      return json_encode($data,true);
      $stmt->close();
      $stmt = null;
    }

  }

}

 ?>
