<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="bootstrap/bootstrap.css">
<!--  <link rel="stylesheet" type="text/css" href="estilo.css"> -->
<title>Hello, world!</title>

</head>
<body>


    <!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
		integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
		crossorigin="anonymous"></script>
	<script
		src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
		integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
		crossorigin="anonymous"></script>
	<script src="bootstrap/bootstrap.js"></script>
	<div class="container-fluid bg-primary">
		<div class="container text-white py-5">
			<h1 class="display-4">Cachivaches</h1>
			<p class="lead">Bienvenid@s a la tienda de Diego</p>
		</div>
	</div>

<?php
    include("validaciones.php");
    include("funciones.php");
 


$nom = (isset($_POST['nombre'])) ? $_POST['nombre'] : null;
$sub = (isset($_POST['subcat'])) ? $_POST['subcat'] : null;
$cat = (isset($_POST['cat'])) ? $_POST['cat'] : null;
$des = (isset($_POST['descrip'])) ? $_POST['descrip'] : null;
$pre = (isset($_POST['precio'])) ? $_POST['precio'] : null;
$fot = (isset($_POST['foto'])) ? $_POST['foto'] : null;

$val_nom = null;
$val_sub = null;
$val_cat = null;
$val_des = null;
$val_pre = null;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $val_nom = !val_texto($nom) ? "<span class='error'>Introduzca un nombre</span>" : '';
    if (!ctype_digit($sub)){
        $val_sub="<span class='error'>Introduzca una subcategoria</span>";
    }else{
        if(leer_subcategoria($sub)==null){
            $val_sub="<span class='error'>No existe ninguna subcategoria con id numero $sub";
        }else{
            $val_sub = leer_subcategoria($sub);
        }
    }
    if (!ctype_digit($cat)){
        $val_cat="<span class='error'>Introduzca una categoria</span>";
    }else{
        if(leer_categoria($cat)==null){
            $val_cat="<span class='error'>No existe ninguna categoria con id numero $cat </span>";
        }else{
            $val_cat = leer_categoria($cat);
        }
    }
    $val_des = !val_texto($des) ? "<span class='error'>Introduzca descripcion</span>" : '';
    $val_pre = !is_numeric($pre) ? "<span class='error'>Introduzca un precio</span>" : '';
    
    if(val_texto($nom) && val_texto(leer_subcategoria($sub)) && val_texto(leer_categoria($cat)) &&
        val_texto($des) && ctype_digit($pre)){
        registrar_articulos($nom,$sub,$cat,$des,$pre);
    }
        
}
?>
<h1>ALTA ARTICULOS</h1>
<br><br>
<form method="post" action="registroArticulos.php" enctype="multipart/form-data">
Nombre: <input type="text" name="nombre" value="<?php echo $nom ?>"><?php echo $val_nom ?><br>
Subcategoria: <input type="number" name="subcat" value="<?php echo $sub ?>"><?php echo $val_sub ?><br>
Categoria: <input type="number" name="cat" value="<?php echo $cat ?>"><?php echo $val_cat ?><br>
Descripcion: <textarea name="descrip" value="<?php echo $des ?>"></textarea><?php echo $val_des ?><br>
Precio: <input type="number" name="precio" value="<?php echo $pre ?>"><?php echo $val_pre ?><br>
Imagen: <input type="file" name="foto" value="<?php echo $fot ?>"><br>

<br><br>
<input type="submit" value="Registrar">

</form>


<br><br><a href="index.php">Volver a pagina principal</a>

</body>

</html>
