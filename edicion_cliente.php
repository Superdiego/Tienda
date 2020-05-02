<?php
session_start();
if (! isset($_SESSION['autenticado'])) {
    header("location:index.php");
}

$nom_pag = "Edicion de Clientes";

include_once ("validaciones.php");
include_once ("funciones.php");

if(isset($_POST['bajaadminuser'])){
    $usuario = busca_cliente($_POST['bajaadminuser']);
}else{
    $usuario = (isset($_POST['modifadminuser'])) ? busca_cliente($_POST['modifadminuser']) : datos_usuario($_SESSION['autenticado']);
}

$nick = (isset($_POST['nick'])) ? $_POST['nick'] : $usuario->getNic_usr();
$dni = (isset($_POST['dni'])) ? $_POST['dni'] : $usuario->getDni_usr();
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : $usuario->getNom_usr();
$apellidos = (isset($_POST['apellidos'])) ? $_POST['apellidos'] : $usuario->getApe_usr();
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : $usuario->getDir_usr();
$localidad = (isset($_POST['localidad'])) ? $_POST['localidad'] : $usuario->getLoc_usr();
$provincia = (isset($_POST['provincia'])) ? $_POST['provincia'] : $usuario->getPro_usr();
$email = (isset($_POST['correo'])) ? $_POST['correo'] : $usuario->getEma_usr();
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : $usuario->getTel_usr();
if (isset($_POST['modifadminuser'])) {
    $password = $usuario->getPas_usr();
} else {
    $password = (isset($_POST['password'])) ? $_POST['password'] : null;
}
$confirmpass = (isset($_POST['pass_confirm'])) ? $_POST['pass_confirm'] : null;
$passw = (isset($_POST['passw'])) ? $_POST['passw'] : null;
$mostrar = "";
$msg = "";
$confadminbaja = '';
$nopassw = '';

$res_nic = '';
$res_dni = '';
$res_nom = '';
$res_ape = '';
$res_dir = '';
$res_loc = '';
$res_pro = '';
$res_ema = '';
$res_tel = '';
$res_pas = '';

$modifcliente = '';

if (isset($_POST['modifuser'])) {

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
    } else if (! val_pass($password)) {
        $res_pas = "<span class='text-danger'>El password está formado por tres caracteres</span>";
    } else {
        $res_pas = ($password != $usuario->getPas_usr()) ? "<span class='text-danger'>Password incorrecto</span>" : "";
    }

    if (empty($res_nic) && empty($res_dni) && empty($res_nom) && empty($res_ape) && empty($res_dir) && empty($res_loc) && empty($res_pro) && empty($res_ema) && empty($res_tel) && empty($res_pas)) {
        $modifcliente = editar_cliente($nick, $dni, $nombre, $apellidos, $direccion, $localidad, $provincia, $email, $telefono);
    }
}
if (isset($_POST['bajauser']) || isset($_POST['confbaja'])) {
    $mostrar = "style='display:none'";
    $msg = "<div class='container'><div class='row row-cols-2'><div class='col text-right'>
                <form method='POST' action='edicion_cliente.php'>
                <div class='col'><input type='password' name='passw'>
                </div></div><div class='col form-group row justify-content-center mt-5'>
                
                <input type='submit' value='Confirmar baja' name='confadminbaja' class='btn btn-danger mr-5'></form>
                <a class='btn btn-primary ml-5' href='edicion_cliente.php'>Cancelar</a></div></div>";
}
if(isset($_POST['bajaadminuser'])){
    $mostrar = "style='display:none'";
    $confadminbaja = "</div><div><h5 class='mt-5'>¿Eliminar registro  del usuario: ". $usuario->getNom_usr()." ".
                    $usuario->getApe_usr(). " definitivamente?</h5>
                    <h5 class='mx-auto'>NO es nada recomendable</h5></div>
                    <div class='row justify-content-center mt-5'>
                    <form method='POST' action='edicion_cliente.php'>
                    <input type='hidden' name='bajaadminuser' value=".$usuario->getId_usr().">
                    <input type='submit' value='Confirmar baja' name='confadminbaja' class='btn btn-danger mr-5'>
                    </form>
                    <a class='btn btn-primary ml-5' href='adminusers.php'>Cancelar</a>";
}

if(isset($_POST['confadminbaja'])){
    baja_usuario($usuario->getId_usr());
    header('location:adminusers.php');
}


if (isset($_POST['confbaja'])) {
    if (empty($passw)) {
        $nopassw = "<p class='text-danger text-center'>El campo password está vacío</p>";
    } else if (! val_pass($passw)) {
        $nopassw = "<p class='text-danger text-center'>El password se compone de tres caracteres</p>";
    } else {
        $nopassw = ($usuario->getPas_usr() != $passw) ? "<p class='text-danger text-center'>Password erróneo</p>" : "";
    }
    if (empty($nopassw)) {
        baja_cliente($usuario->getId_usr());
        session_destroy();
        header("location:despedida.php");
    }
}


include_once ("Nuevacabecera.php");
include_once ('Nuevolateral.php');
?>
<div class='col-md-8'>
	<div class='row container justify-content-center mt-5'
		<?php echo $mostrar?>>
		<h4><?php echo $modifcliente?></h4>
		<form method="post" action="edicion_cliente.php" class="px-5">
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">Nick:</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="nick"
						value="<?php echo $nick ?>" readonly><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_nic ?></div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">DNI:</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="dni"
						value="<?php echo $dni ?>" readonly><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_dni ?></div>
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
					<input class="form-control" ype="text" name="direccion"
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
				<label class="col-sm-4 col-form-label text-right">E-mail:</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="correo"
						value="<?php echo $email ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_ema ?></div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">Telefono</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="telefono"
						value="<?php echo $telefono ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_tel ?></div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label text-right">Password:</label>
				<div class="col-sm-8">
					<input class="form-control" type="password" name="password"
						value="<?php echo $password ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_pas ?><br>
				</div>
			</div>

			<div class="form-group row">
				<input type="submit" name='modifuser' value='Modificar'
					class="btn btn-primary mr-5"><a class="btn btn-primary mr-5"
					href='adminusers.php'>Cancelar</a>
			</div>
		</form>
	</div>
	<?php echo $nopassw ?>
	<div class='row justify-content-end'><?php echo $msg.$confadminbaja ?>
		<form method='POST' action='edicion_cliente.php' <?php echo $mostrar?>>
			<input type="submit" name='bajauser' value='Dar de baja'
				class="btn btn-danger">
		</form>
	</div>
</div>


<?php include ("Nuevaautentificacion.php")?>

<?php include("Nuevopie.php")?>
