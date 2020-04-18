<?php
session_start();
$nom_pag = "Inicio";
include_once("funciones.php");
include_once("validaciones.php");
include_once("cabecera.php");
?>
<div class="row">

<?php

$datos = mostrar_articulos(8);
$art = $datos[0];

foreach($art as $articulo){
    echo "<div class='col-md-6 col-xl-4 p-3'><div><a href='detalleArticulo.php?art=".$articulo->getId_art()."'>
        <img src='imgProductos/".$articulo->getId_art().".jpg' width='100' height='100'></a></div><div>". 
        $articulo->getNom_art(). " ".$articulo->getPre_art()."</div></div>";
}

?>

<div class='row'>
<div class='col-sm-4'></div>
<div class='col-sm-2 text-center'><p><?php echo $datos[1]?><p></div>
<div class='col-sm-2 text-center'><p><?php echo $datos[2]?></p></div>
<div class='col-sm-4'></div>
</div></div>
 <?php
 if(isset($_SESSION['admin'])){
    echo "<div class='text-center pt-3'><a href='administrador.php'>Volver menu administrador</a></div>";
 }?>               



</div>
			<div class="col-md-2">
			<?php include ("autentificacion.php")?>
			</div>
</div>
</div>
<?php include("pie.php")?>
</body>
</html>
