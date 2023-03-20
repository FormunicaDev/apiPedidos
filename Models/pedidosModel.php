<?php

require_once 'conexion.php';

class ModelPedidos {
  static public function crearPedidos($data,$detalle){
    $stmt=BD::conexion()->prepare("INSERT INTO pedidos (Codigo,codVendedor,codCliente,TipoVenta,Estado,Banco,
      FormaPago,Comentarios,numeroCheque,fechaCheque,Total,TotalDescuento,TotalNeto,FechaRegistro,UsuarioRegistro)
      values(:Codigo, :codVendedor, :codCliente, :TipoVenta, :Estado, :Banco, :FormaPago, :Comentarios, :numeroCheque, :fechaCheque,
      :Total, :TotalDescuento, :TotalNeto, :fechaRegistro, :UsuarioRegistro)");

      $estado = 1;
      $fecha = date('Y-m-d H:i:s');

      $stmt -> bindParam(":Codigo",$data["codigo"],PDO::PARAM_STR);
      $stmt -> bindParam(":codVendedor",$data["codVendedor"],PDO::PARAM_STR);
      $stmt -> bindParam(":codCliente",$data["codCliente"],PDO::PARAM_STR);
      $stmt -> bindParam(":TipoVenta",$data["TipoVenta"],PDO::PARAM_STR);
      $stmt -> bindParam(":Estado",$estado,PDO::PARAM_STR);
      $stmt -> bindParam(":Banco",$data["Banco"],PDO::PARAM_STR);
      $stmt -> bindParam(":FormaPago",$data["FormaPago"],PDO::PARAM_STR);
      $stmt -> bindParam(":Comentarios",$data["Comentarios"],PDO::PARAM_STR);
      $stmt -> bindParam(":numeroCheque",$data["numeroCheque"],PDO::PARAM_STR);
      $stmt -> bindParam(":fechaCheque",$data["fechaCheque"],PDO::PARAM_STR);
      $stmt -> bindParam(":Total",$data["Total"],PDO::PARAM_STR);
      $stmt -> bindParam(":TotalDescuento",$data["TotalDescuento"],PDO::PARAM_STR);
      $stmt -> bindParam(":TotalNeto",$data["TotalNeto"],PDO::PARAM_STR);
      $stmt -> bindParam(":fechaRegistro",$fecha,PDO::PARAM_STR);
      $stmt -> bindParam(":UsuarioRegistro",$data["UsuarioRegistro"],PDO::PARAM_STR);

      if($stmt->execute())
      {
        $clase = new ModelPedidos();
        $lastID=$clase->lastIdPedido($data["codCliente"],$data["Banco"],$data["TipoVenta"],$fecha);


        $clase->detallePedido($lastID[0]["IdPedido"],$detalle);

          $json = array(
            "mensaje"=> "Registro completado con exito",
            "StatusCode"=>"200",
            "pedido" => intval($lastID[0]["IdPedido"]) 
          );

          return json_encode($json);


      } else {
        $json = array(
          "mensaje"=>"Error al completar el registro",
          "statusCode"=>"400",
          "error"=>BD::conexion()->errorInfo()
        );

        return json_encode($json);
      }

      $stmt->close();
      $stmt = null;
  }

