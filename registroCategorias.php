<?php
session_start();
include_once('funciones.php');
if(!isset($_SESSION['autenticado'])){
    header("location:index.php");
}else{
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if($admin->getRol_usr()!=4){
        header("location:index.php");
    }
}
$nom_pag="Alta Categorias";
include_once("cabecera.php");
include_once ("validaciones.php");

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
	
<?php 
if($admin->getRol_usr()==4){
    echo "<div class='text-center'><a href='administrador.php'>Menu administrador</a></div>";
}


?>	
	
</body>
</html>