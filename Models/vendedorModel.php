<?php
require_once 'conexion.php';

class ModelVendedores {

  static public function listarVendedores(){
    $stmt=BD::conexion()->prepare("SELECT * FROM vendedores where ACTIVO = 1");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);
    $stmt->close();
    $stmt=null;
  }

  static public function buscarVendedor($ID){
    $stmt=BD::conexion()->prepare("SELECT * FROM vendedores where cod_vend = '$ID' and  ACTIVO = 1");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);
    $stmt->close();
    $stmt=null;
  }


}


 ?>
