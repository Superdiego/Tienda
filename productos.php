<?php
session_start();
$nom_pag = "Productos";
include_once("funciones.php");
include_once("validaciones.php");
include_once("cabecera.php");

echo "<div class='row'>";
$datos = mostrar_articulos(8);
?>

<div class='container'>
<div class= ' row row-cols-1 row-cols-md-2'>


<?php 
$categ = listadesubcategorias();
foreach($categ as $cat) {
echo "<div class='card py-5'><h2 class='text-center'><a href='Subcategorias.php?sub=".$cat[2]."'>".$cat[2]."</a></h2></div>";
}
?>

</div>
</div>
</div>
 <?php
 if(isset($_SESSION['admin'])){
    echo "<div class= 'col mb-4'><div class='text-center pt-3'><a href='administrador.php'>Volver menu administrador</a>
</div></div>";
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