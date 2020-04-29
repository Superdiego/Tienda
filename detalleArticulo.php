<?php
session_start();
include_once ("funciones.php");
include_once ("validaciones.php");
if (isset($_GET['art'])) {
    $id = $_GET['art'];
    $producto = buscar_articulo($id);
}
$nom_pag = $producto->getNom_art();

if (isset($_SESSION['autenticado'])) {
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
}

include ('Nuevacabecera.php');
include ('Nuevolateral.php');

if (isset($_GET['art'])) {
    $id = $_GET['art'];
    $producto = buscar_articulo($id);
}

echo "<div class='col-md-8'>";
?>

<div class=" row container-fluid justify-content-center">
	<img src="imgProductos/<?php echo $id?>.jpg">
</div>
<h3 class="text-center py-5 text-success"><?php echo $producto->getPre_art()?>&nbsp;Eur</h3>
<p class='text-center'><?php echo $producto->getDes_art();?></p>
<div class="row container-fluid justify-content-center">
		<form method="GET" action="carro.php">
			<label>Cantidad: </label> <input type="number" name="cant" value=1
				min=1 style="width: 3em">
			<button class=" bg-primary  rounded float-center align-middle"
				type="submit" name="art" value=<?php echo $id?>>
				<svg class="rounded float-right " viewBox="0 0 32 32" width="32"
					height="32" fill="none" stroke="white" stroke-linecap="round"
					stroke-linejoin="round" stroke-width="2">
    				<path d="M6 6 L30 6 27 19 9 19 M27 23 L10 23 5 2 2 2" />
    				<circle cx="25" cy="27" r="2" />
   		 			<circle cx="12" cy="27" r="2" />
				</svg>
			</button>
		</form>
	
</div>
<?php
if(isset($_SESSION['autenticado'])){
    if (($admin->getRol_usr() == 4) || ($admin->getRol_usr() == 3)){
    echo "<div class='row mt-3 justify-content-center'><form action='modificarArticulo.php' method='POST'>
        <input type='hidden' name='id' value='$id'>
        <input class='m-3' type='submit'  name='revisar' value='Editar artículo'></form>
        <form action='almacen.php' method='POST'>
        <input type='hidden' name='articulo' value='$id'>
        <input class='m-3' type='submit'  name='detalle' value='Almacén'></form></div>";
    }
}
?>



</div>
<?php include ("Nuevaautentificacion.php")?>
<?php include("Nuevopie.php")?>
