<?php
session_start();
$nom_pag= "EDICION ARTICULOS";
include_once("funciones.php");
include_once("validaciones.php");

if(!isset($_SESSION['autenticado'])){
    header("location:index.php");
}else{
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if(($admin->getRol_usr()!=4) && ($admin->getRol_usr()!=3)){
        header("location:index.php");
    }
}

include('cabecera.php');

if(isset($_POST['modificar'])){
    $id = (isset($_POST['id']) && ctype_digit($_POST['id'])) ? $_POST['id'] : null;
    $nom = (isset($_POST['nombre']) && val_texto($_POST['nombre'])) ? $_POST['nombre'] : null;
    $catsubcat = (isset($_POST['catsubcat'])) ? explode(",",$_POST['catsubcat']) : null;
    $cat = $catsubcat[0];
    $sub = $catsubcat[1];
    $desc = (isset($_POST['descripcion']) && val_texto($_POST['descripcion'])) ? $_POST['descripcion'] : null;
    $pre = (isset($_POST['precio']) && is_numeric($_POST['precio'])) ? $_POST['precio'] : null;
    $act = (isset($_POST['activo']) && ctype_digit($_POST['activo'])) ? $_POST['activo'] : null;
    $stock = (isset($_POST['activo']) && is_numeric($_POST['stock'])) ? $_POST['activo'] : null;
    
    modificar_articulo($id,$nom,$cat,$sub, $desc, $pre, $act, $stock);
}


$datos = mostrar_articulos(1);
?>
<div class='row'>
<div class='col-sm-4'></div>
<div class='col-sm-2 text-center'><p><?php echo $datos[1]?><p></div>
<div class='col-sm-2 text-center'><p><?php echo $datos[2]?></p></div>
<div class='col-sm-4'></div>
</div>
<div class='mx-auto px-5'><form method='post' action='adminArtic.php' class='px-5'>

<?php

$articulos = $datos[0];

$err_id = null;
$err_nom = null;
$err_cat = null;
$err_sub = null;
$err_des = null;
$err_pre = null;
$err_act = null;
$err_stock = null;



//$artic = buscar_articulo($_POST['id']);

foreach($articulos as $artic){
    $id = $artic->getId_art();
    $nom = (isset($_POST['nombre']) && val_texto($_POST['nombre'])) ? $_POST['nombre'] : $artic->getNom_art();
    $cat = (isset($_POST['categ']) && ctype_digit($_POST['categ'])) ? $_POST['categ'] : $artic->getCat_art();
    $subcat = (isset($_POST['subcateg']) && ctype_digit($_POST['subcateg'])) ? $_POST['subcateg'] : $artic->getSub_art();
    $desc = (isset($_POST['descripcion']) && val_texto($_POST['descripcion'])) ? $_POST['descripcion'] : $artic->getDes_art();
    $pre = (isset($_POST['precio']) && is_numeric($_POST['precio'])) ? $_POST['precio'] : $artic->getPre_art();
    $act = (isset($_POST['activo']) && is_bool($_POST['activo'])) ? $_POST['activo'] : $artic->getAct_art();
    $stock = (isset($_POST['activo']) && is_numeric($_POST['stock'])) ? $_POST['activo'] : $artic->getSto_art();
    
    
    echo "<div class='form-group row'><label class='col-sm-2 col-form-label'>Id Articulo:</label><div class='col-sm-10'>
        <input class='form-control' type='text' readonly name='id' value='$id'>$err_id</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Nombre:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='nombre' value='$nom'>$err_nom</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Categoria:</label>
        <div class='col-sm-10''><select class='custom-select' name='catsubcat'>";
    $lista = listadesubcategorias();
    foreach($lista as $sub){
            echo "<option value='".$sub[0].",".$sub[1]."'";
            if($sub[0]==$cat && $sub[1]==$subcat){echo " selected ";}
            echo ">".leer_categoria($sub[0])."&nbsp; &nbsp;".$sub[2]."</option>";
    }
    echo "</select></div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Descripcion:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='descripcion' value='$desc'>$err_des</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Precio:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='precio' value='$pre'>$err_pre</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Activo:</label><div class='col-sm-10'>
        <input class='form-control' type='bool' name='activo' value='$act'>$err_act</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Stock:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='stock' value='$stock'>$err_stock</div></div>
        <div class='form-group row'><div class='col-sm-10'>
        <button type='submit' name='modificar' class='btn btn-primary'>Modificar</div></div>";
}
?>

</form>

</div><?php
if ($admin->getRol_usr() == 4) {
    echo "<div class='text-center py-2'><a href='administrador.php'>Menu administrador</a></div>";
}

if ($admin->getRol_usr() == 3) {
    echo "<div class='text-center py-2'><a href='empleado.php'>Menu empleado</a></div>";
}

?></div>
			<div class="col-md-2">
			<?php include ("autentificacion.php")?>
			</div>
</div>
</div>
<?php include("pie.php")?>
</body>
</html>

?>