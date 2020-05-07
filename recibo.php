<?php
session_start();
$nom_pag = "Gracias por su compra";
include_once("funciones.php");
include_once("validaciones.php");
include_once("Nuevacabecera.php");
include_once("Nuevolateral.php");

$pedido = (isset($_GET['ped'])) ? $_GET['ped'] : null;


?>
<div class='col-md-8')>
<h5 class="text-center">
<?php echo $_SESSION['autenticado'] . ", en pocos dias recibirá su pedido ".$_GET['ped']?></h5>
<br>

<?php mostrar_lineas($pedido)?>

<a href="index.php"><button class="btn btn-primary">Continuar</button></a>

			</div>

			<?php include ("Nuevaautentificacion.php")?>

<?php include("Nuevopie.php")?>

