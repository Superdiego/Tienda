<?php
include_once("funciones.php");
include_once("validaciones.php");
session_start();

$nom_pag = "Inicio";
include_once("Nuevacabecera.php");
include_once("Nuevolateral.php");
?>


<?php
echo "<div class='col-md-8 '><div class='row justify-content-center'>";


$datos = mostrar_articulos(6,'DESC');
$art = $datos[0];

foreach($art as $articulo){
    $cat = $articulo->getCat_art();
    if(devuelve_categoria($cat)[2]==1){
        echo "<div class='col-md-6 col-xl-4 p-3'>
            <div style='text-align:center'><a class href='detalleArticulo.php?art=".$articulo->getId_art()."'>
            <img src='imgProductos/".$articulo->getId_art().".jpg' width='100' height='100'></a>
            <div>".$articulo->getNom_art(). " ".$articulo->getPre_art()."</div></div>
            </div>";
    }
}

?>
</div>
<div class='row'>
<div class='col-sm-4'></div>
<div class='col-sm-2 text-center'><p><?php echo $datos[2]?><p></div>
<div class='col-sm-2 text-center'><p><?php echo $datos[1]?></p></div>
<div class='col-sm-4'></div>
</div></div>

<?php include ("Nuevaautentificacion.php")?>

<?php include("Nuevopie.php")?>

