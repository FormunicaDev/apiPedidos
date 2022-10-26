<?php
ini_set('display_error','On');
error_reporting(E_ALL);

class BD {
  static public function conexion() {
    $serverName = "10.10.0.24"; //serverName\instanceName
    $Database = "honduras";
    $user = "sa";
    $password = "mufn2005.";
    //$connectionInfo = array( "Database"=>"honduras", "UID"=>"sa", "PWD"=>"mufn2005.","CharacterSet" => "UTF-8");

    $conexion = new PDO("sqlsrv:Server=$serverName;database=$Database",$user,$password);
    $conexion->exec("set nomes utf8");

    return $conexion;
  }
}

/*
if( $conexion ) {
    echo "Conexión establecida.<br />";
}else{
    echo "Conexión no se pudo establecer.<br />";
    die( print_r( sqlsrv_errors(), true));
}*/

?>
