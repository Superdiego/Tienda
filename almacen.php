<?php
session_start();
include_once ('funciones.php');
include_once ("validaciones.php");
$nom_pag = "Gestion de almacen";

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
?><!--  final encabezado -->

<?php
if(isset($_GET['art'])){
    $art = buscar_articulo($_GET['art']);
}
?>
<div class='row'>
<div class='col-md-2'></div>
<div class='col-md-6'>
<form method='POST' action=''>
<div class="form-row my-3">
<div class='col-md-3'>
<input type='text' class='form-control' readonly value='Id: <?php echo $art->getId_art()?>'>
</div>
<div class="col-md-8"> 
<input type='text' class='form-control' readonly value='<?php echo $art->getNom_art()?>'>
</div></div>
<div class="form-row my-3">
<div class='col-md-8 text-center'>
<input type='text' class='form-control' readonly value='Stock:  <?php echo $art->getSto_art()?>'>
</div></div>
<div class="form-row my-3">
<label>Entrada:</label>
<input type='text' class='form-control' value=''>
</div><br>
<div class="form-row my-3">
<input type='button' class="btn btn-primary" name='almacen' value='Enviar'>
</div>
</form>
</div>
<div class='col-md-2'></div>
</div>


<?php //comienzo pie
if(isset($_SESSION['admin'])){
    echo "<div class='text-center pt-3'><a href='administrador.php'>Volver menu administrador</a></div>";
}
if(isset($_SESSION['emple'])){
    echo "<div class='text-center pt-3'><a href='empleado.php'>Volver menu empleado</a></div>";
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
