<?php
session_start();
include_once('funciones.php');
if(!isset($_SESSION['autenticado'])){
    header("location:index.php");
}else{
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if($admin->getRol_usr()!=4){
        header("location:index.php");
    }
}


if(isset($_REQUEST['nic']) && $_REQUEST['nic'] != ""){

$usuario = datos_usuario($_POST['nic']);
$id = (isset($_POST['id'])) ? $_POST['id'] :  $usuario->getId_usr();
$dni = (isset($_POST['dni'])) ? $_POST['dni'] :  $usuario->getDni_usr();
$nick = (isset($_POST['nic'])) ? $_POST['nic'] :  $usuario->getNic_usr();
$rol = (isset($_POST['rol'])) ? $_POST['rol'] :  $usuario->getRol_usr();
$nombre = (isset($_POST['nom'])) ? $_POST['nom'] :  $usuario->getNom_usr();
$apellidos = (isset($_POST['ape'])) ? $_POST['ape'] :  $usuario->getApe_usr();
$direccion = (isset($_POST['dir'])) ? $_POST['dir'] :  $usuario->getDir_usr();
$codpostal = (isset($_POST['cop'])) ? $_POST['cop'] :  $usuario->getDir_usr();
$localidad = (isset($_POST['loc'])) ? $_POST['loc'] :  $usuario->getLoc_usr();
$provincia = (isset($_POST['pro'])) ? $_POST['pro'] : $usuario->getPro_usr();
$email = (isset($_POST['ema'])) ? $_POST['ema'] :  $usuario->getEma_usr();
$telefono = (isset($_POST['tel'])) ? $_POST['tel'] :  $usuario->getTel_usr();
$password = (isset($_POST['pas'])) ? $_POST['pas'] :  $usuario->getPas_usr();
$activo = (isset($_POST['act'])) ? $_POST['act'] :  $usuario->getAct_usr();

editar_usuario($dni, $rol, $nombre, $apellidos, $direccion, $codpostal, $localidad, $provincia, $email,
                $telefono, $password, $activo);

}

?>
<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="bootstrap/bootstrap.css">
<!--  <link rel="stylesheet" type="text/css" href="estilo.css"> -->
<title>Cachivaches</title>

</head>
<body>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
		integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
		crossorigin="anonymous"></script>
	<script
		src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
		integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
		crossorigin="anonymous"></script>
	<script src="bootstrap/bootstrap.js"></script>

	<div class="container-fluid bg-primary">
		<div class="container-fluid text-white pt-5 pb-1">
			<h1 class="display-4">Cachivaches</h1>
		</div></div>
		<h1 class="text-center py-5">ADMINISTRACION USUARIOS</h1>

		<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">DNI</th>
      <th scope="col">NIC</th>
      <th scope="col">ROL</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">APELLIDOS</th>
      <th scope="col">DIRECCION</th>
      <th scope="col">C.POSTAL</th>
      <th scope="col">LOCALIDAD</th>
      <th scope="col">PROVINCIA</th>
      <th scope="col">E-MAIL</th>
      <th scope="col">TELEFONO</th>
      <th scope="col">PASSWORD</th>
      <th scope="col">ACTIVO</th>    
    </tr>
  </thead>
  <tbody>	
<?php mostrar_usuario(); ?>
  </tbody>
</table>

</form>
		
		<div class="text-center">
<a href="administrador.php" >Volver menu administrador</a>
</div>
		