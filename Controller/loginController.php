<?php
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;

class loginController {

  static public function iniciarSesion($data) {
    $login=Modellogin::login($data);

    if($login==null)
    {
      $data = array(
      "mensaje" => "Usuario o Contraseña Incorrecta, favor validar datos",
      "StatusCode" => 404
      );

      echo json_encode($data);
      return;
    }
    else
    {
      $secretKey = "00e3d043e7725fa6006e634f79c770c79d30b7f2a4b86afe5188cfe7bf6250b8"; //"formunica_2022*";
      $date = new DateTimeImmutable();
      $expire_at = $date->modify('+60 minutes')->getTimestamp();
      $dominio = "formunica.com";
      $usuario = $data["usuario"];

      $request_data = [
        'iat' => $date->getTimestamp(),
        'iss' => $dominio,
        'nbf' => $date->getTimestamp(),
        'exp' => $expire_at,
        'username' => $usuario
      ];

      echo JWT::encode($request_data,$secretKey,"HS512");
    }
  }

  static public function validaToken($token) {
    $secretKey = "00e3d043e7725fa6006e634f79c770c79d30b7f2a4b86afe5188cfe7bf6250b8";
    $jwt = JWT::decode($token,$secretKey,['HS512']);
    $now = new DateTimeImmutable();
    $dominio = "formunica.com";

    if($jwt->iss !== $dominio || $jwt->nbf > $now->getTimestamp() || $jwt->exp < $now->getTimestamp())
    {
      $data = array(
        "mensaje" => "No esta autorizado",
        "StatusCode" => 401
      );

      echo json_encode($data);
      return;
    }
    else {
      return 1;
    }
  }
}

 ?>
