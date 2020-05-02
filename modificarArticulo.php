<?php
session_start();
include_once("funciones.php");
include_once("validaciones.php");
if (! isset($_SESSION['autenticado'])) {
    header("location:index.php");
} else {
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if (($admin->getRol_usr() != 4) && ($admin->getRol_usr() != 3)) {
        header("location:index.php");
    }
}

include_once("funciones.php");
include_once("validaciones.php");
$nom_pag = "Almacén";
include('Nuevacabecera.php');
include('Nuevolateral.php');


echo "<div class='col-md-8'>";

$mensaje='';
$url = (isset($_GET['comienzo'])) ? "?comienzo=".$_GET['comienzo'] : "";
$err_nom = "";
$err_des = "";
$err_pre = "";
$err_act = "";
$err_stock = "";
    
if (isset($_POST['editar']) || isset($_POST['revisar'])) {
    $id = $_POST['idart'];
    $articulo = buscar_articulo($_POST['idart']);
    $nom = (isset($_POST['nombre'])) ? $_POST['nombre'] : $articulo->getNom_art();
    $catsubcat = (isset($_POST['catsubcat'])) ? explode(",",$_POST['catsubcat']) : '';
    $cat = (isset($_POST['catsubcat'])) ? $catsubcat[0]: $articulo->getCat_art() ;
    $subcat = (isset($_POST['catsubcat'])) ? $catsubcat[1]: $articulo->getSub_art();
    $desc = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : $articulo->getDes_art();
    $pre = (isset($_POST['precio'])) ? $_POST['precio'] : $articulo->getPre_art();
    $act = (isset($_POST['activo'])) ? $_POST['activo'] : $articulo->getAct_art();
    $stock = (isset($_POST['stock'])) ? $_POST['stock'] : $articulo->getSto_art();
}
if (isset($_POST['modificar'])){
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
    } else if (!ctype_digit($act)){
        $err_act ="<span class='text-danger'>La actividad debe ser un número</span>";
    }else{
        $err_act = (($act)!=0 && ($act)!=1) ? "<span class='text-danger'>La actividad debe ser 1 (activado) o cero (desactivado)</span>" : '';
    }
    $err_stock = (! is_numeric($stock)) ? "<span class='text-danger'>El stock debe ser un número</span>" : '';
    
    if (empty($err_nom) && empty($err_des) && empty($err_pre) && empty($err_act) && empty($err_stock)) {
        $mensaje = modificar_articulo($id, $nom, $cat, $subcat, $desc, $pre, $act, $stock);
    }
    
}
?>
<div class='row justify-content-center mt-5'>
<div class='col-sm-4'></div>

		<div class='col-sm-4'><p class='bg-success text-white text-center'><?php echo $mensaje?></p></div>
	</div>


	<form class='mx-5' method='post' action="adminArtic.php<?php echo $url ?>">

<?php






    echo "<div class='form-group row'><label class='col-sm-4 col-form-label text-right'>Id Articulo:</label><div class='col-sm-5'>
        <input class='form-control' type='text' readonly name='id' value='$id'>";
    echo "</div></div>
        <div class='form-group row'><label class='col-sm-4 col-form-label text-right'>Nombre:</label><div class='col-sm-5'>
        <input class='form-control' type='text' name='nombre' value='$nom'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $err_nom;
        echo "</div></div>
        <div class='form-group row'><label class='col-sm-4 col-form-label text-right'>Categoria:</label>
        <div class='col-sm-5'><select class='custom-select' name='catsubcat'>";
    $lista = listadesubcategorias();
    foreach ($lista as $sub) {
        echo "<option value='" . $sub[0] . "," . $sub[1] . "'";
        if ($sub[0] == $cat && $sub[1] == $subcat) {
            echo " selected ";
        }
        echo ">" . leer_categoria($sub[0]) . "&nbsp; &nbsp;" . $sub[2] . "</option>";
    }
    echo "</select></div></div>
        <div class='form-group row'><label class='col-sm-4 col-form-label text-right'>Descripcion:</label><div class='col-sm-5'>
        <input class='form-control' type='text' name='descripcion' value='$desc'>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $err_des;
    echo "</div></div>
        <div class='form-group row'><label class='col-sm-4 col-form-label text-right'>Precio:</label><div class='col-sm-5'>
        <input class='form-control' type='text' name='precio' value='$pre'>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $err_pre;
    echo "</div></div>
        <div class='form-group row'><label class='col-sm-4 col-form-label text-right'>Activo:</label><div class='col-sm-5'>
        <input class='form-control' type='bool' name='activo' value='$act'>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $err_act;
    echo "</div></div>
        <div class='form-group row'><label class='col-sm-4 col-form-label text-right'>Stock:</label><div class='col-sm-5'>
        <input class='form-control' type='text' name='stock' value='$stock' readonly>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $err_stock;
    echo "</div></div>
        <div class='form-group row'><div class='col-sm-10 text-center'><div class='row mt-4'><div class='col-6'>
        <button type='submit' name='modificar' class='btn btn-primary'>Modificar</button></div><div class='col-6'>
        <a href='adminArtic.php$url' class='btn btn-primary'>Cancelar</a>
        <a href='index.php' class='btn btn-primary'>Salir</a></div></div></div></div>";



?>

		


</form>
    
    
    
    
    
    
  

</div>


<?php
include('Nuevaautentificacion.php');
include('Nuevopie.php');
?>