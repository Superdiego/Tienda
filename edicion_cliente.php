<?php
session_start();
if (! isset($_SESSION['autenticado'])) {
    header("location:index.php");
}

$nom_pag = "Edicion de Clientes";

include_once ("validaciones.php");
include_once ("funciones.php");

$modifok='';
if(isset($_GET['modif'])){
    $usuario = busca_cliente($_GET['modif']);
}else if(isset($_POST['bajaadminuser']) || isset($_POST['confadminbaja'])){
    $usuario = busca_cliente($_POST['bajaadminuser']);
}else if(isset($_POST['bajauser']) || isset($_POST['confbaja'] )){
    $usuario = busca_cliente($_POST['nomuser']);
}else if(isset($_POST['modifuser']) || isset($_POST['modifpass'])){
    $usuario = datos_usuario($_POST['nick']);
}else{
    $usuario = (isset($_POST['modifadminuser'])) ? busca_cliente($_POST['modifadminuser']) : datos_usuario($_SESSION['autenticado']);
}
$admin = datos_usuario($_SESSION['autenticado']);
$nick = (isset($_POST['nick'])) ? $_POST['nick'] : $usuario->getNic_usr();
$rol = (isset($_POST['rol'])) ? $_POST['rol'] : $usuario->getRol_usr();
$dni = (isset($_POST['dni'])) ? $_POST['dni'] : $usuario->getDni_usr();
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : $usuario->getNom_usr();
$apellidos = (isset($_POST['apellidos'])) ? $_POST['apellidos'] : $usuario->getApe_usr();
$direccion = (isset($_POST['direccion'])) ? $_POST['direccion'] : $usuario->getDir_usr();
$localidad = (isset($_POST['localidad'])) ? $_POST['localidad'] : $usuario->getLoc_usr();
$provincia = (isset($_POST['provincia'])) ? $_POST['provincia'] : $usuario->getPro_usr();
$cop = (isset($_POST['cop'])) ? $_POST['cop'] : $usuario->getCop_usr();
$email = (isset($_POST['correo'])) ? $_POST['correo'] : $usuario->getEma_usr();
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : $usuario->getTel_usr();
$activo = (isset($_POST['activo'])) ? $_POST['activo'] : $usuario->getAct_usr();
if ($admin->getRol_usr() == 3 || $admin->getRol_usr() == 4) {
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
$err_rol = '';
$res_dni = '';
$res_nom = '';
$res_ape = '';
$res_dir = '';
$res_loc = '';
$res_pro = '';
$res_ema = '';
$res_tel = '';
$res_pas = '';
$res_act = '';
$res_cop = '';

$modifcliente = '';
$msg_modifpass = '';

if (isset($_POST['modifuser'])) {

    if (empty(trim($nick))) {
        $res_nic = "<span class='text-danger'>El campo Nick está vacio</span>";
    } else {
        $res_nic = ! val_texto($nick) ? "<span class='text-danger'>El nick debe empezar por una letra</span>" : '';
    }
    if (empty(trim($rol))) {
        $err_rol = "<span class='text-danger'>El campo rol está vacío</span>";
    } else if (! ctype_digit($rol)) {
        $err_rol = "<span class='text-danger'>El campo rol debe ser un número</span>";
    } else {
        $err_rol = ($rol < 1 || $rol > 4) ? "<span class='text-danger'>El rol debe ser de uno a cuatro</span>" : '';
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
    if(empty(trim($activo))){
        $res_act = "<span class='text-danger'>El campo activo está vacio</span>";
    } else if(!ctype_digit($activo)){
        $res_act = "<span class='text-danger'>El campo activo debe ser un número</span>";
    } else{
        $res_act = ($activo != 0 && $activo !=1) ? "<span class='text-danger'>El campo activo de ser uno o cero</span>" : '';    }
    if (empty(trim($password))) {
        $res_pas = "<span class='text-danger'>El campo password está vacio</span>";
    } else if (! val_pass($password)) {
        $res_pas = "<span class='text-danger'>El password está formado por tres caracteres</span>";
    } else {
        $res_pas = ($password != $usuario->getPas_usr()) ? "<span class='text-danger'>Password incorrecto</span>" : "";
    }

    if (empty($res_nic) && empty($err_rol) && empty($res_dni) && empty($res_nom) &&
        empty($res_ape) && empty($res_dir) && empty($res_loc) && empty($res_pro) &&
        empty($res_cop) && empty($res_ema) && empty($res_tel) && empty($res_pas) &&
        empty($res_act)) {
            $modifok = editar_cliente($dni, $rol, $nombre, $apellidos,
            $direccion, $localidad, $provincia, $cop, $email, $telefono, $activo);
            //$modifok = "<span class='text-success'>Modificación correcta</span>";
            $url = datos_usuario($nick)->getId_usr();
            
            //header("location:edicion_cliente.php?modif=$url");
    }
}
$cambiarpass = '';
$res_oldpass ='';
$res_newpass='';
$res_newpassconf='';

if(isset($_POST['confmodifpass'])){
    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];
    $newpassconf = $_POST['newpassconf'];
    $usuario = busca_cliente($_POST['idpass']);
    if (empty(trim($oldpass))) {
        $res_oldpass = "<span class='text-danger'>El campo password está vacio</span>";
    } else if (! val_pass($oldpass)) {
        $res_oldpass = "<span class='text-danger'>El password está formado por tres caracteres</span>";
    } else {
        $res_oldpass = ($oldpass != $usuario->getPas_usr()) ? "<span class='text-danger'>Password incorrecto</span>" : "";
    }
    if (empty(trim($newpass))) {
        $res_newpass = "<span class='text-danger'>El campo password está vacio</span>";
    } else{
        $res_newpass = (! val_pass($newpass)) ? "<span class='text-danger'>El password está formado por tres caracteres</span>" : "";
    }
    if (empty(trim($newpassconf))) {
        $res_newpassconf = "<span class='text-danger'>El campo password está vacio</span>";
    } else if ((! val_pass($newpassconf))){
        $res_newpassconf = "<span class='text-danger'>El password está formado por tres caracteres</span>";        
    } else {
        $res_newpassconf = ($newpass != $newpassconf) ? "<span class='text-danger'>No coincide la confirmación del nuevo password<span>" : "";
    }
    if(empty($res_oldpass) && empty($res_newpass) && empty($res_newpassconf)){
        $cambio = cambiar_password($_POST['idpass'],$newpass);
        $msg_modifpass = "Password cambiado";
    }
}
if(isset($_POST['modifpass']) || isset($_POST['confmodifpass']) ){
    $cambio ='';
    $mostrar = "style='display:none'";
    $cambiarpass = "<div class='col-8 form-group row justify-content-center mt-5'>
            <h5 class='text-success'>$cambio</h5>
            <form method='POST' action='edicion_cliente.php'>
            <label>".$usuario->getNom_usr()."</label>
            <label>, introduzca su password: </label>
            <input type='hidden' name='idpass' value=".$usuario->getId_usr().">
            <input type='password' name='oldpass'></div>
            <p class='text-center'>$res_oldpass</p>
            <div class='col form-group row justify-content-center mt-5'>
            <label> Introduzca nuevo password: </label>
            <input type='password' name='newpass'></div>
            <p class='text-center'>$res_newpass</p>
            <div class='col form-group row justify-content-center mt-5'>
            <label> Repita su nuevo password: </label>
            <input type='password' name='newpassconf'></div>
            <p class='text-center'>$res_newpassconf</p>
            <div class='col form-group row justify-content-center mt-5'>
            <input type='submit' class='btn btn-primary mr-5' name='confmodifpass' value='Cambiar password'>
            </form><a href='adminusers.php'><button class='btn btn-primary'>Cancelar</button>
            </div>";
}




if (isset($_POST['bajauser']) || isset($_POST['confbaja'])) {
    $mostrar = "style='display:none'";
    $msg = "<div class='container'>
                <h4>$nombre &nbsp;  $apellidos</h4>
                <div class='col form-group row justify-content-center mt-5'>
                
                <form method='POST' action='edicion_cliente.php'>
                <label> Introduzca de nuevo su password: </label>
                <input type='password' name='passw'>
                </div></div>
                <div class='col form-group row justify-content-center mt-5'> 
                <input type='hidden' name='nomuser' value='".$usuario->getId_usr()."'>               
                <input type='submit' value='Confirmar baja' name='confbaja' class='btn btn-danger mr-5'></form>
                <a class='btn btn-primary ml-5' href='adminusers.php'>Cancelar</a></div>";
}
if(isset($_POST['bajaadminuser'])){
    if($admin->getRol_usr() == 4 && $admin == $usuario){
 
    }else{
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
}

if(isset($_POST['confadminbaja'])) {
    if($admin->getRol_usr() == 4 && $admin != $usuario){
    baja_usuario($usuario->getId_usr());;
    header('location:adminusers.php');
    }
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
        if($admin->getRol_usr() == 4 && $admin == $usuario){
            header('location:adminusers.php');
        }else{
        session_destroy();
        header("location:despedida.php");
        }
    }
}


include_once ("Nuevacabecera.php");
include_once ('Nuevolateral.php');
?>
<div class='col-md-8'><?php echo $cambiarpass?>
<h4><?php echo $msg_modifpass?></h4>
	<div class='row container justify-content-center mt-5'
		<?php echo $mostrar?>>
		<h4><?php echo $modifok?></h4>
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
				<label class="col-sm-4 col-form-label text-right">C.postal:</label>
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
				<label class="col-sm-4 col-form-label text-right">Telefono</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="telefono"
						value="<?php echo $telefono ?>"><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_tel ?></div>
			</div>
	<?php 
	   if($admin->getRol_usr() == 4 && $admin != $usuario){
	   
	       echo  "<div class='form-group row'>
                <label class='col-sm-4 col-form-label text-right'>Rol:</label>
                <div class='col-sm-8'>
                <select name='rol' value='" . $rol . "'>
                <option value='1'";
	       if ($rol == 1){echo " selected";}
	       echo ">Invitado</option>
                <option value='2'";
	       if ($rol == 2){echo " selected";}
	       echo ">Cliente</option>
                <option value='3'";
	       if ($rol == 3){echo " selected";}
	       echo ">Empleado</option> 
                <option value='4'";
	       if ($rol == 4){echo " selected";}
	       echo ">Administrador</option> ></select></div></div>";  

		   echo "<div class='form-group row'>
			    <label class='col-sm-4 col-form-label text-right'>Activo:</label>
			    <div class='col-sm-8'>
			    <input class='form-control' type='text' name='activo' value=$activo>";
			if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $res_act; 
            echo "</div></div>";
			} 
			?>
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
				<input type="submit" class='btn btn-primary' name='modifpass' value='Cambiar password'>
			</div>
		</form>
	</div>
	<?php echo $nopassw ?>
	<?php
	$escondbaja = '';
	if($admin->getRol_usr() == 4 && $usuario==$admin){
	    $escondbaja = "style=display:none";
	}
	?>
	<div class='row justify-content-end' <?php echo $escondbaja ?>><?php echo $msg.$confadminbaja ?>
		<form method='POST' action='edicion_cliente.php' <?php echo $mostrar?>>
			<input type='hidden' name='nomuser' value=<?php echo $usuario->getId_usr()?>>
			<input type="submit" name='bajauser' value='Dar de baja'
				class="btn btn-danger">
		</form>
	</div>
</div>


<?php include ("Nuevaautentificacion.php")?>

<?php include("Nuevopie.php")?>
