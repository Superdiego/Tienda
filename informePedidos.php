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
$inicio = (isset($_POST['inicio'])) ? strtotime($_POST['inicio']) : "";
$final = (isset($_POST['final'])) ? strtotime($_POST['final']) + (60 * 60 * 24) : "";
$informe = "";
$err_id = "";
$err_inicio = "";
$err_final =  "";

if (isset($_POST['ver'])) {

    if(empty($idcliente)){
        $err_id = "<div class='text-danger'>El campo Id cliente está vacío</div>";
    }else{
        $err_id = (empty(busca_cliente($idcliente))) ? "<div class='text-danger'>No existe ningún cliente con el Id introducido</div>" : "";
    }
    $err_inicio = (empty($inicio)) ? "<div class='text-danger'>El campo fecha de inicio está vacío</div>" : "";
    $err_final = (empty($final)) ? "<div class='text-danger'>El campo fecha final está vacío</div>" : "";
    if(empty($err_id) && empty($err_inicio) && empty($err_final)){
        $mostrar = "hidden";
        $informe = informe_pedidos($idcliente, $inicio, $final);

    }
}
?>



		<?php echo $informe ?>
			<form method='POST' action='informePedidos.php' <?php echo $mostrar?>>
	

				<div class="form-group row mt-5">
					<label class=' col-sm-5 col-form-label text-right'>Id Cliente</label>
					<div class='col-sm-6'>
						<input type='text' name='id'><?php echo $err_id ?>
					</div>
				</div>
				<div class="form-group row">
					<label class=' col-sm-5 col-form-label text-right'>Desde fecha: </label>
					<div class='col-sm-6'>
						<input type='date' name='inicio'><?php echo $err_inicio ?>
					</div>
				</div>
				<div class="form-group row">
					<label class=' col-sm-5 col-form-label text-right'>Hasta fecha: </label>
					<div class='col-sm-6'>
						<input class='text-center' type='date' name='final'><?php echo $err_final ?>
					</div>
				</div>
				<div class='row col-6 justify-content-center'>
					<input type='submit' class='btn btn-primary' value='Ver informe'
						name='ver'>
				</div>
			</form>

</div>

<?php
include('Nuevaautentificacion.php');
include('Nuevopie.php');


?>
