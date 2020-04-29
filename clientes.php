<?php
session_start();
$nom_pag= "PAGINA DE ADMINISTRACION";
include_once("funciones.php");
include_once("validaciones.php");


if(!isset($_SESSION['autenticado'])){
    header("location:index.php");
}else{
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if($admin->getRol_usr()!=4 && $admin->getRol_usr()!=3){
        header("location:index.php");
    }
}
include_once("Nuevacabecera.php");
include_once('Nuevolateral.php');

$edicion="";

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
    
    $edicion = editar_usuario($dni, $rol, $nombre, $apellidos, $direccion, $codpostal, $localidad, $provincia, $email,
        $telefono, $password, $activo);
    
}

?>
<div class='col-md-8'>	
	<div class='row'>
		<table class="table table-striped table-responsive">
  <thead >
    <tr><th>ID</th><th class="px-1 mx-1">DNI</th><th>NIC</th><th>NOMBRE</th><th>APELLIDOS</th>
      <th>DIRECCION</th><th class='px-1'>C.POST.</th><th class='px-1'>LOC.</th><th class='px-1'>PROV.</th><th>E-MAIL</th>
      <th class='px-1'>TELEFONO</th><th class='px-1'>PASS</th><th class='px-1'>ACT.</th></tr>
  </thead>
  <tbody>	
<?php mostrar_cliente(5); ?>
  </tbody>
</table>
</form>
</div><div class='container row text-center'><div class='col-12'><p class=' text-success'><?php echo $edicion ?></p></div></div></div>
<?php 		
include('Nuevaautentificacion.php');
include('Nuevopie.php');

?>
