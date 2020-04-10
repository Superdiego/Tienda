<?php
include_once("funciones.php");
$id_pag = (isset($_GET['art'])) ? $_GET['art'] : null;
$producto = buscar_articulo($id_pag);
$nom_pag = $producto->getNom_art();
include("cabecera.php");   
?>
<div class="container-fluid">
<img src="imgProductos/<?php echo $id_pag?>.jpg">
<h3 class="text-center py-5 text-success"><?php echo $producto->getPre_art()?>&nbsp;Eur</h3>
<p><?php echo $producto->getDes_art();?></p>

</div></div></div>

			<div class="col-sm-12 col-md-2">
			<?php include ("autentificacion.php")?>
			</div>
		</div>

</body>
</html>