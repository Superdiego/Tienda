<?php
session_start();
$nom_pag= "ALTA ARTICULOS";
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

//$datos = mostrar_articulos(1);
?>
<div class='row'>
<div class='col-sm-4'></div>
<div class='col-sm-2 text-center'><p><p></div>
<div class='col-sm-2 text-center'></p></div>
<div class='col-sm-4'></div>
</div>
<div class='mx-auto px-5'><form method='post' action='registroArticulos.php' class='px-5'>

<?php

//$articulos = $datos[0];

$err_id = null;
$err_nom = null;
$err_cat = null;
$err_sub = null;
$err_des = null;
$err_pre = null;
$err_act = null;
$err_stock = null;

//foreach($articulos as $artic){
    //$id = $artic->getId_art();
    $nom = (isset($_POST['nombre'])) ? $_POST['nombre'] : null;
    //$cat = (isset($_POST['categ'])) ? $_POST['categ'] : null;
    //$subcat = (isset($_POST['subcateg'])) ? $_POST['subcateg'] : null;
    $catsubcat = (isset($_POST['catsubcat'])) ? explode(",",$_POST['catsubcat']) : null;
    $cat = (isset($_POST['catsubcat'])) ? $catsubcat[0] : null;
    $sub = (isset($_POST['catsubcat'])) ? $catsubcat[1] : null;
    $desc = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : null;
    $pre = (isset($_POST['precio'])) ? $_POST['precio'] : null;
    $act = (isset($_POST['activo'])) ? $_POST['activo'] : 1;
    $stock = (isset($_POST['activo'])) ? $_POST['activo'] : null;
        
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $err_nom = !val_texto($nom) ? "<span class='error'>Introduzca un nombre</span>" : '';
        $err_cat = is_null($catsubcat) ? "<span class='error'>Seleccione categoria-subcategoria</span>" : '';
        $err_des = !val_texto($desc) ? "<span class='error'>Introduzca una descripcion</span>" : '';
        $err_pre = !is_numeric($pre) ? "<span class='error'>Introduzca un precio</span>" : '';
        $err_act = !ctype_digit($act) ? "<span class='error'>Introduzca su modo de actividad</span>" : '';
        
        if (val_texto($nom) && ctype_digit($cat) && ctype_digit($sub) && val_texto($desc)
            && is_numeric($pre) && ctype_digit($act) && is_numeric($stock)) {
            registrar_articulos($nom, $cat, $sub, $desc, $pre, $act, $stock);
        }
        if(isset($_FILES["foto"]) && $_FILES["foto"]["size"]>0){
            if ($_FILES["foto"]["size"]>400000){
                echo "Archivo demasiado grande";
            }else {
                $temporal = $_FILES["foto"]["tmp_name"];
                $imagen = getimagesize($temporal);
                if($imagen[0]==300 && $imagen[1]==300){
                    $destino = "imgProductos/" . $_FILES["foto"]["name"];
                    if (move_uploaded_file($temporal, $destino)) {
                        echo "Imagen subida a servidor";
                    } else {
                        echo "Error en la subida de la imagen";
                    }
                }else{
                    echo "La imagen no tiene las medidas o el formato correcto";
                }
            }
        }
}

    
    
    echo "<br><div class='form-group row'><label class='col-sm-2 col-form-label'>Nombre:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='nombre' value='$nom'>$err_nom</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Categoria:</label>
        <div class='col-sm-10''><select class='custom-select' name='catsubcat'>
        <option disabled selected>'Elija categoria - subcategoria'</option>";
    $lista = listadesubcategorias();
    foreach($lista as $sub){
        echo "<option value='".$sub[0].",".$sub[1]."'>".leer_categoria($sub[0])."&nbsp; &nbsp;".$sub[2]."</option>";
    }
    echo "</select>$err_cat</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Descripcion:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='descripcion' value='$desc'>$err_des</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Precio:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='precio' value='$pre'>$err_pre</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Activo:</label><div class='col-sm-10'>
        <input class='form-control' type='bool' name='activo' value='$act'>$err_act</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Stock:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='stock' value='$stock'>$err_stock</div></div>
        <div class='form-group row'><label class='col-sm-5 col-form-label text-center'>Imagen (300px x 300px JPG):</label><div class='col-sm-7'>
        <input class='form-control' type='file' name='foto'></div></div>
        <br>
        <div class='form-group row'><div class='col-sm-10'>
        <button type='submit' name='alta' class='btn btn-primary text-right py-2'>Alta de articulo</div></div>";
?>

</form>

</div><?php
if ($admin->getRol_usr() == 4) {
    echo "<div class='text-right py-2'><a href='administrador.php'>Menu administrador</a></div>";
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


