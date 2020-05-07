<?php
session_start();
include_once ("funciones.php");
include_once ("validaciones.php");
if (! isset($_SESSION['autenticado'])) {
    header("location:index.php");
} else {
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if (($admin->getRol_usr() != 4) && ($admin->getRol_usr() != 3)) {
        header("location:index.php");
    }
}



// - - - - - - - - - - - - - - - - -

$err_ref = "";
$err_fec = "";
$err_art = "";
$err_cant = "";
$apunte = "";
$oculta = '';
$msg_baja="";

$id_ent = (isset($_REQUEST['ent_alm'])) ? $_REQUEST['ent_alm'] : "";
$ent_alm = devuelve_entrada($id_ent);
$referencia = (isset($_POST['modificacion'])) ? $_POST['referencia'] : $ent_alm[1];
$fecha = (isset($_POST['modificacion'])) ? $_POST['fecha'] : $ent_alm[2];
$idart = (isset($_REQUEST['articulo'])) ? $_REQUEST['articulo'] : $ent_alm[3];
$cant = (isset($_POST['modificacion'])) ? $_POST['cantidad'] : $ent_alm[4];
$old_cant = $ent_alm[4];
$producto = buscar_articulo($idart);
if(isset($_GET['ent_alm'])){
    $apunte = "Registro modificado";
}


if (isset($_POST['modificacion'])) {
    $err_ref = (empty($referencia)) ? "<div class='text-danger'>El campo referencia está vacío</div>" : "";
    $err_fec = (empty($fecha)) ? "<div class='text-danger'>El campo fecha está vacío</div>" : "";
    if (empty($idart)) {
        $err_art = "<div class='text-danger'>El campo Id artículo está vacío</div>";
    } else {
        $err_art = (buscar_articulo($idart) == false) ? "<div class='text-danger'>No existe ningún artículo con este Id</div>" : "";
    }
    if (empty($cant)){
        $err_cant = "<div class='text-danger'>El campo cantidad no puede estar vacío</div>";
    }else{
        $err_cant = (! is_numeric($cant)) ? "<div class='text-danger'>El campo cantidad debe ser un número</div>" :"";
    }
    if (empty($err_ref) && empty($err_fec) && empty($err_art) && empty($err_cant)) {
        $apunte = modificar_pedidoAlmacen($id_ent, $fecha, $referencia, $cant);
        descontar_stock($idart, $old_cant);
        descontar_stock($idart, - $cant);
        header("location:controlAlmacen.php?alm=$id_ent");
    }
}

if (isset($_POST['baja'])){
    $oculta = "none";
    $msg_baja = "¿Seguro que quiere borrar el apunte?<form method='POST' action='modifalmacen.php'>
                <div class='form-row row col-12 justify-content-center '>
                <input type='submit' class='btn btn-danger mr-3' name='confbaja' value='Confirmar baja'>
                <input type='hidden' name='ent_alm' value=$id_ent></form>
                <form action='almacen.php' method='POST'>
                <input type='hidden' name='articulo' value='$idart'>
                <input class='btn btn-secondary' type='submit'  name='detalle' value='Cancelar'></form></div>";
}
if (isset($_POST['cancelbaja'])){
    header("location:almacen.php?articulo=$idart");
}
if (isset($_POST['confbaja'])){
     descontar_stock($idart, $old_cant);
     $baja = baja_almacen($id_ent);
     header("location:almacen.php?articulo=$idart");
}
$producto = buscar_articulo($idart);
$nom_pag = $producto->getNom_art();
include ('Nuevacabecera.php');
include ('Nuevolateral.php');

?>
<div class='col-md-8 mt-5'>
	<div class='container-fluid'>
	<div class="row">
	
	
