<?php

require "../clases/Bd.php";
require_once "../clases/usuarios.php";


$usuario = new Usuario(
    $_POST['nombre'],
    $_POST['apellidos'],
    $_POST['edad'],
    $_POST['correo'],
    $_POST['provincia'],
    $_POST['fecha'],
    $_POST['telefonofijo'],
    $_POST['telefonomovil'],
    $_POST['hijos'],
    isset($_POST['condiciones']) ? 1 : 0
);

$usuario->insertarBD();

?>