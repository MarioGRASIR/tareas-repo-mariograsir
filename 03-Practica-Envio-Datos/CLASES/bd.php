<?php

class Bd{

    private $server = "localhost";
    private $usuario = "root";
    private $password = "";
    private $dbname = "ejPhP";

    private $conexion;


    public function __construct(){

        $this->conexion = new mysqli($this->server, $this->usuario, $this->password, $this->dbname);
        $this->conexion->select_db($this->dbname);
        $this->conexion->query("SET NAMES 'utf8'");

    }

    public function getConexion(){

        return $this->conexion;
    }

}
?>