<?php

class ControllerEstadistica {
  public function getEstadistica($user) {
    $estadistica = ModelEstadistica::cantidadPedidos($user);

    if($estadistica == null)
    {
      $data = array("mensaje" => "No se pudo obtener la data", "statusCode" => 401 );
      echo json_encode($data,true);
      return;
    }
    else
    {
      $data = array(
        "totalPedidos" => $estadistica[0]["cantidad"],
        "statusCode" => 200
      );

      echo json_encode($data,true);
      return;
    }
  }
}


 ?>
