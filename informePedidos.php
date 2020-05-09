<?php
session_start();
include_once ("funciones.php");
if (! isset($_SESSION['autenticado'])) {
    header("location:index.php");
} else {
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if (($admin->getRol_usr() != 4) && ($admin->getRol_usr() != 3) && ($admin->getRol_usr() != 2)) {
        header("location:index.php");
    }
}

include_once ("validaciones.php");
$nom_pag = "Informes de ventas";
include ('Nuevacabecera.php');
include ('Nuevolateral.php');
echo "<div class='col-md-8'>";
$mostrar = '';

$idcliente = (isset($_POST['id'])) ? $_POST['id'] : "";
$stringinicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : "";
$inicio = (isset($_POST['inicio'])) ? strtotime($_POST['inicio']) : "";
$stringfinal = (isset($_POST['final'])) ? $_POST['final'] : "";
$final = (isset($_POST['final'])) ? strtotime($_POST['final']) : "";
$informe = "";
$err_id = "";
$err_inicio = "";
$err_final =  "";
$stringiniciot = (isset($_POST['iniciot'])) ? $_POST['iniciot'] : "";
$iniciot = (isset($_POST['iniciot'])) ? strtotime($_POST['iniciot']) : "";
$stringfinalt = (isset($_POST['finalt'])) ? $_POST['finalt'] : "";
$finalt = (isset($_POST['finalt'])) ? strtotime($_POST['finalt']) : "";
$informet = "";
$err_idt = "";
$err_iniciot = "";
$err_finalt =  "";

if (isset($_POST['ver'])) {
    if(empty(trim($idcliente))){
        $err_id = "<div class='text-danger'>El campo Id cliente está vacío</div>";
    }else if(!ctype_digit("$idcliente")){
        $err_id = "<div class='text-danger'>El campo Id cliente debe ser un número entero</div>";
    }else{
        $err_id = (empty(busca_cliente($idcliente))) ? "<div class='text-danger'>No existe ningún cliente con el Id introducido</div>" : "";
    }
    $err_inicio = (empty(trim($inicio))) ? "<div class='text-danger'>El campo fecha de inicio está vacío</div>" : "";
    if($inicio>$final){
        $err_final = "<div class='text-danger'>La fecha final no puede ser inferior a la de inicio</div>";
    }else{
        $err_final = (empty(trim($final))) ? "<div class='text-danger'>El campo fecha final está vacío</div>" : "";
    }
    if(empty($err_id) && empty($err_inicio) && empty($err_final)){
        $final += (60 * 60 * 24) ;
        $mostrar = "hidden";
        $informe = informe_pedidos($idcliente, $inicio, $final);

    }
}
if (isset($_POST['vertotal'])) {
    $err_iniciot = (empty(trim($iniciot))) ? "<div class='text-danger'>El campo fecha de inicio está vacío</div>" : "";
    if($iniciot>$finalt){
        $err_finalt = "<div class='text-danger'>La fecha final no puede ser inferior a la de inicio</div>";
    }else{
        $err_finalt = (empty(trim($finalt))) ? "<div class='text-danger'>El campo fecha final está vacío</div>" : "";
    }
    if(empty($err_iniciot) && empty($err_finalt)){
        $finalt += (60 * 60 * 24);
        $mostrar = "hidden";
        $informet = mostrar_pedidos($iniciot, $finalt);       
    }
}

?>

<div class='row mt-5'>
<div class='col-6'>

		<?php echo $informe ?>
			<form method='POST' action='informePedidos.php' <?php echo $mostrar?>>
	<h5 class='text-center'>Todos los clientes</h5>
				<div class="form-group row mt-5">
					<label class=' col-sm-5 col-form-label text-right'>Desde fecha: </label>
					<div class='col-sm-6'>
						<input type='date' name='iniciot' value=<?php echo $stringiniciot?>>
						<?php echo $err_iniciot ?>
					</div>
				</div>
				<div class="form-group row">
					<label class=' col-sm-5 col-form-label text-right'>Hasta fecha: </label>
					<div class='col-sm-6'>
						<input class='text-center' type='date' name='finalt' value=<?php echo $stringfinalt?>>
						<?php echo $err_finalt ?>
					</div>
				</div>
				<div class='row justify-content-center mt-5'>
					<input type='submit' class='btn btn-primary' value='Ver informe total'
						name='vertotal'>
				</div>
			</form>
</div>
<div class='col-6'>
		<?php echo $informe ?>
			<form method='POST' action='informePedidos.php' <?php echo $mostrar?>>
	<h5 class='text-center'>Detallado por cliente</h5>

				<div class="form-group row mt-5">
					<label class=' col-sm-5 col-form-label text-right'>Id Cliente</label>
					<div class='col-sm-6'>
						<input type='text' name='id' value=<?php echo $idcliente?>><?php echo $err_id ?>
					</div>
				</div>
				<div class="form-group row">
					<label class=' col-sm-5 col-form-label text-right'>Desde fecha: </label>
					<div class='col-sm-6'>
						<input type='date' name='inicio' value=<?php echo $stringinicio?>>
						<?php echo $err_inicio ?>
					</div>
				</div>
				<div class="form-group row">
					<label class=' col-sm-5 col-form-label text-right'>Hasta fecha: </label>
					<div class='col-sm-6'>
						<input class='text-center' type='date' name='final' value=<?php echo $stringfinal?>>
						<?php echo $err_final ?>
					</div>
				</div>
				<div class='row justify-content-center'>
					<input type='submit' class='btn btn-primary' value='Ver informe detalle'
						name='ver'>
				</div>
			</form>

</div></div>
</div>

<?php
include('Nuevaautentificacion.php');
include('Nuevopie.php');


?>
