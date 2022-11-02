<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS, post, get');
header("Access-Control-Max-Age", "3600");
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Access-Control-Allow-Credentials", "true");
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-xsrf-token, x_csrftoken, Cache-Control, X-Requested-With');

require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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
      $expire_at = $date->modify('+480 minutes')->getTimestamp();
      $dominio = "formunica.com";
      $usuario = $data["usuario"];
      $role = $login[0]["IDROLE"];

      $request_data = [
        'iat' => $date->getTimestamp(),
        'iss' => $dominio,
        'nbf' => $date->getTimestamp(),
        'exp' => $expire_at,
        'username' => $usuario
      ];

      $data = array(
        "token" => JWT::encode($request_data,$secretKey,"HS512"),
        "user" => $data["usuario"],
        "StatusCode" => 200,
        "role" => $role
      );

      echo json_encode($data);
    }
  }

  static public function validaToken($jwt) {

    if($jwt != null && $jwt != "") {

      $secret_key = "00e3d043e7725fa6006e634f79c770c79d30b7f2a4b86afe5188cfe7bf6250b8";
      $token = JWT::decode($jwt,new Key($secret_key,'HS512'));
      $now = new DateTimeImmutable();
      $dominio = "formunica.com";

      if ($token->iss !== $dominio || $token->nbf > $now->getTimestamp() || $token->exp < $now->getTimestamp())
      {

        $data = array(
            "mensaje" => "No esta autorizado",
            "StatusCode" => 401
        );

        return json_encode($data);

      }
      else
      {
        return "ok";
      }

    }
    else {

      $data = array(
          "mensaje" => "No esta autorizado",
          "StatusCode" => 401
      );

      return json_encode($data);


    }
  }
}

 ?>
