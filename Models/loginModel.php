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

    $stmt=BD::conexion()->prepare("SELECT a.USUARIO,a.DESCR,a.ACTIVO,a.PASSWORD,b.IDROLE
                                    FROM USUARIO a
                                    join USUARIO_ROLE b
                                    on a.USUARIO=b.USUARIO where a.USUARIO = '$usuario' and a.PASSWORD='$password' and a.ACTIVO = 1 and b.IDMODULO=100");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->close();
    $stmt=null;


  }

}

 ?>
