<?php
session_start();
if (! isset($_SESSION['autenticado'])) {
    header("location:index.php");
}

$nom_pag = "Edicion de Clientes";
include_once ("cabecera.php");
include_once ("validaciones.php");
include_once ("funciones.php");

$usuario = datos_usuario($_SESSION['autenticado']);

$nick = (isset($_POST['nick'])) ? $_POST['nick'] : $usuario->getNic_usr();
$dni = (isset($_POST['dni'])) ? $_POST['dni'] : $usuario->getDni_usr();
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : $usuario->getNom_usr();
$apellidos = (isset($_POST['apellidos'])) ? $_POST['apellidos'] : $usuario->getApe_usr();
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : $usuario->getDir_usr();
$localidad = (isset($_POST['localidad'])) ? $_POST['localidad'] : $usuario->getLoc_usr();
$provincia = (isset($_POST['provincia'])) ? $_POST['provincia'] : $usuario->getPro_usr();
$email = (isset($_POST['email'])) ? $_POST['email'] : $usuario->getEma_usr();
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : $usuario->getTel_usr();
$password = (isset($_POST['password'])) ? $_POST['password'] : null;
$confirmpass = (isset($_POST['pass_confirm'])) ? $_POST['pass_confirm'] : null;

$modifcliente = '';

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
    } else {
        $res_pas = !val_pass($password) ? "<span class='text-danger'>El password está formado por tres caracteres</span>" : '';
    }
    if (empty(trim($confirmpass))) {
        $res_confpass = "<span class='text-danger'>El campo de confirmación del password está vacio</span>";
    } else {
        $res_confpass = !val_pass($confirmpass) ? "<span class='text-danger'>El password está formado por tres caracteres</span>" : '';
    }
    if (empty($res_pas) && empty($res_confpass)) {
        $res_confpass = !val_confirmpass($password, $confirmpass) ? "<span class='text-danger'>No coincide con el password</span>" : '';
    }


    if (val_texto($nick) && val_dni($dni) && val_texto($nombre) && val_texto($apellidos) &&
       val_texto($direccion)&& val_texto($localidad) && val_texto($provincia) && val_correo($email) &&
       val_telef($telefono) && val_pass($password) && val_pass($confirmpass) &&
       val_confirmpass($password, $confirmpass)) {
           $modifcliente = editar_cliente($nick, $dni, $nombre, $apellidos, $direccion,
                           $localidad, $provincia, $email, $telefono, $password);
    }
}
?>
<h4><?php echo $modifcliente?></h4>
<form method="post" action="edicion_cliente.php" class="px-5">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Nick:</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="nick"
				value="<?php echo $nick ?>" readonly><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_nic ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">DNI:</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="dni"
				value="<?php echo $dni ?>" readonly><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_dni ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Nombre:</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="nombre"
				value="<?php echo $nombre ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_nom ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Apellidos:</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="apellidos"
				value="<?php echo $apellidos ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_ape ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Direccion:</label>
		<div class="col-sm-10">
			<input class="form-control" ype="text" name="direccion"
				value="<?php echo $direccion ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_dir ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Localidad:</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="localidad"
				value="<?php echo $localidad ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_loc ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Provincia:</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="provincia"
				value="<?php echo $provincia ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_pro ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">E-mail:</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="correo"
				value="<?php echo $email ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_ema ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Telefono</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="telefono"
				value="<?php echo $telefono ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_tel ?></div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Password:</label>
		<div class="col-sm-10">
			<input class="form-control" type="password" name="password"
				value="<?php echo $password ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_pas ?><br>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Confirme su password:</label>
		<div class="col-sm-10">
			<input class="form-control" type="password" name="pass_confirm"
				value="<?php echo $confirmpass ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_confpass ?></div>
	</div>
	<div class="form-group row">
		<div class="col-sm-10 mx-auto">
			<input type="submit" name='modifuser' value='Modificar'
				class="btn btn-primary mr-5">

</form>
<a class="btn btn-primary mr-5" href='index.php'>Cancelar</a>

</div>
</div>

<?php

 ?>
</div>
<div class="col-md-2">
<?php include ("autentificacion.php")?>
	</div>
</div>
</div>
<?php include("pie.php")?>
</body>
</html>