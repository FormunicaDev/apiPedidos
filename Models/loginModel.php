<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS, post, get');
header("Access-Control-Max-Age", "3600");
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Access-Control-Allow-Credentials", "true");

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
