<?php
session_start();
$sub = (isset($_GET['sub'])) ? $_GET['sub'] : 1;
$nom_pag = $sub;

include_once ("funciones.php");
include_once ("validaciones.php");
include_once ("Nuevacabecera.php");
include_once ("Nuevolateral.php");
?>
<div class='col-md-8 '>
<div class="row justify-content-center">
<?php
$id = ver_idSubcategoria($sub);
ver_subcategorias($id[0],$id[1]);
?>
</div>










</div>


<?php
//include('Nuevocentral.php');




include('Nuevaautentificacion.php');
include('Nuevopie.php');
?>
