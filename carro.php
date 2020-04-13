<?php
include_once("funciones.php");
if(!isset($_COOKIE["carro"])){
    header("location:index.php");
}
if(isset($_GET["art"])){
    $total = (isset($_COOKIE["compra"])) ? $_COOKIE["compra"] : 0;
    $art = $_GET["art"];
    $cant = $_GET["cant"];
    $prod = buscar_articulo($art);
    $nomart = $prod->getNom_art();
    if(isset($_COOKIE["carro"]["$nomart"])){
        setcookie("carro[$nomart]",$_COOKIE["carro"][$nomart] + $cant,time()+3600);
    }else{
        setcookie("carro[$nomart]",$cant,time()+3600);
    }
    setcookie("compra",$total+$cant,time()+3600);
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

if(isset($_COOKIE["carro"])){
    foreach($_COOKIE["carro"] as $nombre=>$valor){
        echo "Producto: " . $nombre . " Cantidad: " . $valor . "<br>"; 
    }
}
if(isset($_COOKIE["compra"])){
echo $_COOKIE["compra"];
}


?>
<br><br>
<a href="carro.php?limpiar=true">
<button class=" bg-primary  rounded float-center " type="submit" name="art" >
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

