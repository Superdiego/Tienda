<?php
session_start();

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


$idart = (isset($_REQUEST['idart'])) ? $_REQUEST['idart'] : null;
$art = buscar_articulo($idart);
$nom = (isset($_POST['nombre'])) ? $_POST['nombre'] : $art->getNom_art();
$msg_img = "";







$catsubcat = (isset($_POST['catsubcat'])) ? explode(",", $_POST['catsubcat']) : '';
$categoria = (isset($_POST['catsubcat'])) ? $catsubcat[0] : $art->getCat_art();
$subcategoria = (isset($_POST['catsubcat'])) ? $catsubcat[1] : $art->getSub_art();

$descrip = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : $art->getDes_art();
$pre = (isset($_POST['precio'])) ? $_POST['precio'] : $art->getPre_art();
$act = (isset($_POST['activo'])) ? $_POST['activo'] : $art->getAct_art();
$stock = $art->getSto_art();

$nom_pag = $nom;
$esconder='';


$err_nom = null;
$err_catsubcat = null;
$err_des = null;
$err_pre = null;
$err_act = null;
$err_stock = null;
$mensaje = null;

if (isset($_GET['ok'])) {
    $mensaje = "Artículo modificado correctamente";
}

if(isset($_POST['bajart'])){
    $esconder = "style='display:none'";
}

if(isset($_POST['confbajart'])){
    baja_articulo($idart);
    header('location:adminArtic.php');
}



if (isset($_POST['modificar'])) {
    if (empty(trim($nom))) {
        $err_nom = "<span class='text-danger'>El campo nombre está vacío</span>";
    } else {
        $err_nom = ! val_texto($nom) ? "<span class='text-danger'>El nombre debe empezar con una letra</span>" : '';
    }
    $err_catsubcat = empty($catsubcat) ? "<span class='text-danger'>Debe seleccionar una categoría y subcategoría</span>" : '';
    if (empty(trim($descrip))) {
        $err_des = "<span class='text-danger'>El campo descripción está vacío</span>";
    } else {
        $err_des = ! val_texto($descrip) ? "<span class='text-danger'>El campo descripción debe empezar con una letra</span>" : '';
    }
    if (empty(trim($pre))) {
        $err_pre = "<span class='text-danger'>El campo precio está vacío</span>";
    } else {
        $err_pre = ! is_numeric($pre) ? "<span class='text-danger'>El precio debe ser un número</span>" : '';
    }
    if (empty(trim($act))) {
        $err_act = "<span class='text-danger'>El campo activo está vacío</span>";
    } else if (! ctype_digit($act)) {
        $err_act = "<span class='text-danger'>El campo activo debe ser un número</span>";
    } else {
        $err_act = ($act != 1 && $act != 0) ? "<span class='text-danger'>La actividad debe ser uno o cero</span>" : '';
    }
  
    if (isset($_FILES["foto"]) && $_FILES["foto"]["size"] > 0) {
        if ($_FILES["foto"]["size"] > 50000) {
            $msg_img = "Archivo de imagen demasiado grande";
        } else {
            $temporal = $_FILES["foto"]["tmp_name"];
            $imagen = getimagesize($temporal);
            if($imagen[2]!=2){
                $msg_img =  "La imagen no tiene el formato correcto";
            }else if($imagen[0] != 300 || $imagen[1] != 300){
                $msg_img =  "La imagen no tiene las medidas correctas";
            }else{
                $destino = "imgProductos/" . $_FILES["foto"]["name"];
                if (move_uploaded_file($temporal, $destino)) {
                    $msg_img =  "";
                } else {
                    $msg_img =  "Error en la subida de la imagen";
                }
            }
        }
    }

     if (empty($err_nom) && empty($err_catsubcat) && empty($err_des) && empty($err_pre) &&
         empty($err_act) && empty($msg_img)) {
        modificar_articulo($idart, $nom, $categoria, $subcategoria, $descrip, $pre, $act);
        header("location:edicionArticulos.php?idart=$idart&ok=modif");
    }
    
}
$nom_pag = "Edición artículo: $nom";
include ('Nuevacabecera.php');
include ('Nuevolateral.php');


