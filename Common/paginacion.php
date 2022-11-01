<?php

class pagination {
  static public function paginacion($tabla,$cantidad,$pagina,$totalRegistros){
    $totalPaginas = 0;
    $desde = 0;
    $hasta = 0;

    if($cantidad == 0 || $cantidad == null){
      $totalPaginas = 1;
      $desde = 1;
      $hasta = $totalRegistros;
      $cantidad = $totalRegistros;
    }else{
      $totalPaginas = ceil($totalRegistros/$cantidad);
      $desde = ($pagina-1)*$cantidad;
      $hasta = $desde + $cantidad;
    }

    $data = array(
      "totalRegistros" => $totalRegistros,
      "totalPaginas" => $totalPaginas,
      "desde" => $desde+1,
      "hasta" => $hasta,
      "registroPorPagina" => $cantidad,
      "pagina" => $pagina
    );

    return $data;
  }
}

 ?>
