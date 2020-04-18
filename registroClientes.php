<?php
session_start();
$nom_pag="Alta de Clientes";
include_once ("cabecera.php");
include_once("validaciones.php");
include_once("funciones.php");

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

<form method="post" action="registroClientes.php" class="px-5">
<div class="form-group row">
<label class="col-sm-2 col-form-label">Nick:</label><div class="col-sm-10"><input class="form-control" type="text" name="nick" value="<?php echo $nick ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_nic ?></div></div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">DNI:</label><div class="col-sm-10"><input class="form-control" type="text" name="dni" value="<?php echo $dni ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_dni ?></div></div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Nombre:</label><div class="col-sm-10"><input class="form-control" type="text" name="nombre" value="<?php echo $nombre ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_nom ?></div></div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Apellidos:</label><div class="col-sm-10"><input class="form-control" type="text" name="apellidos" value="<?php echo $apellidos ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_ape ?></div></div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Direccion:</label><div class="col-sm-10"><input class="form-control" type="text" name="direccion" value="<?php echo $direccion ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_dir ?></div></div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Localidad:</label><div class="col-sm-10"><input class="form-control" type="text" name="localidad" value="<?php echo $localidad ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_loc ?></div></div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Provincia:</label><div class="col-sm-10"><input class="form-control" type="text" name="provincia" value="<?php echo $provincia ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_pro ?></div></div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">E-mail:</label><div class="col-sm-10"><input class="form-control" type="text" name="correo" value="<?php echo $email ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_ema ?></div></div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Telefono:</label><div class="col-sm-10"><input class="form-control" type="text" name="telefono" value="<?php echo $telefono ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_tel ?></div></div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Password:</label><div class="col-sm-10"><input class="form-control" type="password" name="password" value="<?php echo $password ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_pas ?></div></div>
<div class="form-group row">
<label class="col-sm-2 col-form-label">Confirme su password:</label><div class="col-sm-10"><input class="form-control" type="password" name="pass_confirm"value="<?php echo $confirmpass ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_pas ?></div></div>
<div class="form-group row">
<div class="col-sm-10">
<button type="submit" class="btn btn-primary">Registrar</div></div>
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

</div>
			<div class="col-md-2">
			<?php include ("autentificacion.php")?>
			</div>
</div>
</div>
<?php include("pie.php")?>
</body>
</html>
