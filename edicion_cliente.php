<?php
$nom_pag="Edicion de Clientes";
include_once ("cabecera.php");
include_once("validaciones.php");
include_once("funciones.php");

$usuario = editar_usuario();

$nick = (isset($_POST['nick'])) ? $_POST['nick'] : null;
$dni = (isset($_POST['dni'])) ? $_POST['dni'] : null;
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
    
    $res_nic = !val_texto($nick) ? "<span class='error'>Introduzca un nick</span>" : '';
    $res_dni = !val_dni($dni) ? "<span class='error'>Introduzca un dni</span>" : '';
    $res_nom = !val_texto($nombre) ? "<span class='error'>Introduzca un nombre</span>" : '';
    $res_ape = !val_texto($apellidos) ? "<span class='error'>Introduzca apellidos</span>" : '';
    $res_dir = !val_texto($direccion) ? "<span class='error'>Introduzca una direccion</span>" : '';
    $res_loc = !val_texto($localidad) ? "<span class='error'>Introduzca una localidad</span>" : '';
    $res_pro = !val_texto($provincia) ? "<span class='error'>Introduzca una provincia</span>" : '';
    $res_ema = !val_correo($email) ? "<span class='error'>Introduzca un email</span>" : '';
    $res_tel = !val_telef($telefono) ? "<span class='error'>Introduzca un telefono</span>" : '';
    $res_pas = !val_pass($password,$confirmpass) ? "<span class='error'>Introduzca un password</span>" : '';
   
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Edicion cliente</title>
</head>

    <body>
      <?php

	?>
    </body>

</html>