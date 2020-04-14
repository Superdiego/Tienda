<?php
include_once("funciones.php");
if(!isset($_COOKIE["carro"])){
    header("location:index.php");
}
if(isset($_GET["art"])){
    $cantotal = (isset($_COOKIE["compra"])) ? $_COOKIE["compra"] : 0;
    $art = $_GET["art"];
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
include_once("cabecera.php");
echo "<table class='table'><thead><tr><th scope='col'>Articulo</th><th scope='col'>Cantidad</th>
        <th scope='col'>Precio</th><th scope='col'>Importe</th></tr></thead><tbody>";
$importotal = 0;
if(isset($_COOKIE["carro"])){   
    foreach($_COOKIE["carro"] as $articulo=>$cantidad){
        $art = buscar_articulo($articulo);
        $importe = $cantidad * $art->getPre_art();
        $importotal += $importe;
        echo "<tr><th scope='row'>".$art->getNom_art()."</th><td>$cantidad</td><td>".$art->getPre_art()."</td>
            <td>$importe</td></tr>";
    }
}
echo "<tr><th>Totales</th><th>".$_COOKIE['compra']."</th><th>Importe</th><th>$importotal</th></tbody></table>";

?>
<br><br>


<a href="carro.php?limpiar=true">
<button class=" bg-primary  rounded float-center text-white" type="submit" name="art" >
Vaciar carrito</button></a>
			</div>
			</div>
			<div class="col-sm-12 col-md-2">
			<?php include ("autentificacion.php")?>
			</div>
		</div>
	</div>

</body>
</html>

