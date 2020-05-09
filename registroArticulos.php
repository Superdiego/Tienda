<?php
session_start();
$nom_pag = "ALTA ARTICULOS";
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

$nom = (isset($_POST['nombre'])) ? $_POST['nombre'] : null;
$catsubcat = (isset($_POST['catsubcat'])) ? explode(",", $_POST['catsubcat']) : null;
$cat = (isset($_POST['catsubcat'])) ? $catsubcat[0] : null;
$sub = (isset($_POST['catsubcat'])) ? $catsubcat[1] : null;
$desc = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : null;
$pre = (isset($_POST['precio'])) ? $_POST['precio'] : null;
$act = (isset($_POST['activo'])) ? $_POST['activo'] : 1;
$stock = 0;

$err_nom = null;
$err_catsubcat = null;
$err_des = null;
$err_pre = null;
$err_act = null;
$err_stock = null;
$mensaje = null;


if(isset($_GET['ok'])){
    $mensaje = "Artículo grabado correctamente";
}

if (isset($_POST['alta'])) {
    if (empty(trim($nom))) {
        $err_nom = "<span class='text-danger'>El campo nombre está vacío</span>";
    } else {
        $err_nom = ! val_texto($nom) ? "<span class='text-danger'>El nombre debe empezar con una letra</span>" : '';
    }
    $err_catsubcat = empty($catsubcat) ? "<span class='text-danger'>Debe seleccionar una categoría y subcategoría</span>" : '';
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
    if (empty(trim($act)) && trim($act)!=0) {
        $err_act = "<span class='text-danger'>El campo activo está vacío</span>";
    } else if (! ctype_digit($act)) {
        $err_act = "<span class='text-danger'>El campo activo debe ser un número</span>";
    }else{
        $err_act = ($act!= 1 && $act!=0) ? "<span class='text-danger'>La actividad debe ser uno o cero</span>" : '';
    }
    $err_stock = (! is_numeric($stock)) ? "<span class='text-danger'>El stock debe ser un número</span>" : '';
    
    if (val_texto($nom) && ctype_digit($cat) && ctype_digit($sub) && val_texto($desc) && is_numeric($pre) && ctype_digit($act) && is_numeric($stock)) {
        registrar_articulos($nom, $cat, $sub, $desc, $pre, $act, $stock);
        foreach ($_POST as $nombre=>$valor){
            $nombre = null;
        }
        header("location:registroArticulos.php?ok=alta");
    }
    if (isset($_FILES["foto"]) && $_FILES["foto"]["size"] > 0) {
        if ($_FILES["foto"]["size"] > 400000) {
            echo "Archivo demasiado grande";
        } else {
            $temporal = $_FILES["foto"]["tmp_name"];
            $imagen = getimagesize($temporal);
            if ($imagen[0] == 300 && $imagen[1] == 300) {
                $destino = "imgProductos/" . $_FILES["foto"]["name"];
                if (move_uploaded_file($temporal, $destino)) {
                    echo "Imagen subida a servidor";
                } else {
                    echo "Error en la subida de la imagen";
                }
            } else {
                echo "La imagen no tiene las medidas o el formato correcto";
            }
        }
    }
}
include ('Nuevacabecera.php');
include ('Nuevolateral.php');
?>
<div class="col-md-8">

	<h5 class='text-center text-success'><?php echo $mensaje ?></h5>
	<form method='post' action='registroArticulos.php' class='px-5'>
		<br>
		<div class='form-group row'>
			<label class='col-sm-2 col-form-label'>Nombre:</label>
			<div class='col-sm-10'>
				<input class='form-control' type='text' name='nombre'
					value='<?php echo "$nom'> $err_nom" ?>
			</div>
			
		</div>
			<div class='form-group row'>
			<label class='col-sm-2 col-form-label'>Categoria:</label>
			<div class='col-sm-10''>
				<select class='custom-select' name='catsubcat'>";
<?php
$lista = listadesubcategorias();
if (! $_POST['catsubcat']) {
    echo "<option disabled selected>'Elija categoria - subcategoria'</option>";
}
foreach ($lista as $subcat) {
    echo "<option value='" . $subcat[0] . "," . $subcat[1] . "' ";
    if (($subcat[0] == $cat) && ($subcat[1] == $sub)) {
        echo "selected ";
    }
    echo ">" . leer_categoria($subcat[0]) . "&nbsp; &nbsp;" . $subcat[2] . "</option>";
}
echo "</select>$err_catsubcat</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Descripcion:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='descripcion' value='$desc'>$err_des</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Precio:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='precio' value='$pre'>$err_pre</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Activo:</label><div class='col-sm-10'>
        <input class='form-control' type='bool' name='activo' value='$act'>$err_act</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Stock:</label><div class='col-sm-10'>
        <input class='form-control' type='text' readonly name='stock' value='$stock'>$err_stock</div></div>
        <div class='form-group row'><label class='col-sm-5 col-form-label text-center'>Imagen (300px x 300px JPG):</label><div class='col-sm-7'>
        <input class='form-control' type='file' name='foto'></div></div>
        <br>
        <div class='form-group row'><div class='col-9 text-center'>
        <button type='submit' name='alta' class='btn btn-primary'>Alta artículo</button></div><div class='col-3'>
        <a href='registroArticulos.php' class='btn btn-primary'>Cancelar</a></div></div>"?>


	
	</form>

</div>



<?php include ("Nuevaautentificacion.php")?>
<?php include("Nuevopie.php")?>




