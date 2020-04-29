<?php
session_start();

include_once("funciones.php");
include_once("validaciones.php");
/*
if (! isset($_SESSION['autenticado'])) {
    header("location:index.php");
} else {
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if (($admin->getRol_usr() != 4) && ($admin->getRol_usr() != 3) && ($admin->getRol_usr() != 2)) {
        header("location:index.php");
    }
}
*/
$nom_pag = "Almacén";
include('Nuevacabecera.php');
include('Nuevolateral.php');


//include('Nuevocentral.php');

?>


<?php 
$mov = movimientos_articulo(5);
$alm = movimientos_almacen(5);


foreach($alm as $fila){
    $fila[0] = strtotime($fila[0]);
    $todo[] = $fila;

}

foreach($mov as $fila){
    
    $cliente = busca_cliente($fila[2]);
    $fila[2] = $cliente->getNom_usr() . " ".$cliente->getApe_usr();
    $fila[3] = -$fila[3];
    $todo[] = $fila;

}





usort($todo, 'ordenando_fechas');
    function ordenando_fechas($a,$b){
        return ($a[0]) - ($b[0]);
    }
    
?>
 
    <div class='col-md-8'>
    <table class='table table-striped text-center'>
    	<thead><tr>
    		<th scope="col">Fecha</th><th scope="col">Nº pedido</th><th scope="col">Cliente</th>
    		<th scope="col">Cantidad</th><th scope="col">Stock</th>
    	</tr></thead>
<?php
    $stock = 0;
    foreach($todo as $fila){
        $stock += $fila[3];
        $fila[0] = date('d/m/y', $fila[0]);
        $todo[] = $fila;        
    echo "<tr><td>$fila[0]</td><td>$fila[1]</td>
		<td>$fila[2]</td><td>$fila[3]</td><td>$stock</td></tr>";
    
    }
?>





</table></div>


<?php





include('Nuevaautentificacion.php');
include('Nuevopie.php');
?>
