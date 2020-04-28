<?php
session_start();
include_once ("funciones.php");
include_once ("validaciones.php");
if (! isset($_SESSION['autenticado'])) {
    header("location:index.php");
} else {
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if (($admin->getRol_usr() != 4) && ($admin->getRol_usr() != 3) && ($admin->getRol_usr() != 2)) {
        header("location:index.php");
    }
}

include_once ("funciones.php");
include_once ("validaciones.php");
$nom_pag = "Almacén";
include ('Nuevacabecera.php');
include ('Nuevolateral.php');

// - - - - - - - - - - - - - - - - -

$err_ped = "";
$err_fec = "";
$err_art = "";
$err_cant = "";
$apunte = "";

$pedido = (isset($_POST['pedido'])) ? intval($_POST['pedido']) : "";
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : "";
$idart = (isset($_POST['articulo'])) ? $_POST['articulo'] : "";
$cant = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : "";

if (isset($_POST['almacen'])) {
    $err_ped = (empty($pedido)) ? "<div class='text-danger'>El campo pedido está vacío</div>" : "";
    $err_fec = (empty($fecha)) ? "<div class='text-danger'>El campo fecha está vacío</div>" : "";
    if (empty($idart)) {
        $err_art = "<div class='text-danger'>El campo Id artículo está vacío</div>";
    } else {
        $err_art = (buscar_articulo($idart) == false) ? "<div class='text-danger'>No existe ningún artículo con este Id</div>" : "";
    }
    if (empty($cant) || $cant == 0) {
        $err_cant = "<div class='text-danger'>El campo cantidad está vacío</div>";
    } else {
        $err_cant = (! is_numeric($cant)) ? "<div class='text-danger'>El campo cantidad debe ser un número</div>" : "";
    }
    if (empty($err_ped) && empty($err_fec) && empty($err_art) && empty($err_cant)) {
        $apunte = insertar_pedidoAlmacen($pedido, $fecha, $idart, $cant);
        descontar_stock($idart, - $cant);
        $pedido = "";
        $fecha = "";
        $idart = "";
        $cant = "";
    }
}

?>
<div class='col-md-8'>
	<div class='container>
	<p  class='text-success'><?php echo $apunte ?></p>
		<form method='POST' action='almacen.php'>
			<div class='form-group row mt-5'>
				<label class=' col-sm-5 col-form-label text-right'>Referencia: </label>
				<div class='col-sm-4'>
					<input class="form-control" type='text' name='pedido'
						value='<?php echo $pedido?>'><?php echo $err_ped?>
</div>
			</div>
			<div class='form-group row'>
				<label class='col-sm-5 col-form-label text-right'>Fecha: </label>
				<div class='col-sm-4'>
					<input class="form-control" type='date' name='fecha'
						value='<?php echo $fecha?>'><?php echo $err_fec?>
</div>
			</div>
			<div class='form-group row'>
				<label class='col-sm-5 col-form-label text-right'>Id artículo: </label>
				<div class='col-sm-4'>
					<input class="form-control" type='text' name='articulo'
						value='<?php echo $idart?>'><?php echo $err_art?>
</div>
			</div>
			<div class='form-group row'>
				<label class='col-sm-5 col-form-label text-right'>Cantidad: </label>
				<div class='col-sm-4'>
					<input class="form-control" type='text' name='cantidad'
						value='<?php echo $cant?>'><?php echo $err_cant?>
</div>
			</div>
			<div class='form-group row justify-content-center'>
				<input type='submit' name='almacen' value='Confirmar' class='mx-5'>
		
		</form>
		<form action='index.php'>
			<input type='submit' value='Salir'>
		</form>
	</div>

</div>
</div>





<?php
include ('Nuevaautentificacion.php');
include('Nuevopie.php');
?>

