<?php
session_start();
$nom_pag = "EDICION ARTICULOS";
include_once ("funciones.php");
include_once ("validaciones.php");

if (! isset($_SESSION['autenticado'])) {
    header("location:index.php");
} else {
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if (($admin->getRol_usr() != 4) && ($admin->getRol_usr() != 3)) {
        header("location:index.php");
    }
}

include ('Nuevacabecera.php');
include ('Nuevolateral.php');


$datos = mostrar_articulos(5);

?>
<div class="col-md-8">
	<div class='row  mt-3'>
	<div class='table-responsive'>
		<table class="table table-striped table-responsive">
			<thead>
				<tr>
					<th>Id.Art.</th>
					<th class="px-1 mx-1">Nombre</th>
					<th>Categoría</th>
					<th>Descripción</th>
					<th>Precio</th>
					<th>Activo</th>
					<th>Stock</th>
				</tr>
			</thead>
			<tbody>
				
  
<?php

$articulos = $datos[0];

foreach ($articulos as $artic) {
    $idart = $artic->getId_art();
    $nom = (isset($_POST['nombre'])) ? $_POST['nombre'] : $artic->getNom_art();
    $cat = (isset($_POST['categ'])) ? $_POST['categ'] : $artic->getCat_art();
    $subcat = (isset($_POST['subcateg'])) ? $_POST['subcateg'] : $artic->getSub_art();
    $desc = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : $artic->getDes_art();
    $pre = (isset($_POST['precio'])) ? $_POST['precio'] : $artic->getPre_art();
    $act = (isset($_POST['activo'])) ? $_POST['activo'] : $artic->getAct_art();
    $stock = (isset($_POST['stock'])) ? $_POST['stock'] : $artic->getSto_art();

    echo "<form method='POST' action='edicionArticulos.php'><tr><th class='px-0' scope='row'>
        <input class='form-control' type='text' readonly name='idart' value='$idart'>
        </th><td width='20%' class='px-0'>
        <input class='form-control' type='text' readonly name='nombre' value='$nom'>
        </td><td class='px-0' width='25%'>
        <select class='custom-select' readonly name='catsubcat'>";
    $lista = listadesubcategorias();
    foreach ($lista as $sub) {
        echo "<option value='" . $sub[0] . "," . $sub[1] . "'";
        if ($sub[0] == $cat && $sub[1] == $subcat) {
            echo " selected ";
        }else{
            echo " disabled ";
        }
        echo ">" . leer_categoria($sub[0]) . "&nbsp; &nbsp;" . $sub[2] . "</option>";
    }
    echo "</th><td class='px-0'>
        <input class='form-control' type='text' readonly name='precio' value='$pre'>
        </td><td class='px-0'>
        <input class='form-control' type='text' readonly name='activo' value='$act'>
        </td><td class='px-0'>
        <input class='form-control' type='text' readonly name='stock' value='$stock' readonly>
        <input type='hidden' name='descripcion' value='$desc'>
        </td><td class='px-0'>
        <button type='submit' name='editar' readonly class='btn btn-primary'>Editar</button>
        </td></form>";
}

?>
</tbody></table></div></div>
<div class='row mt-2 '>
<div class='col-md-6 justify-content-center'>
<p class='text-right'><?php echo $datos[2]?></p></div>
<div class='col-md-6 justify-content-center'>
<p class='text-left'><?php echo $datos[1]?></p></div>


</div>
</div>
<?php include ("Nuevaautentificacion.php")?>
<?php include("Nuevopie.php")?>


   


?>