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

$mensaje='';
$url = (isset($_GET['comienzo'])) ? "?comienzo=".$_GET['comienzo'] : "";

if (isset($_POST['modificar'])) {
    $articulo = buscar_articulo($_POST['id']);
    $id = (isset($_POST['id'])) ? $_POST['id'] : $articulo->getId_art();
    $nom = (isset($_POST['nombre'])) ? $_POST['nombre'] : $articulo->getNom_art();
    $catsubcat = (isset($_POST['catsubcat'])) ? explode(",",$_POST['catsubcat']) : '';
    $cat = $catsubcat[0];
    $subcat = $catsubcat[1];
    $desc = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : $articulo->getDes_art();
    $pre = (isset($_POST['precio'])) ? $_POST['precio'] : $articulo->getPre_art();
    $act = (isset($_POST['activo'])) ? $_POST['activo'] : $articulo->getAct_art();
    $stock = (isset($_POST['stock'])) ? $_POST['stock'] : $articulo->getSto_art();

    if (empty(trim($nom))) {
        $err_nom = "<span class='text-danger'>El campo nombre está vacío</span>";
    } else {
        $err_nom = ! val_texto($nom) ? "<span class='text-danger'>El nombre de empezar con una letra</span>" : '';
    }
    if (empty(trim($desc))) {
        $err_des = "<span class='text-danger'>El campo descripción está vacío</span>";
    } else {
        $err_des = ! val_texto($desc) ? "<span class='text-danger'>El campo descripción debe empezar con una letra</span>" : '';
    }
    if (empty(trim($pre))) {
        $err_pre = "<span class='text-danger'>El campo precio está vacío</span>";
    } else {
        $err_pre = ! is_numeric($pre) ? "<span class='text-danger'>El precio debe ser un número</span>" : '';
    }
    if (empty(trim($act))) {
        $err_act = "<span class='text-danger'>El campo activo está vacío</span>";
    } else {
        $err_act = ! ctype_digit($act) ? "<span class='text-danger'>La actividad debe ser uno o cero</span>" : '';
    }
    $err_stock = (! is_numeric($stock)) ? "<span class='text-danger'>El stock debe ser un número</span>" : '';

    if (val_texto($nom) && val_texto($desc) && is_numeric($pre) && ctype_digit($act) && is_numeric($stock)) {
        $mensaje = modificar_articulo($id, $nom, $cat, $subcat, $desc, $pre, $act, $stock);
    }
}


$datos = mostrar_articulos(1);

?>
<div class="col-md-8">

	<div class='row justify-content-center mt-5'>
		<div class='col-sm-4'></div>
		<div class='col-sm-2'>
			<p><?php echo $datos[2]?></p>
		
		</div>
		<div class='col-sm-2'>
			<p><?php echo $datos[1]?></p>
		</div>
		<div class='col-sm-4'><p class='bg-success text-white text-center'><?php echo $mensaje?></p></div>
	</div>


	<form class='mx-5' method='post' action="adminArtic.php<?php echo $url ?>">

<?php

$articulos = $datos[0];


foreach ($articulos as $artic) {
    $id = $artic->getId_art();
    $nom = (isset($_POST['nombre']))? $_POST['nombre'] : $artic->getNom_art();
    $cat = (isset($_POST['categ'])) ? $_POST['categ'] : $artic->getCat_art();
    $subcat = (isset($_POST['subcateg'])) ? $_POST['subcateg'] : $artic->getSub_art();
    $desc = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : $artic->getDes_art();
    $pre = (isset($_POST['precio'])) ? $_POST['precio'] : $artic->getPre_art();
    $act = (isset($_POST['activo'])) ? $_POST['activo'] : $artic->getAct_art();
    $stock = (isset($_POST['stock'])) ? $_POST['stock'] : $artic->getSto_art();

    echo "<div class='form-group row'><label class='col-sm-2 col-form-label'>Id Articulo:</label><div class='col-sm-10'>
        <input class='form-control' type='text' readonly name='id' value='$id'>";
    echo "</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Nombre:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='nombre' value='$nom'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $err_nom;
        echo "</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Categoria:</label>
        <div class='col-sm-10''><select class='custom-select' name='catsubcat'>";
    $lista = listadesubcategorias();
    foreach ($lista as $sub) {
        echo "<option value='" . $sub[0] . "," . $sub[1] . "'";
        if ($sub[0] == $cat && $sub[1] == $subcat) {
            echo " selected ";
        }
        echo ">" . leer_categoria($sub[0]) . "&nbsp; &nbsp;" . $sub[2] . "</option>";
    }
    echo "</select></div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Descripcion:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='descripcion' value='$desc'>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $err_des;
    echo "</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Precio:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='precio' value='$pre'>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $err_pre;
    echo "</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Activo:</label><div class='col-sm-10'>
        <input class='form-control' type='bool' name='activo' value='$act'>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $err_act;
    echo "</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Stock:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='stock' value='$stock'>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $err_stock;
    echo "</div></div>
        <div class='form-group row'><div class='col-sm-10 text-center'><div class='row'><div class='col-9'>
        <button type='submit' name='modificar' class='btn btn-primary'>Modificar</button></div><div class='col-3'>
        <a href='adminArtic.php$url' class='btn btn-primary'>Cancelar</a></div></div></div></div>";
}

?>




</form>
</div>

<?php include ("Nuevaautentificacion.php")?>
<?php include("Nuevopie.php")?>


?>