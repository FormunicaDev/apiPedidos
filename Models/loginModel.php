<?php
require_once 'conexion.php';

class Modellogin {

  static public function login($data) {
    $usuario = $data["usuario"];
    $password = $data["password"];

    $stmt=BD::conexion()->prepare("SELECT * FROM USUARIO where USUARIO = '$usuario' and PASSWORD='$password' and ACTIVO = 1");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);
    $stmt->close();
    $stmt=null;


  }

}

 ?>
