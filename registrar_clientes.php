<?php
$nom_pag="Alta Clientes";
include ("validaciones.php");

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (val_texto($nombre)) {
        echo "Nombre introducido correctamente <br>";
    } else {
        echo "Debes introducir un nombre <br>";
    }

    if (val_texto($apellidos)) {
        echo "Apellidos introducidos correctamente <br>";
    } else {
        echo "Debes introducir unos apellidos <br>";
    }
 
    if (val_texto($nick)) {
        echo "Nick introducido correctamente <br>";
    } else {
        echo "Debes introducir un nick <br>";
    }
    
    if (val_texto($direccion)) {
        echo "Direccion introducido correctamente <br>";
    } else {
        echo "Debes introducir una direccion <br>";
    }

    if (val_texto($localidad)) {
        echo "Localidad introducida correctamente <br>";
    } else {
        echo "Debes introducir una localidad <br>";
    }
    
    if (val_texto($provincia)) {
        echo "Provincia introducido correctamente <br>";
    } else {
        echo "Debes introducir una provincia <br>";
    }
    
    if (val_telef($telefono)) {
        echo "Telefono correcto<br>";
    } else {
        echo "Introduzca el numero de telefono sin espacios y sin codigo internacional<br>";
    }

    if (val_correo($email)) {
        echo "Correo correcto<br>";
    } else {
        echo "Introduzca un correo valido<br>";
    }
    
    if (val_pass($password, $confirmpass)){
        echo "Password correcto<br>";
    }
}

?>