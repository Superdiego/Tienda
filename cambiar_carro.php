<?php
include_once("funciones.php");


if(isset($_POST['articulo'])){
    $cantotal = (isset($_COOKIE["compra"])) ? $_COOKIE["compra"] : 0;
    $art = $_POST["articulo"];
    $cant = $_POST["cantidad"];
    $prod = buscar_articulo($art);
    

    $oldcant = $_COOKIE["carro"]["$art"];
    if(isset($_COOKIE["carro"]["$art"])){
        setcookie("carro[$art]",$cant,time()+3600);
        setcookie("compra",$cantotal-$oldcant+$cant,time()+3600);
        header("location:carro.php");
    }
}


?>