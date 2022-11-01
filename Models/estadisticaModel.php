<?php
require_once 'conexion.php';

class ModelEstadistica {
  static public function cantidadPedidos($user){
    $stmt = BD::conexion()->prepare("SELECT count(*) as cantidad FROM pedidos where UsuarioRegistro = '$user' ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->close();
    $stmt = null;
  }
}

 ?>
