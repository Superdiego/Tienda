<?php
session_start();
if(!isset($_SESSION['autenticado'])){
    header("location:index.php");
}
$nom_pag="Edicion de Clientes";
include_once ("cabecera.php");
include_once("validaciones.php");
include_once("funciones.php");

$usuario = datos_usuario($_SESSION['autenticado']);

$nick = (isset($_POST['nick'])) ? $_POST['nick'] :  $usuario->getNic_usr();
$dni = (isset($_POST['dni'])) ? $_POST['dni'] :  $usuario->getDni_usr();
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] :  $usuario->getNom_usr();
$apellidos = (isset($_POST['apellidos'])) ? $_POST['apellidos'] :  $usuario->getApe_usr();
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] :  $usuario->getDir_usr();
$localidad = (isset($_POST['localidad'])) ? $_POST['localidad'] :  $usuario->getLoc_usr();
$provincia = (isset($_POST['provincia'])) ? $_POST['provincia'] : $usuario->getPro_usr();
$email = (isset($_POST['email'])) ? $_POST['email'] :  $usuario->getEma_usr();
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] :  $usuario->getTel_usr();
$password = (isset($_POST['password'])) ? $_POST['password'] :  (isset($_POST['password'])) ? $_POST['password'] :null;
$confirmpass = (isset($_POST['pass_confirm'])) ? $_POST['pass_confirm'] :null;

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

    if(val_texto($nick)&&val_dni($dni)&&val_texto($nombre)&&val_texto($apellidos)&&val_texto($direccion)&&
    val_texto($localidad)&&val_texto($provincia)&&val_correo($email)&&val_telef($telefono)&&
    val_pass($password,$confirmpass)){
        editar_cliente($nick,$dni,$nombre,$apellidos,$direccion,$localidad,$provincia,$email,
            $telefono,$password);
    }else{
    echo "algo falla";
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Edicion cliente</title>
</head>

<body>
<div class="container">
<div class="row">
<div class="md-9">
<form method="post" action="edicion_cliente.php">
Nick: <input type="text" name="nick" value="<?php echo $nick ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_nic ?><br>
DNI: <input type="text" name="dni" value="<?php echo $dni ?>" readonly><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_dni ?><br>
Nombre: <input type="text" name="nombre" value="<?php echo $nombre ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_nom ?><br>
Apellidos: <input type="text" name="apellidos" value="<?php echo $apellidos ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_ape ?><br>
Direccion: <input type="text" name="direccion" value="<?php echo $direccion ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_dir ?><br>
Localidad: <input type="text" name="localidad" value="<?php echo $localidad ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_loc ?><br>
Provincia: <input type="text" name="provincia" value="<?php echo $provincia ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_pro ?><br>
E-mail: <input type="text" name="correo" value="<?php echo $email ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_ema ?><br>
Telefono: <input type="text" name="telefono" value="<?php echo $telefono ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_tel ?><br>
Password: <input type="password" name="password" value="<?php echo $password ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_pas ?><br>
Confirme su password: <input type="password" name="pass_confirm"value="<?php echo $confirmpass ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_pas ?><br>
<br><br>
<input type="submit" value="Modificar">
</form>
<?php

 ?>
 </div>
 <div class="md-3">
<a href="index_cliente.php">Volver a inicio</a>
 </div></div></div>
</body>

</html>