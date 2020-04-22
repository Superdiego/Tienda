<?php
session_start();
include_once ("funciones.php");
$id_pag = (isset($_GET['art'])) ? $_GET['art'] : null;
$producto = buscar_articulo($id_pag);
$nom_pag = $producto->getNom_art();
include ("cabecera.php");
?>
<div class="container-fluid">
	<img src="imgProductos/<?php echo $id_pag?>.jpg">
	<h3 class="text-center py-5 text-success"><?php echo $producto->getPre_art()?>&nbsp;Eur</h3>
	<p><?php echo $producto->getDes_art();?></p>
	<div class="row">
		<div class="col-4"></div>
		<div class="col-4">
			<form method="GET" action="carro.php">
				<label>Cantidad: </label> <input type="number" name="cant" value=1
					min=1 style="width: 3em">
				<button class=" bg-primary  rounded float-center align-middle"
					type="submit" name="art" value=<?php echo $id_pag?>>
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
		<div class="col-4"></div>
	</div>

<?php 
if (isset($_SESSION['autenticado'])){
    $name = $_SESSION['autenticado'];
    $user = datos_usuario($name);
    if(($user->getRol_usr() == 3) || ($user->getRol_usr() == 4)) {

    echo "<div class='text-center py-2'><a href='almacen.php?art=$id_pag'>Acceso a almacen</a></div>";
    }
}
?>
</div>
</div>

			<div class="col-md-2">
			<?php include ("autentificacion.php")?>
			</div>
</div>
</div>
<?php include("pie.php")?>
</body>
</html>