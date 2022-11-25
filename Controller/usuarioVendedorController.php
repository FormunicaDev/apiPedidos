<?php

class ControllerUsuarioVendedor {
    static public function getVendedorByUser($user) {
        $vendedorByUser = ModelusuarioVendedor::getUsuarioVendedor($user);

        if($vendedorByUser === null) {
            $data = array(
                "data" => "El usuario no tiene asociado un codigo de vendedor" ,
                "StatusCode" => 404
              );
        
              echo json_encode($data);
              return;
        } else {
            $data = array(
                "data" => $vendedorByUser,
                "StatusCode" => 200
              );
        
              echo json_encode($data);
              return;
        }
    }
}