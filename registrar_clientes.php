<?php

include("validaciones.php");

$nick = (isset($_POST['nick'])) ? $_POST['nick'] : null;
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : null;
$apellidos = (isset($_POST['apellidos'])) ? $_POST['apellidos'] : null;
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : null;
$localidad = (isset($_POST['localidad'])) ? $_POST['localidad'] : null;
$provincia = (isset($_POST['provincia'])) ? $_POST['provincia'] : null;
$email = (isset($_POST['correo'])) ? $_POST['correo'] : null;
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : null;
$password = (isset($_POST['password'])) ? $_POST['password'] : null;
$confirmpass = (isset($_POST['pass_confirm'])) ? $_POST['pass_confirm'] : null;

if($_SERVER['REQUEST_METHOD']=='POST'){
    echo "correcto <br>";
}else{
    echo "No funciona <br>";
}


if(val_texto($nombre)){
    echo "Nombre introducido correctamente <br>";
}else{
    echo "Debes introducir un nombre <br>";
}




?>