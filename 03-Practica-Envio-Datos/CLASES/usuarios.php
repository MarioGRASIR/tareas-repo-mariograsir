<?php

class Usuario {

    private $nombre;
    private $apellidos;
    private $edad;
    private $correo;
    private $provincia;
    private $fecha;
    private $telefonofijo;
    private $telefonomovil;
    private $hijos;
    private $condiciones;

    public function __construct($nombre, $apellidos, $edad, $correo, $provincia, $fecha, $telefonofijo, $telefonomovil, $hijos, $condiciones) {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->edad = $edad;
        $this->correo = $correo;
        $this->provincia = $provincia;
        $this->fecha = $fecha;
        $this->telefonofijo = $telefonofijo;
        $this->telefonomovil = $telefonomovil;
        $this->hijos = $hijos;
        $this->condiciones = $condiciones;
    }

    public function insertarBD() {
        $bd = new Bd();
        $conexion = $bd->getConexion();

        $sql = "INSERT INTO usuarios (nombre, apellidos, edad, correo, provincia, fecha_nacimiento, telefono_fijo, telefono_movil, hijos, condiciones_aceptadas) 
                VALUES ('$this->nombre', '$this->apellidos', $this->edad, '$this->correo', '$this->provincia', '$this->fecha', '$this->telefonofijo', '$this->telefonomovil', '$this->hijos', $this->condiciones)";

        if ($conexion->query($sql)) {
            echo "Usuario registrado correctamente";
        } else {
            echo "Error al registrar el usuario: " . $conexion->error;
        }
    }
}

?>