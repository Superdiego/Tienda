<?php
$sub = (isset($_GET['sub'])) ? $_GET['sub'] : 1;
$nom_pag = $sub;

include_once ("funciones.php");
include_once ("validaciones.php");
include_once ("cabecera.php");
?>
<div class="row">
<?php
$id = ver_idSubcategoria($sub);
ver_subcategorias($id[0],$id[1]);
?>
</div>
</div>
<div class="col-sm-12 col-md-2">
<?php include ("autentificacion.php")?>
</div>
</div>
</body>
</html>
