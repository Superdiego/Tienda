<?php
session_start();
include_once ('funciones.php');
include_once ("validaciones.php");
$nom_pag = "Alta Categorias";

if (! isset($_SESSION['autenticado'])) {
    header("location:index.php");
} else {
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if (($admin->getRol_usr() != 4) && ($admin->getRol_usr() != 3)) {
        header("location:index.php");
    }
}
include_once ("cabecera.php");


$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$res_nom = "";
$subcate = (isset($_POST['subcate'])) ? $_POST['subcate'] : '';
$res_subcate = "";
$cate = (isset($_POST['cate'])) ? $_POST['cate'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['nombre'])){
        if (val_texto($nombre)) {
            $res_nom = registrar_categoria($nombre);
        } else {
            $res_nom = "<span class='text-danger'>Introduzca un nombre valido</span>";
        }
    }
    if(isset($_POST['subcate'])){
        if(val_texto($subcate)){
            if(isset($_POST['cate'])){
                $res_subcate = registrar_subcategoria($cate,$subcate);
            }else{
                $res_subcate = "<span class='text-danger'>Debe introducir una categoria</span>";
            }
        } else{
            $res_subcate = "<span class='text-danger'>Introduzca un nombre valido</span>";
        }
    }
}
?>
<div class="row">
	<div class="col-sm-5  pt-5 bg-light">
		<h2 class="pb-3">Categorias</h2>
		<form method="POST" action="registroCategorias.php">
			<p>Nombre nueva categoria:</p>
			<input type="text" name="nombre" value="<?php echo $nombre?>">
			<p class="pt-2"><?php echo $res_nom ?></p>
			<br>
			<br> <input class="bg-primary text-white py-2" type="submit" value="Insertar nueva categoria">
		</form>
		<br>
		<br>
		</div>
	<div class="col-sm-1"></div>

	<div class="col-sm-5 pt-5 bg-light">
		<h2 class="pb-3">Subcategorias</h2>
		<p class="text-left">Categoria:<p>
		
		<form method="POST" action="registroCategorias.php">
		<div  class="text-left" >
			<select name='cate'>
				<option value=1 disabled selected>Seleccione una categoria</option>
                    <?php menu_categorias()?>
                    </select></div>
                    <div class="text-right pt-4 pb-3" ><label>Nombre subcategoria:</label>
            <input type="text" name="subcate" value="<?php echo $subcate ?>">
            <p class="pt-2"><?php echo $res_subcate ?></p>
            <br><input class="bg-primary text-white py-2" type="submit" value="Insertar nueva subcategoria">
            </div>
		</form>
		

	</div>
</div>
<p class=pt-5>

</p>
<?php
if ($admin->getRol_usr() == 4) {
    echo "<div class='text-center py-2'><a href='administrador.php'>Menu administrador</a></div>";
}
if ($admin->getRol_usr() == 3) {
    echo "<div class='text-center py-2'><a href='empleado.php'>Menu administrador</a></div>";
}

?>
</div>
<div class="col-md-2">
			<?php include ("autentificacion.php")?>
			</div>
</div>
</div>
<?php include("pie.php")?>
</body>
</html>