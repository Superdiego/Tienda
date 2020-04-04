<?php
$nom_pag = "Inicio";

include("cabecera.php");

include("funciones.php");

?>

<div class="container text-center mt-4"><h1><?php echo $nom_pag ?></h1></div>
	
	<div class="container-fluid">
		<div class="row text-center">
			<div class="col-sm-12 col-md-2"></div>
			<div class="col-sm-12 col-md-8 py-5">
					<?php 
					mostrar_articulos();
					?>
			</div>
			<div class="col-sm-12 col-md-2"></div>
		</div>
	</div>
</body>
</html>
