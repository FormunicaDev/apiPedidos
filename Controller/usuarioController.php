<?php

class ControllerUsuario {
  public function getUsuarioByUser($user){
    $usuario = ModelUsuario::obtenerInfoUser($user);
    if($usuario == null)
    {
      $data = array("mensaje" => "No se pudo recuperar la información del usuario", "statusCode" => 400 );

      echo json_encode($data,true);
      return;
    }
    else
    {
      $data = array(
        "data" => $usuario,
        "statusCode" => 200
      );

      echo json_encode($data,true);
      return;
    }
  }

  public function putUserPass($user,$data){
    $usuario = ModelUsuario::updatePass($user,$data);

    echo $usuario;
    return;
  }
}

 ?>
