<?php
if(isset($_GET['art'])){
    $art = $_GET['art'];
    header("location:almacen.php?articulo=$art");
}
if(isset($_GET['artic'])){;
    $art = $_GET['artic'];
    header("location:modifalmacen.php?ent_alm=$art");
}
if(isset($_GET['alta'])){
    header("location:registroArticulos.php");
}
?>