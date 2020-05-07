<?php
if(isset($_GET['art'])){
    $art = $_GET['art'];
    header("location:almacen.php?articulo=$art");
}
if(isset($_GET['alm'])){;
    $ent = $_GET['alm'];
    header("location:modifalmacen.php?ent_alm=$ent");
}
if(isset($_GET['alta'])){
    header("location:registroArticulos.php");
}

if(isset($_GET['modiflin'])){
    $idpedido = $_GET['modiflin'];
    header("location:modificarPedidos.php?modiflin=$idpedido");
}
if(isset($_GET['bajalin'])){
    $idpedido = $_GET['bajalin'];
    header("location:modificarPedidos.php?bajalin=$idpedido");
}
if(isset($_GET['bajaped'])){
    $idpedido = $_GET['bajaped'];
    header("location:modificarPedidos.php?bajaped=$idpedido");
}
?>