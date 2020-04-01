<?php
$nom_pag="Alta Categorias";
include("cabecera.php");

include ("funciones.php");
include ("validaciones.php");

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$res_nom = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (val_texto($nombre)) {
        registrar_categoria($nombre);
    } else {
        $res_nom = "<span class='error'>Introduzca un nombre valido</span>";
    }
}
?>

	<form method="POST" action="registroCategorias.php">
		Nombre nueva categoria: <input type="text" name="nombre"
			value="<?php echo $nombre?>"><?php echo $res_nom ?>
		<br><br>
		<input type="submit" value="Insertar nueva categoria">
	</form>
	<br><br>
	<a href="index.php">Volver a pagina principal</a>
</body>
</html>