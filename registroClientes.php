<?php
$nom_pag="Alta de Clientes";
include ("cabecera.php");


include("validaciones.php");
include("funciones.php");

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

<form method="post" action="registroClientes.php">
Nick: <input type="text" name="nick" value="<?php echo $nick ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_nic ?><br>
DNI: <input type="text" name="dni" value="<?php echo $dni ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_dni ?><br>
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
<input type="submit" value="Registrar">

</form>

<?php 

if(val_texto($nick)&&val_dni($dni)&&val_texto($nombre)&&val_texto($apellidos)&&val_texto($direccion)&&
    val_texto($localidad)&&val_texto($provincia)&&val_correo($email)&&val_telef($telefono)&&
    val_pass($password,$confirmpass)){
    
        registrar_clientes($nick,$dni,$nombre,$apellidos,$direccion,$localidad,$provincia,$email,
            $telefono,$password);
    
}

?>
<br><br><a href="index.php">Volver a pagina principal</a>

</body>

</html>
