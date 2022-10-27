<?php

require_once 'conexion.php';

class ModelPedidos {
  static public function postPedidos($data){
    $stmt=BD::conexion()->prepare("INSERT INTO pedidos (Codigo,codVendedor,codCliente,TipoVenta,Estado,Banco,
      FormaPago,Comentarios,numeroCheque,fechaCheque,Total,TotalDescuento,TotalNeto)
      values(:Codigo, :codVendedor, :codCliente, :TipoVenta, :Estado, :Banco, :FormaPago, :Comentarios, :numeroCheque, :fechaCheque,
      :Total, :TotalDescuento, :TotalNeto)");

      $stmt -> bindParam(":Codigo",$data["Codigo"],PDO::PARAM_STR);
      $stmt -> bindParam(":codVendedor",$data["codVendedor"],PDO::PARAM_STR);
      $stmt -> bindParam(":codCliente",$data["codCliente"],PDO::PARAM_STR);
      $stmt -> bindParam(":TipoVenta",$data["TipoVenta"],PDO::PARAM_STR);
      $stmt -> bindParam(":Estado",$data["Estado"],PDO::PARAM_STR);
      $stmt -> bindParam(":Banco",$data["Banco"],PDO::PARAM_STR);
      $stmt -> bindParam(":FormaPago",$data["FormaPago"],PDO::PARAM_STR);
      $stmt -> bindParam(":Comentarios",$data["Comentarios"],PDO::PARAM_STR);
      $stmt -> bindParam(":numeroCheque",$data["numeroCheque"],PDO::PARAM_STR);
      $stmt -> bindParam(":fechaCheque",$data["fechaCheque"],PDO::PARAM_STR);
      $stmt -> bindParam(":Total",$data["Total"],PDO::PARAM_STR);
      $stmt -> bindParam(":TotalDescuento",$data["TotalDescuento"],PDO::PARAM_STR);
      $stmt -> bindParam(":TotalNeto",$data["TotalNeto"],PDO::PARAM_STR);

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

  static public function listarPedidos(){
    $stmt = BD::conexion()->prepare("SELECT * FROM pedidos ");
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
