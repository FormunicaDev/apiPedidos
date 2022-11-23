<?php
require_once "conexion.php";

class ModelCliente {
  static public function getCliente(){
    
    $stmt = BD::conexionExactus()->prepare("SELECT * FROM ch.cliente");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);

    $stmt->close();

    $stmt=null;

  }

  static public function getClienteById($codCliente) {

    $stmt = BD::conexionExactus()->prepare("SELECT * FROM ch.cliente where CLIENTE = '$codCliente'");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);

    $stmt->close();

    $stmt=null;
  }
}


 ?>
