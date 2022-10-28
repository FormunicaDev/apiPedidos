<?php

class ControllerProductos {
  public function getProductos() {
    $productos = ModelProductos::listarProductos();
    $count = ModelProductos::totalProductos();

    if($productos == null)
    {
      $data = array("mensaje" => "No existen registros en la base de datos", "statusCode"=>404 );

      echo json_encode($data);
      return;
    }
    else{
      $data = array(
        "data" => $productos,
        "statusCode" => 200,
        "totalRegistros" => $count[0]
      );

      echo json_encode($data,true);
      return;
    }
  }

  public function getProductosById($ID) {
    $productos = ModelProductos::buscarProducto($ID);


    if($productos == null)
    {
      $data = array("mensaje" => "No existen registros en la base de datos", "statusCode"=>404 );

      echo json_encode($data);
      return;
    }
    else{
      $data = array(
        "data" => $productos,
        "statusCode" => 200
      );

      echo json_encode($data,true);
      return;
    }
  }

  public function getArticuloExactus($codArticulo){
    $productos = ModelProductos::buscarArticulo($codArticulo);

    if($productos == null)
    {
      $data = array("mensaje" => "No existen registros en la base de datos", "statusCode"=>404 );

      echo json_encode($data);
      return;
    }
    else{
      $data = array(
        "data" => $productos,
        "statusCode" => 200
      );

      echo json_encode($data,true);
      return;
    }

  }
}

 ?>
