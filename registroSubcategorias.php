<!DOCTYPE html>

<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
<?php
include ("funciones.php");
include ("validaciones.php");

$categoria = (isset($_POST['categoria'])) ? $_POST['categoria'] : '';
$res_cat = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (trim($categoria)!='' && $categoria!=null) {
        $res_cat = leer_categoria($categoria);
    } else {
        $res_cat = "<span class='error'>Introduzca un codigo de categoria</span>";
    }
}
?>
<h1>ALTA DE SUBCATEGORIAS</h1>
	<br>
	<br>
	<form method="POST" action="registroSubcategorias.php">
		Categoria a la que pertenece: 
		<input type="text" name="categoria" value="<?php echo $categoria?>">
		<input type="submit" value='comprobar'>
		<br><br>
		<?php echo $res_cat ?>
		<br><br>

	</form>
	<br><br>
	<a href="index.php">Volver a pagina principal</a>
</body>
</html>