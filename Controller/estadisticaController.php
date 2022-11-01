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
        "total" => $estadistica[0]["cantidad"],
        "title" => "Pedidos Ingresados"
      );

      echo json_encode($data,true);
      return;
    }
  }
}


 ?>
