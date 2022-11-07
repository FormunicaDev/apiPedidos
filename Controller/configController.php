<?php

class ControllerConfig {
  public function getConfig() {
    $config = ModelConfig::obtenerConfig();

    if($config == null)
    {
      $data = array(
        "mensaje" => "No existe ninguna configuración en la base de datos",
        "StatusCode" => 401
      );

      echo json_encode($data,true);
      return;
    }
    else
    {
      $data = array(
        "data" => $config,
        "StatusCode" => 200
      );

      echo json_encode($data,true);
      return;
    }
  }

  public function postConfig($data) {
    $config = ModelConfig::crearConfig($data);
    echo $config;
    return;
  }

  public function deleteConfig($IdConfig,$usuario) {
    $config = ModelConfig::anularConfig($IdConfig,$usuario);
    echo $config;
    return;
  }
}

 ?>
