<?php

require_once 'conexion.php';

class ModelusuarioVendedor {
    static public function getUsuarioVendedor($user) {
        $stmt = BD::conexion()->prepare("SELECT *
        from relacionUserVendedor where usuario = '$user'");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
        $stmt->close();
        $stmt=null;
    }

    static public function getUsuarioVendedorAssoc($user) {
        $stmt = BD::conexion()->prepare("SELECT *
        from relacionUserVendedor where usuario = '$user'");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
        $stmt=null;
    }
}