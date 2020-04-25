<?php
session_start();
$nom_pag = "Gracias por su compra";
include_once("funciones.php");
include_once("validaciones.php");
include_once("cabecera.php");

$pedido = (isset($_GET['ped'])) ? $_GET['ped'] : null;


?>

<h5 class="text-center">
<?php echo $_SESSION['autenticado'] . ", en pocos dias recibira su pedido ".$_GET['ped']?></h5>
<br>

<?php mostrar_lineas($pedido)?>

<a href="index.php"><button class="btn btn-primary">Continuar</button></a>

			</div>
			<div class="col-md-2">
			<?php include ("autentificacion.php")?>

<?php include("Nuevopie.php")?>