<!-- Ingreso albaranes o facturas de mercancía -->	
	
	<div class='col-md-12'>
	<div class='container-fluid'>
	<p  class='text-success'><?php echo $apunte ?></p>
	<form method='POST' action='modifalmacen.php' >	
	<div class='row' ><div class='col-md-7'>
	<h4>Modificación entrada almacén</h4>
	<input class="form-control" readonly type='text' name='ent_alm'
					value='<?php echo $id_ent?>'><?php echo $err_art?>
		<div class='form-row'>
		
			<div class='form-group col-md-2'><label>Art: </label>
				<input class="form-control" readonly type='text' name='articulo'
					value='<?php echo $idart?>'><?php echo $err_art?>
				</div>
			<div class='form-group col-md-4'>
				<label>Referencia: </label>
				<input class="form-control" type='text' name='referencia'
					value='<?php echo $referencia?>'><?php echo $err_ref?>
			</div>
			<div class='form-group col-md-6'>
				<label>Fecha: </label>
				<input class="form-control" type='date' name='fecha'
					value='<?php echo $fecha?>'><?php echo $err_fec?>
			</div>
		</div>
		<div class='form-row'>
			<div class='form-row col-6 justify-content-center mb-3'>
				<label'>Cantidad: </label>
				<input class="form-control" type='text' name='cantidad'
					value='<?php echo $cant?>'><?php echo $err_cant?>
			</div>
		</div>
		<div class='form-row' ><?php echo $msg_baja ?>
			<div class='form-row row col-12 justify-content-center mb-5' style='display:<?php echo $oculta?>'>
				<input type='submit' name='modificacion' value='Modificar' class='btn btn-success mr-5'>
				<input type='submit' name='baja' value='Baja' class='btn btn-danger'></form>
				<form action='almacen.php' method='POST'>
        <input type='hidden' name='articulo' value=<?php echo $idart ?>>
        <input class='btn btn-secondary mx-5' type='submit'  name='detalle' value='Atrás'></form>
			</div>
		</div>
	</div>
	<div class='col-md-5 justify-content-center'>
		<img src="imgProductos/<?php echo $idart?>.jpg" class='img-fluid '>		
	</div>
	</div></div></div>
			
		
		
		

<!-- Tabla de movimientos de almacén del producto -->


	<div class='col-md-12 mt-5'>
	<div class='container-fluid'>
	
<?php 
$mov = movimientos_articulo($idart);
$alm = movimientos_almacen($idart);
if(isset($alm)){
    foreach($alm as $fila){
    $fila[0] = strtotime($fila[0]);
    $todo[] = $fila;
    }
}
if(isset($alm)){
    foreach($mov as $fila){   
        $cliente = busca_cliente($fila[2]);
        $fila[2] = $cliente->getNom_usr() . " ".$cliente->getApe_usr();
        $fila[3] = -$fila[3];
        $todo[] = $fila;
    }
}
if(isset($todo)){
    usort($todo, 'ordenando_fechas');     
}
?>
 
    <table class='table table-striped text-center'>
    	<thead><tr>
    		<th scope="col">Fecha</th><th scope="col">Ped. o Ref.</th><th scope="col">Cliente</th>
    		<th scope="col">Cantidad</th><th scope="col">Stock</th>
    	</tr></thead>
<?php
if(isset($todo)){
    $stock = 0;
    foreach($todo as $fila){
        $fila[0] = date('d/m/y', $fila[0]);
        $todo[] = $fila;
        $stock+=$fila[3];
        echo "<tr><td>$fila[0]</td><td>$fila[1]</td>
		  <td>$fila[2]</td><td>$fila[3]</td><td>$stock</td>";
        if(ctype_digit($fila[2])){
          echo "<form method='POST' action='modifalmacen.php'><td class='px-0'>
          <input type='hidden' name='ent_alm' value=$fila[2]>
          <input type='hidden' name='articulo' value=$idart>
          <button type='submit' name='entrada' class='btn btn-primary'>
          <svg class='bi bi-pencil-square' width='1em' height='1em' viewBox='0 0 16 16' fill='white'>
          <path d='M15.502 1.94a.5.5 0 010 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 01.707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 00-.121.196l-.805 2.414a.25.25 0 00.316.316l2.414-.805a.5.5 0 00.196-.12l6.813-6.814z'/>
          <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 002.5 15h11a1.5 1.5 0 001.5-1.5v-6a.5.5 0 00-1 0v6a.5.5 0 01-.5.5h-11a.5.5 0 01-.5-.5v-11a.5.5 0 01.5-.5H9a.5.5 0 000-1H2.5A1.5 1.5 0 001 2.5v11z' clip-rule='evenodd'/>
          </svg></button></td></tr></form>";
        }else{
            echo "<form method='POST' action='modificarPedidos.php'><td class='px-0'>
          <input type='hidden' name='idpedido' value=$fila[1]>
          <button type='submit' name='numped' class='btn btn-primary'>
          <svg class='bi bi-pencil-square' width='1em' height='1em' viewBox='0 0 16 16' fill='white'>
          <path d='M15.502 1.94a.5.5 0 010 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 01.707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 00-.121.196l-.805 2.414a.25.25 0 00.316.316l2.414-.805a.5.5 0 00.196-.12l6.813-6.814z'/>
          <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 002.5 15h11a1.5 1.5 0 001.5-1.5v-6a.5.5 0 00-1 0v6a.5.5 0 01-.5.5h-11a.5.5 0 01-.5-.5v-11a.5.5 0 01.5-.5H9a.5.5 0 000-1H2.5A1.5 1.5 0 001 2.5v11z' clip-rule='evenodd'/>
          </svg></button></td></tr></form>";
            
        }
    }
}
?>

</table></div></div>
		


</div></div></div>


<?php
include ('Nuevaautentificacion.php');
include('Nuevopie.php');
?>
