<?php

class Conexion {

    private $llave;

    public function getLlave() {
        $host = "localhost";
        $usuario = "usujuegos";
        $base = "juegos";
        $pass = "secreto";
        $dsn = "mysql:host={$host};dbname={$base}";
        try {
            $this->llave = new PDO($dsn, $usuario, $pass);
            $this->llave->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->llave->exec("set names utf8");
        } catch (PDOException $ex) {
            echo "Error en la conexion, mensaje: " . $ex->getMessage();
            die("Conexion Mal!!!!");
        }
        return $this->llave;
    }

}
