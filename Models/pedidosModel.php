<?php

require_once 'conexion.php';

class ModelPedidos {
  static public function crearPedidos($data,$detalle){
    $stmt=BD::conexion()->prepare("INSERT INTO pedidos (Codigo,codVendedor,codCliente,TipoVenta,Estado,Banco,
      FormaPago,Comentarios,numeroCheque,fechaCheque,Total,TotalDescuento,TotalNeto,FechaRegistro)
      values(:Codigo, :codVendedor, :codCliente, :TipoVenta, :Estado, :Banco, :FormaPago, :Comentarios, :numeroCheque, :fechaCheque,
      :Total, :TotalDescuento, :TotalNeto, :fechaRegistro)");

      $estado = 1;
      $fecha = date('Y-m-d H:i:s');

      $stmt -> bindParam(":Codigo",$data["codigo"],PDO::PARAM_STR);
      $stmt -> bindParam(":codVendedor",$data["codVendedor"],PDO::PARAM_STR);
      $stmt -> bindParam(":codCliente",$data["codCliente"],PDO::PARAM_STR);
      $stmt -> bindParam(":TipoVenta",$data["TipoVenta"],PDO::PARAM_STR);
      $stmt -> bindParam(":Estado",$estado,PDO::PARAM_STR);
      $stmt -> bindParam(":Banco",$data["Banco"],PDO::PARAM_STR);
      $stmt -> bindParam(":FormaPago",$data["FormaPago"],PDO::PARAM_STR);
      $stmt -> bindParam(":Comentarios",$data["Comentarios"],PDO::PARAM_STR);
      $stmt -> bindParam(":numeroCheque",$data["numeroCheque"],PDO::PARAM_STR);
      $stmt -> bindParam(":fechaCheque",$data["fechaCheque"],PDO::PARAM_STR);
      $stmt -> bindParam(":Total",$data["Total"],PDO::PARAM_STR);
      $stmt -> bindParam(":TotalDescuento",$data["TotalDescuento"],PDO::PARAM_STR);
      $stmt -> bindParam(":TotalNeto",$data["TotalNeto"],PDO::PARAM_STR);
      $stmt -> bindParam(":fechaRegistro",$fecha,PDO::PARAM_STR);

      if($stmt->execute())
      {
        $clase = new ModelPedidos();
        $lastID=$clase->lastIdPedido($data["codCliente"],$data["Banco"],$data["TipoVenta"],$fecha);

        var_dump($lastID[0]) ;
        //$clase->detallePedido($lastID["IdPedido"],$detalle);

          $json = array(
            "mensaje"=> "Registro completado con exito",
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

  private function detallePedido($IdPedido,$detalle){

    try {
      $stmt=BD::conexion()->prepare("INSERT INTO detallePedido (IdPedido,CodProducto,Cantidad,Precio,Descuento)
      values(:IdPedido, :codArticulo, :cantidad, :precioArticulo, :totalDesc)");

      foreach ($detalle as $key => $value) {
        $stmt -> bindParam(":IdPedido",$IdPedido,PDO::PARAM_STR);
        $stmt -> bindParam(":codArticulo",$value['codArticulo'],PDO::PARAM_STR);
        $stmt -> bindParam(":cantidad",$value['cantidad'],PDO::PARAM_STR);
        $stmt -> bindParam(":precioArticulo",$value['precioArticulo'],PDO::PARAM_STR);
        $stmt -> bindParam(":totalDesc",$value['totalDesc'],PDO::PARAM_STR);

        $stmt -> execute();
      }

      return true;

    } catch (\Exception $e) {
      return $e;
    }
  }

  private function lastIdPedido($cliente,$banco,$tipoVenta,$fecha){
    $stmt = BD::conexion()->prepare("SELECT IdPedido from pedidos
      where Estado = 1 and codCliente='$cliente' and Banco = $banco and TipoVenta = $tipoVenta and FechaRegistro = '$fecha'");
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_CLASS);
      $stmt->close();
      $stmt=null;
  }

  static public function listarPedidos(){
    $stmt = BD::conexion()->prepare("SELECT IdPedido,Codigo, FechaEmision,
                                        codVendedor,codCliente, b.TipoVenta,c.Estado,d.Banco,Comentarios,numeroCheque,
                                        fechaCheque,a.Total,a.TotalDescuento,a.TotalNeto,a.FechaRegistro
                                        FROM pedidos a
                                        join TipoVenta b
                                        on a.TipoVenta = b.IdTipoVenta
                                        join EstadoVisualizacion c
                                        on a.Estado=c.IdEstadoVisualizacion
                                        join bancos d
                                        on a.Banco=d.IdBanco ");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);

    $stmt->close();

    $stmt=null;
  }

  static public function countRegPedidos(){
    $stmt = BD::conexion()->prepare("SELECT count(*) FROM pedidos");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_CLASS);

    $stmt->close();

    $stmt=null;
  }
}

 ?>
