<?php
session_start();
include_once("funciones.php");
if(!isset($_COOKIE["carro"])){
    header("location:index.php");
}
$aviso = (isset ($_GET["autent"])) ? "Debe identificarse o registrarse antes de confirmar el pedido" : "";

if(isset($_GET["art"])){
    $cantotal = (isset($_COOKIE["compra"])) ? $_COOKIE["compra"] : 0;
    $art = (int)$_GET["art"];
    $cant = $_GET["cant"];
    $prod = buscar_articulo($art);

    $preart = $prod->getPre_art();
    if(isset($_COOKIE["carro"]["$art"])){
        setcookie("carro[$art]",$_COOKIE["carro"][$art] + $cant,time()+3600);
    }else{
        setcookie("carro[$art]",$cant,time()+3600);
    }
    setcookie("compra",$cantotal+$cant,time()+3600);
    header("location:carro.php");
}
if(isset($_GET["limpiar"]) && $_GET["limpiar"]==true){
            
    foreach($_COOKIE["carro"] as $nombre=>$valor){
        setcookie("carro[$nombre]",$valor,time()-100);
    }
    setcookie("compra",0,time()-100);
    header("location:index.php");

}


$nom_pag = "Su carrito de la compra";


include_once("validaciones.php");
include_once("Nuevacabecera.php");
include_once("Nuevolateral.php");
$importotal = 0;
if(isset($_COOKIE["carro"])){
    echo "<div class='col-md-8'><table class='table'><thead><tr><th>Articulo</th>
        <th>Cantidad</th><th>Precio</th><th>Importe</th><th></th></tr></thead><tbody>";
    
    foreach($_COOKIE["carro"] as $articulo=>$cantidad){
        $art = buscar_articulo($articulo);
        $importe = $cantidad * $art->getPre_art();
        $importotal += $importe;
        echo "<form method='POST' action='cambiar_carro.php'>
            <tr><td>".$art->getNom_art()."</td><td class='pr-1'>
            <input type='number' name='cantidad' value='$cantidad' min=1 style='width:3em'>
            <button type='submit' name='articulo' value='".$art->getId_art()."' class='bg-primary p-1 text-white small'>            
            <svg class='bi bi-pencil-square ' width='1.5em' height='1.5em' viewBox='0 0 16 16' fill='white'>
            <path d='M15.502 1.94a.5.5 0 010 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 01.707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 00-.121.196l-.805 2.414a.25.25 0 00.316.316l2.414-.805a.5.5 0 00.196-.12l6.813-6.814z'/>
            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 002.5 15h11a1.5 1.5 0 001.5-1.5v-6a.5.5 0 00-1 0v6a.5.5 0 01-.5.5h-11a.5.5 0 01-.5-.5v-11a.5.5 0 01.5-.5H9a.5.5 0 000-1H2.5A1.5 1.5 0 001 2.5v11z' clip-rule='evenodd'/>
            </svg></button></td><td>".$art->getPre_art()."</td><td>$importe</td><td>
            <button type='submit' name='papelera' value='".$art->getId_art()."' class='bg-primary text-white p-1 small'>
		    <svg class='bi bi-trash-fill' width='1.5em' height='1.5em' viewBox='0 0 16 16' fill='white'>
            <path fill-rule='evenodd' d='M2.5 1a1 1 0 00-1 1v1a1 1 0 001 1H3v9a2 2 0 002 2h6a2 2 0 002-2V4h.5a1 1 0 001-1V2a1 1 0 00-1-1H10a1 1 0 00-1-1H7a1 1 0 00-1 1H2.5zm3 4a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7a.5.5 0 01.5-.5zM8 5a.5.5 0 01.5.5v7a.5.5 0 01-1 0v-7A.5.5 0 018 5zm3 .5a.5.5 0 00-1 0v7a.5.5 0 001 0v-7z' clip-rule='evenodd'/>
            </svg></button></td></tr></form>";
    }
}
echo "</tbody><tfoot><tr><th>Totales</th><th>".$_COOKIE['compra']."</th><th>Importe</th><th>$importotal</th></table>";

?>

<br><br><br>

<div class="row justify-content-center" >
<a href="carro.php?limpiar=true">
<button class="bg-primary p-1 mx-2 text-white">Vaciar carrito</button>
</a>
<a href="index.php">
<button class="bg-primary p-1 mx-2 text-white">Seguir comprando</button>
</a></div>
<br><br>
<div  class="row justify-content-center" ><a href="pedidos.php"><button class="bg-success p-2 text-white">Confirmar pedido</button></a></div>

			<div class="container text-center text-danger"><?php echo $aviso?></div> </div>

			<?php include ("Nuevaautentificacion.php");
			include ("Nuevopie.php");
			?>
