<?php
$nom_pag = "Inicio";
include("cabecera.php");
include("funciones.php");
?>
	<div class="row">
		<div class="col-sm-12 col-md-4"></div>
		<div class="col-sm-12 col-md-2 text-center">
			<a href="registroClientes.php">Nuevo cliente</a>
		</div>
		<div class="col-sm-12 col-md-2 text-center">
			<a href="registroCategorias.php">Nueva categoria</a>
		</div>
		<div class="col-sm-12 col-md-2 text-center">
			<a href="registroSubcategorias.php">Nueva subcategoria</a>
		</div>
		<div class="col-sm-12 col-md-2 text-center">
			<a href="registroArticulos.php">Nuevo articulo</a>
		</div>
	</div>

	<br>
	<br>
	<?php mostrar_articulos(); ?>
	<br>


</body>

</html>