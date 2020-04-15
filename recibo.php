<?php
$nom_pag = "Gracias por su compra";
include_once("funciones.php");
include_once("validaciones.php");
include_once("cabecera.php");
?>

<h5 class="text-center">
<?php echo $_SESSION['autenticado'] . ", en pocos dias recibira su pedido ".$_GET['ped']?></h5>
<a href="index.php"><button class="btn btn-primary">Continuar</button></a>

			</div>
			<div class="col-md-2">
			<?php include ("autentificacion.php")?>
			</div>
		</div>
	</div>
</body>
</html>
