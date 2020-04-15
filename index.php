<?php
$nom_pag = "Inicio";
include_once("funciones.php");
include_once("validaciones.php");
include_once("cabecera.php");
?>
<div class="row">

<?php mostrar_articulos();?>
</div>
</div>
			<div class="col-md-2">
			<?php include ("autentificacion.php")?>
			</div>
		</div>
	</div>
</body>
</html>
