<?php
session_start();
include_once ("funciones.php");
if(!isset($_SESSION["autenticado"])){
    header("location:carro.php?autent=true");
}
$cli = $_SESSION["autenticado"];
$pedido = crear_pedido($cli);

foreach($_COOKIE["carro"] as $nombre=>$cantidad){
    $articulo = buscar_articulo($nombre);
    $precio = $articulo->getPre_art();
    crear_linea($pedido,$nombre,$cantidad,$precio);
    descontar_stock($nombre,$cantidad);
}
foreach($_COOKIE["carro"] as $nombre=>$valor){
    setcookie("carro[$nombre]",$valor,time()-100);
}
setcookie("compra",0,time()-100);

header("location:recibo.php?ped=$pedido");
?>

