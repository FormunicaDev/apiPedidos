<?php
require_once "conexion.php";

class ModelCliente {
  static public function getCliente(){
    
    $stmt = BD::conexion()->prepare("SELECT * FROM clientes");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);

    $stmt->close();

    $stmt=null;

  }

  static public function getClienteById($codCliente) {

    $stmt = BD::conexion()->prepare("SELECT * FROM clientes where cod_cte = '$codCliente'");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);

    $stmt->close();

    $stmt=null;
  }
}


 ?>
