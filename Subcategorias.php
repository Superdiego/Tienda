<?php
session_start();
$sub = (isset($_GET['sub'])) ? $_GET['sub'] : 1;
$nom_pag = $sub;


//Guardamos nombre de la pagina para control.php
$host= $_SERVER["HTTP_HOST"];
$url= $_SERVER["REQUEST_URI"];
$direccion = "http://$host$url ";
setcookie('pagina', $direccion, time() +  24 * 60 * 60);

 




include_once("funciones.php");
include_once("validaciones.php");
include_once("cabecera.php");

$id = ver_idSubcategoria($sub);
ver_subcategorias($id);
?>
			</div>
			</div>
			<div class="col-sm-12 col-md-2">
			<?php include ("autentificacion.php")?>
			</div>
		</div>
	</div>
</body>
</html>