  private function detallePedido($IdPedido,$detalle){

    try {
      $stmt=BD::conexion()->prepare("INSERT INTO detallePedido (IdPedido,CodProducto,Cantidad,Precio,Descuento)
      values(:IdPedido, :codArticulo, :cantidad, :precioArticulo, :totalDesc)");

      foreach ($detalle as $key => $value) {
        $stmt -> bindParam(":IdPedido",$IdPedido,PDO::PARAM_STR);
        $stmt -> bindParam(":codArticulo",$value['codArticulo'],PDO::PARAM_STR);
        $stmt -> bindParam(":cantidad",$value['cantidad'],PDO::PARAM_STR);
        $stmt -> bindParam(":precioArticulo",$value['precioArticulo'],PDO::PARAM_STR);
        $stmt -> bindParam(":totalDesc",$value['totalDesc'],PDO::PARAM_STR);

        $stmt -> execute();
      }

      return true;

    } catch (\Exception $e) {
      return $e;
    }
  }

  private function lastIdPedido($cliente,$banco,$tipoVenta,$fecha){
    $stmt = BD::conexion()->prepare("SELECT IdPedido from pedidos
      where Estado = 1 and codCliente='$cliente' and Banco = $banco and TipoVenta = $tipoVenta and FechaRegistro = '$fecha'");
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);

      $stmt->close();
      $stmt=null;
  }

  static public function listarPedidos($user,$paginacion){

    $desde = $paginacion["desde"];
    $hasta = $paginacion["hasta"];

    if($user == '')
    {
      $stmt = BD::conexion()->prepare("SELECT * from
                                          (
                                          SELECT ROW_NUMBER() OVER(order by IdPedido) as ID, IdPedido,Codigo, FechaEmision,
                                          codVendedor,codCliente, b.TipoVenta,c.Estado,d.Banco,Comentarios,numeroCheque,
                                          fechaCheque,a.Total,a.TotalDescuento,a.TotalNeto,a.FechaRegistro,a.UsuarioRegistro as usuarioAs FROM
                                          pedidos a
                                          join TipoVenta b
                                          on a.TipoVenta = b.IdTipoVenta
                                          join EstadoVisualizacion c
                                          on a.Estado=c.IdEstadoVisualizacion
                                          join bancos d
                                          on a.Banco=d.IdBanco
                                          ) pedidos
                                          where ID between $desde and $hasta ");
    }
    else
    {
      $stmt = BD::conexion()->prepare("SELECT * from
                                          (
                                          SELECT ROW_NUMBER() OVER(order by IdPedido) as ID, IdPedido,Codigo, FechaEmision,
                                          codVendedor,codCliente, b.TipoVenta,c.Estado,d.Banco,Comentarios,numeroCheque,
                                          fechaCheque,a.Total,a.TotalDescuento,a.TotalNeto,a.FechaRegistro,a.UsuarioRegistro as usuarioAs FROM
                                          pedidos a
                                          join TipoVenta b
                                          on a.TipoVenta = b.IdTipoVenta
                                          join EstadoVisualizacion c
                                          on a.Estado=c.IdEstadoVisualizacion
                                          join bancos d
                                          on a.Banco=d.IdBanco
                                          where a.UsuarioRegistro = '$user'
                                          ) pedidos
                                          where ID between $desde and $hasta ");
    }


    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS);

    $stmt->close();

    $stmt=null;
  }

  static public function countRegPedidos($user){
    if($user == '')
    {
      $stmt = BD::conexion()->prepare("SELECT count(*) as totalRegistros FROM pedidos");
    }else {
      $stmt = BD::conexion()->prepare("SELECT count(*) as totalRegistros FROM pedidos where UsuarioRegistro = '$user'");
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->close();

    $stmt=null;
  }

  static public function countRegDetallePedidos($IdPedido){
    $stmt = BD::conexion()->prepare("SELECT count(*) as totalRegistros FROM detallePedido where IdPedido=$IdPedido");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->close();

    $stmt=null;
  }

  static public function listarDetallePedido($IdPedido,$paginacion) {
    $desde = $paginacion["desde"];
    $hasta = $paginacion["hasta"];

    $stmt = BD::conexion()->prepare("SELECT * FROM
                                        (
                                          SELECT ROW_NUMBER() OVER(order by a.IdDetallePedido) as ID, a.*,b.DESCRIPCION
                                          from detallePedido a
                                          join  [ALFA].[EXACTUS].[CH].[ARTICULO] b
                                          on a.CodProducto=b.Articulo
                                          where a.IdPedido=$IdPedido and status = 1
                                        ) detallePedido where ID between $desde and $hasta");

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
   
    //var_dump($result);
    return $result;
    $stmt->close();
    $stmt=null;
  }

  static public function listarDetallePedidoAssoc($IdPedido,$paginacion) {
    $desde = $paginacion["desde"];
    $hasta = $paginacion["hasta"];

    $stmt = BD::conexion()->prepare("SELECT * FROM
                                        (
                                          SELECT ROW_NUMBER() OVER(order by a.IdDetallePedido) as ID, a.*,b.DESCRIPCION
                                          from detallePedido a
                                          join  [ALFA].[EXACTUS].[CH].[ARTICULO] b
                                          on a.CodProducto=b.Articulo
                                          where a.IdPedido=$IdPedido and status = 1
                                        ) detallePedido where ID between $desde and $hasta");

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
    //var_dump($result);
    return $result;
    $stmt->close();
    $stmt=null;
  }

  static public function obtenerPedido($IdPedido) {
    $ID=intval($IdPedido);
    $stmt = BD::conexion()->prepare("SELECT a.IdPedido,a.FechaEmision, a.codCliente, b.NOMBRE cliente, c.nombres+' '+c.apellidos+'-'+a.codVendedor as vendedor,
    b.direccion,b.TELEFONO1,a.TotalDescuento,a.TotalNeto,a.Total
    from pedidos a
    join [ALFA].[EXACTUS].[CH].[cliente] b
    on a.codCliente = b.CLIENTE
    join vendedores c
    on a.codVendedor = c.cod_vend
    where IdPedido =$ID");

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    $result = json_encode($result);
    return $result;
    
    $stmt->close();

    $stmt=null;
  }

  static public function obtenerPedidoAssoc($IdPedido) {
    $ID=intval($IdPedido);
    $stmt = BD::conexion()->prepare("SELECT a.IdPedido,a.FechaEmision, a.codCliente, b.NOMBRE cliente, c.nombres+' '+c.apellidos+'-'+a.codVendedor as vendedor,
    b.direccion,b.TELEFONO1,a.TotalDescuento,a.TotalNeto,a.Total,a.Comentarios
    from pedidos a
    join [ALFA].[EXACTUS].[CH].[cliente] b
    on a.codCliente = b.CLIENTE
    join vendedores c
    on a.codVendedor = c.cod_vend
    where IdPedido =$ID");

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //$result = json_encode($result);
    return $result;
    
    $stmt->close();

    $stmt=null;
  }

  static public function obtenerDetalles($IdPedido) {
    $desde = $paginacion["desde"];
    $hasta = $paginacion["hasta"];

    $stmt = BD::conexion()->prepare("SELECT *, a.Cantidad*a.Precio as totalLemp 
                                        from detallePedido a
                                        join  [ALFA].[EXACTUS].[CH].[ARTICULO] b
                                        on a.CodProducto=b.Articulo where a.IdPedido=$IdPedido");

    $stmt->execute();
    return json_encode($stmt->fetchAll(PDO::FETCH_CLASS));

    $stmt->close();
    $stmt=null;
  }

  static public function anularPedido($IdPedido) {
    $stmt = BD::conexion()->prepare("UPDATE pedidos set Estado = 2 where IdPedido = $IdPedido");
    $stmt->execute();

    $data = array('mensaje' => "Pedido anulado con exito", 'statusCode' => '200' );

    return json_encode($data,true);
    $stmt->close();
    $stmt=null;
  }

  static public function anularDetallePedido($IdDetallePedido) {
    $stmt = BD::conexion()->prepare("UPDATE detallePedido set status = 0 where IdDetallePedido = $IdDetallePedido");
    $stmt->execute();

    $data =  array('mensaje' => 'Producto eliminado con exito','statusCode' => 200 );

    return json_encode($data,true);
    $stmt->close();
    $stmt=null;
  }
}

 ?>
