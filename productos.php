<?php
session_start();
$nom_pag = "Productos";
include_once("funciones.php");
include_once("validaciones.php");
include_once("Nuevacabecera.php");
include_once('Nuevolateral.php');

echo "<div class='col-md-8'>";

?>


<div class= ' row row-cols-1 row-cols-md-2'>

<?php 
$categ = listadesubcategorias();
foreach($categ as $cat) {
    echo "<div class='card py-5'><h2 class='text-center'><a href='Subcategorias.php?sub=".$cat[2]."'>".leer_categoria($cat[0])."<br>".$cat[2]."</a></h2></div>";
}
?>



</div>
   </div>     

<?php include ("Nuevaautentificacion.php")?>
<?php include("Nuevopie.php")?>
