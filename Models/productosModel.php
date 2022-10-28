<?php
require_once 'conexion.php';

class ModelProductos {

  static public function listarProductos() {
    $stmt = BD::conexion()->prepare("SELECT cod_prod,nom_prod,unidad,medida,pvp,Articulo
                                        from producto");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);

    $stmt->close();

    $stmt=null;
  }

  static public function buscarProducto($ID) {
    $stmt = BD::conexion()->prepare("SELECT cod_prod,nom_prod,unidad,medida,pvp,Articulo
                                        from producto where cod_prod='$ID'");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);

    $stmt->close();

    $stmt=null;
  }

  static public function totalProductos() {
    $stmt = BD::conexion()->prepare("SELECT count(*) as cantidad from producto");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);

    $stmt->close();

    $stmt=null;
  }

  static public function buscarArticulo($codArticulo) {
    $stmt = BD::conexionExactus()->prepare("SELECT ARTICULO,DESCRIPCION,PRECIO_BASE_LOCAL,PRECIO_BASE_DOLAR
                                        from ch.Articulo where ARTICULO = '$codArticulo'");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);

    $stmt->close();

    $stmt=null;
  }

}

 ?>
