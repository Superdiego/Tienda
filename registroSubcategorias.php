<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
<?php
include ("funciones.php");
include ("validaciones.php");

$idcate = (isset($_POST['idcate'])) ? $_POST['idcate'] : '';
$mensaje ='';
$res_cat=null;
$subcate = (isset($_POST['subcate'])) ? $_POST['subcate'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (ctype_digit($idcate)) {
        $res_cat = leer_categoria($idcate);
        if($res_cat != null){
            $mensaje = "<span class='correcto'>" . $res_cat. "</span>";
            if($subcate != ''){
                registrar_subcategoria($idcate,$subcate);
            }
        }else{
            $mensaje = "<span class='error'>No existe ninguna categoria con id numero $idcate</span>";
        }
    }else {
        $mensaje = "<span class='error'>Introduzca un codigo de categoria valido</span>";
    }
    
}
?>
<h1>ALTA DE SUBCATEGORIAS</h1>
	<br>
	<br>
	<form method="POST" action="registroSubcategorias.php">
		Categoria a la que pertenece: 
		<input type="number" name="idcate" value="<?php echo $idcate?>">
		<br><br>
		<input type="submit" value='comprobar'>
	</form>
	<br><br>
	<form method="POST" action="registroSubcategorias.php">
		<?php echo $mensaje;
		if (val_texto($res_cat)){
		    echo '<br>Introduzca el nombre de la nueva subcategoria:
                <input type="text" name="subcate"><br>
                <input type="hidden" name="idcate" value="' . $idcate . '">
                <input type="submit" value="Registrar subcategoria"><br>';
		}?>
    </form>
		<br><br>
	
	<br><br>
	<a href="index.php">Volver a pagina principal</a>
</body>
</html>