?>
<div class="col-md-8">
	<div class='row '<?php echo $esconder?>>
		<div class='col-md-9'>

			<h5 class='text-center text-success'><?php echo $mensaje ?></h5>
			<h5 class='text-center text-success'><?php echo $msg_img ?></h5>
			<form method='post' action='edicionArticulos.php' enctype="multipart/form-data">
				<br>
				<div class='form-group row'>
					<label class='col-sm-2 col-form-label'>Id.Artículo:</label>
					<div class='col-sm-10'>
						<input class='form-control' type='text' readonly name='idart'
							value='<?php echo $idart?>'>
					</div>

				</div>
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

foreach ($lista as $subcat) {
    echo "<option value='" . $subcat[0] . "," . $subcat[1] . "' ";
    if ($subcat[0] == $categoria && $subcat[1] == $subcategoria) {
        echo " selected ";
    }
    echo ">" . leer_categoria($subcat[0]) . "&nbsp; &nbsp;" . $subcat[2] . "</option>";
}
echo "</select>$err_catsubcat</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Descripcion:</label><div class='col-sm-10'>
        <input class='form-control'  type='text' name='descripcion' value='$descrip' >$err_des</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Precio:</label><div class='col-sm-10'>
        <input class='form-control' type='text' name='precio' value='$pre'>$err_pre</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Activo:</label><div class='col-sm-10'>
        <input class='form-control' type='bool' name='activo' value='$act'>$err_act</div></div>
        <div class='form-group row'><label class='col-sm-2 col-form-label'>Stock:</label><div class='col-sm-10'>
        <input class='form-control' type='text' readonly name='stock' value='$stock'>$err_stock</div></div>
        <div class='form-group row'><label class='col-sm-5 col-form-label text-center'>Imagen (300px x 300px JPG):</label><div class='col-sm-7'>
        <input class='form-control' type='file' name='foto'></div>
        </div><p class='text-center text-danger'></p><br>       
        <div class='form-group row'><div class='col-9 text-center'>
        <button type='submit' name='modificar' class='btn btn-primary'>Modificar artículo</button></form></div><div class='col-3'>
        <a href='adminArtic.php' class='btn btn-primary'>Cancelar</a></div></div>";
?>


	
	
			
			
		</div>
		

		
		
		
		
		<div class='col-md-3 justify-content-center'>
			<img src="imgProductos/<?php echo $idart?>.jpg" class='img-fluid '>
			
<?php 
    if (($admin->getRol_usr() == 4)) {
       echo "<div class='row mt-5 justify-content-center'>
			<form method='POST' action='edicionArticulos.php'>
                <input type='hidden' name='idart' value=$idart>
				<input type='submit' class='btn btn-danger' value='Baja artículo' name='bajart'>
			</form>		
		</div>";
    }

?>


		
		</div>

	</div>

		<?php 
if(isset($_POST['bajart'])){
    if (($admin->getRol_usr() == 4)) {
        echo "<div class='row justify-content-center m-5'>
            <div class='col-md-9'>
            <div class='row justify-content-center'>
            <h4>NO es recomendable eliminar articulos</h4>
            </div>
            <div class='row justify-content-center'>
            <h5>¿Está seguro de querer eliminar $nom?</h5>
            </div>
            <div class='row justify-content-center mt-5'>
            <form method='POST' action='edicionArticulos.php'>
                <input type='hidden' name='idart' value=$idart>
                <input type='submit' value='Confirmar baja' name='confbajart' class='btn btn-danger mr-3'>
            </form>
          
            <a href='edicionArticulos.php?idart=$idart'>
                <button class='btn btn-secondary ml-3'>Cancelar</button>
            </a>
            </div></div>
            <div class='col-md-3 justify-content-center'>
			<img src='imgProductos/$idart.jpg' class='img-fluid '>
            </div></div>";
    }
}
?>
<?php
if(isset($_SESSION['autenticado'])){
    if (($admin->getRol_usr() == 4) || ($admin->getRol_usr() == 3)){
    echo "<div class='row mt-3 justify-content-center'>
        <form action='almacen.php' method='POST'>
        <input type='hidden' name='articulo' value='$idart'>
        <input class='m-3' type='submit'  name='detalle' value='Almacén'></form></div>";
    }
}
?>




</div>



<?php include ("Nuevaautentificacion.php")?>
<?php include("Nuevopie.php")?>



