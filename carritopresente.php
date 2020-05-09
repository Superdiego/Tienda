<?php
include_once("funciones.php");
if(!empty($_COOKIE['carro'])){
    $cantArt = 0;
    $importotal = 0;
    foreach($_COOKIE["carro"] as $idart=>$cantidad){
        $articulo = buscar_articulo($idart);
        $cantArt += $cantidad;
        $importe = $cantidad * $articulo->getPre_art();
        $importotal += $importe;   
    }
    echo "<span style='float:right'>Lleva $cantArt artículo";
    if($cantArt>1){
        echo "s";
    }
    echo " por un total de  $importotal €";
    
}
