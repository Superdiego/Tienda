<?php
session_start();

include_once ("validaciones.php");
include_once ("funciones.php");

$nick = (isset($_POST['nick'])) ? $_POST['nick'] : null;
$dni = (isset($_POST['dni'])) ? $_POST['dni'] : null;
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : null;
$apellidos = (isset($_POST['apellidos'])) ? $_POST['apellidos'] : null;
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : null;
$localidad = (isset($_POST['localidad'])) ? $_POST['localidad'] : null;
$provincia = (isset($_POST['provincia'])) ? $_POST['provincia'] : null;
$cop = (isset($_POST['cop'])) ? $_POST['cop'] : null;
$email = (isset($_POST['correo'])) ? $_POST['correo'] : null;
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : null;
$password = (isset($_POST['password'])) ? $_POST['password'] : null;
$confirmpass = (isset($_POST['pass_confirm'])) ? $_POST['pass_confirm'] : null;
$altacliente ='';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty(trim($nick))) {
        $res_nic = "<span class='text-danger'>El campo Nick está vacio</span>";
    } else {
        $res_nic = ! val_texto($nick) ? "<span class='text-danger'>El nick debe empezar por una letra</span>" : '';
    }
    if (empty(trim($dni))) {
        $res_dni = "<span class='text-danger'>El campo D.N.I. está vacio</span>";
    } else {
        $res_dni = ! val_dni($dni) ? "<span class='text-danger'>Introduzca un dni válido</span>" : '';
    }
    if (empty(trim($nombre))) {
        $res_nom = "<span class='text-danger'>El campo Nombre está vacio</span>";
    } else {
        $res_nom = ! val_texto($nombre) ? "<span class='text-danger'>El nombre debe empezar por una letra</span>" : '';
    }
    if (empty(trim($apellidos))) {
        $res_ape = "<span class='text-danger'>El campo Apellidos está vacio</span>";
    } else {
        $res_ape = ! val_texto($apellidos) ? "<span class='text-danger'>Los apelllidos deben empezar por una letra</span>" : '';
    }
    if (empty(trim($direccion))) {
        $res_dir = "<span class='text-danger'>El campo dirección está vacio</span>";
    } else {
        $res_dir = ! val_texto($direccion) ? "<span class='text-danger'>La direccion debe empezar por una letra</span>" : '';
    }
    if (empty(trim($localidad))) {
        $res_loc = "<span class='text-danger'>El campo localidad está vacio</span>";
    } else {
        $res_loc = ! val_texto($localidad) ? "<span class='text-danger'>La localidad debe empezar por una letra</span>" : '';
    }
    if (empty(trim($provincia))) {
        $res_pro = "<span class='text-danger'>El campo provincia está vacio</span>";
    } else {
        $res_pro = ! val_texto($provincia) ? "<span class='text-danger'>Introduzca una provincia debe empezar por una letra</span>" : '';
    }
    if (empty(trim($cop))) {
        $res_cop = "<span class='text-danger'>El campo código postal está vacio</span>";
    }else if(!ctype_digit($cop)){
        $res_cop = "<span class='text-danger'>El código postal deben ser números</span>";
    }else{
        $res_cop = (!preg_match("/^[0-9]{5}$/",$cop)) ? "<span class='text-danger'>El código postal son cinco números</span>" : '';
    }
    if (empty(trim($email))) {
        $res_ema = "<span class='text-danger'>El campo email está vacio</span>";
    } else {
        $res_ema = ! val_correo($email) ? "<span class='text-danger'>Introduzca un email válido</span>" : '';
    }
    if (empty(trim($telefono))) {
        $res_tel = "<span class='text-danger'>El campo telefono está vacio</span>";
    } else {
        $res_tel = ! val_telef($telefono) ? "<span class='text-danger'>Introduzca un telefono válido</span>" : '';
    }
    if (empty(trim($password))) {       
        $res_pas = "<span class='text-danger'>El campo password está vacio</span>";
    } else{
        $res_pas = !val_pass($password) ? "<span class='text-danger'>El password está formado por tres caracteres</span>" : '';
    }
    if(empty (trim($confirmpass))) {
        $res_confpass = "<span class='text-danger'>El campo de confirmación del password está vacio</span>";
    }else{
        $res_confpass = !val_pass($confirmpass) ? "<span class='text-danger'>El password está formado por tres caracteres</span>" : '';
    }
    if(empty($res_pas) && empty($res_confpass)){
        $res_confpass = !val_confirmpass($password, $confirmpass) ? "<span class='text-danger'>No coincide con el password</span>" : '';
    }
    if (empty($res_nic) && empty($res_dni) && empty($res_nom) && empty($res_ape) && empty($res_dir) &&
        empty($res_loc) && empty($res_pro) && empty($res_cop) && empty($res_ema) && empty($res_tel) &&
        empty($res_confpas) && empty($res_confpass) ) {
            
            $altacliente = registrar_clientes($nick, $dni, $nombre, $apellidos, $direccion, $localidad,
                                        $provincia, $cop, $email, $telefono, $password);
        }
}
$nom_pag = "Alta de Clientes";
include_once ("Nuevacabecera.php");
include_once("Nuevolateral.php");
?>
<div class = 'col-md-8'>
<h4 class='text-success'><?php echo $altacliente?></h4>
<form method="post" action="registroClientes.php" class="px-5">
	<div class="form-group row">
		<label class="col-sm-4 col-form-label text-right">Nick:</label>
		<div class="col-sm-8">
			<input class="form-control" type="text" name="nick"
				value="<?php echo $nick ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_nic ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label text-right">DNI:</label>
		<div class="col-sm-8">
			<input class="form-control" type="text" name="dni"
				value="<?php echo $dni ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_dni ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label text-right">Nombre:</label>
		<div class="col-sm-8">
			<input class="form-control" type="text" name="nombre"
				value="<?php echo $nombre ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_nom ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label text-right">Apellidos:</label>
		<div class="col-sm-8">
			<input class="form-control" type="text" name="apellidos"
				value="<?php echo $apellidos ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_ape ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label text-right">Direccion:</label>
		<div class="col-sm-8">
			<input class="form-control" type="text" name="direccion"
				value="<?php echo $direccion ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_dir ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label text-right">Localidad:</label>
		<div class="col-sm-8">
			<input class="form-control" type="text" name="localidad"
				value="<?php echo $localidad ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_loc ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label text-right">Provincia:</label>
		<div class="col-sm-8">
			<input class="form-control" type="text" name="provincia"
				value="<?php echo $provincia ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_pro ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label text-right">C.Postal:</label>
		<div class="col-sm-8">
			<input class="form-control" type="text" name="cop"
				value="<?php echo $cop ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_cop ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label text-right">E-mail:</label>
		<div class="col-sm-8">
			<input class="form-control" type="text" name="correo"
				value="<?php echo $email ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_ema ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label text-right">Telefono:</label>
		<div class="col-sm-8">
			<input class="form-control" type="text" name="telefono"
				value="<?php echo $telefono ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_tel ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label text-right">Password:</label>
		<div class="col-sm-8">
			<input class="form-control" type="password" name="password"
				value="<?php echo $password ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_pas ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label text-right">Confirme su password:</label>
		<div class="col-sm-8">
			<input class="form-control" type="password" name="pass_confirm"
				value="<?php echo $confirmpass ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_confpass ?></div>
	</div>
	<div class="form-group row">
		<div class="col-sm-8 mx-auto">
			<input type="submit" class="btn btn-primary mr-5" name='registrar'
				value="Registrar">

</form>
<a class="btn btn-primary mr-5" href='index.php'>Cancelar</a>
</div>
</div>




</div>

			<?php include ("Nuevaautentificacion.php")?>

<?php include("Nuevopie.php")?>

