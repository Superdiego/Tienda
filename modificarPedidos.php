<?php
session_start();

include_once("funciones.php");
include_once("validaciones.php");

if (! isset($_SESSION['autenticado'])) {
    header("location:index.php");
} else {
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if (($admin->getRol_usr() != 4) && ($admin->getRol_usr() != 3)) {
        header("location:index.php");
    }
}




$ocultar = '';
$mostrar ='';
$err_pedido ='';
$msg_ok='';
$idpedido = (isset($_REQUEST['idpedido'])) ? $_REQUEST['idpedido'] : '';
if(isset($_GET['modiflin'])){
    $idpedido = $_GET['modiflin'];
    $msg_ok = 'PEDIDO MODIFICADO';
}
if(isset($_GET['bajalin'])){
    $idpedido = $_GET['bajalin'];
    $msg_ok = 'LINEA DE PEDIDO ELIMINADA';
}
if(isset($_GET['bajaped'])){
    $idpedido = $_GET['bajaped'];
    $msg_ok = 'PEDIDO ELIMINADO';
}
$idlinea = (isset($_POST['idlinea'])) ? $_POST['idlinea'] : '';
$pedido = mostrar_pedido($idpedido);
$cliente = busca_cliente($pedido[1]);
$fecha = ($pedido) ? getDate($pedido[2]) : '';


if(isset($_REQUEST['numped']) || isset($_POST['modiflin'])){
    if(empty(trim($idpedido))){
    $err_pedido = "El campo número de pedido está vacío";
    }else if (!ctype_digit($idpedido)){
    $err_pedido = "El campo número de pedido debe ser un número";
    }else{
    $err_pedido = (!$pedido) ? "No existe ningún pedido número $idpedido" : '';
    }
}
$err_idart = '';
$err_cant = '';
$err_pre = '';
if(isset($_POST['modiflin'])){
    $idart = $_POST['idart'];
    $articulo = buscar_articulo($idart);
    $linea = devuelve_linea($idpedido,$idlinea);
    $cant = $_POST['cantart'];
    $pre = $_POST['preart'];
    if(empty($idart)){
       $err_idart = 'El campo Id artículo está vacío o cero';
    }else if (!ctype_digit($idart)){
        $err_idart = 'El campo Id articulo deben ser números';
    }else{
        $err_idart = (!buscar_articulo($idart)) ? 'No existe artículo con ese Id' : '';
    }
    if(empty($cant)){
        $err_cant = 'El campo cantidad está vacio o cero';
    }else{
        $err_cant= (!ctype_digit($cant)) ? 'La cantidad debe ser un número entero' : '';
    }
    if(empty($pre)){
        $err_pre = 'El campo precio está vacio';
    }else{
        $err_pre= (!is_numeric($pre)) ? 'El precio debe ser una cifra' : '';
    }
    if(empty($err_idart) && empty($err_cant) && empty($err_pre)){      
        $oldcant = $linea->getCan_lin();
        $oldart = $linea->getArt_lin();
        descontar_stock($oldart, -$oldcant);
        descontar_stock($idart, $cant);
        modificar_linea($idpedido, $idlinea, $idart, $cant, $pre);        
        header("location:controlAlmacen.php?modiflin=$idpedido");
    }
}
if(isset($_POST['confbajalin'])){
    $linea = devuelve_linea($idpedido,$idlinea);
    $idart = $linea->getArt_lin();
    $oldcant = -$linea->getCan_lin();
    descontar_stock($idart, $oldcant);
    baja_linea($idpedido, $idlinea);
    if(cuenta_lineas($idpedido)==0){
        baja_pedido($idpedido);
        header("location:controlAlmacen.php?bajaped=$idpedido");
    }else{
    header("location:controlAlmacen.php?bajalin=$idpedido");
    }

}


if(isset($_POST['bajalin'])){
    $num = cuenta_lineas($idpedido);
    if($num>1){
        $mostrar="<h3>¿Seguro desea eliminar la linea $idlinea del pedido $idpedido?</h3><br>
                <div class='row justify-content-center '><form method='POST' action='modificarPedidos.php'>
                <input type='hidden' name='idpedido' value=$idpedido>
                <input type='hidden' name='idlinea' value=$idlinea>
                <input type='submit' class='btn btn-danger mb-5 mr-5' name='confbajalin' value='Confirmar baja'>
                <input type='submit' class='btn btn-secondary mb-5 mr-5' name='numped' value='Cancelar'></div></form>";
    }else{
        $mostrar="<h3>¿Seguro desea eliminar la linea $idlinea del pedido $idpedido?<br><h4>Se eliminará también 
                el pedido por no tener más lineas</h4><br>
                <div class='row justify-content-center '><form method='POST' action='modificarPedidos.php'>
                <input type='hidden' name='idpedido' value=$idpedido>
                <input type='hidden' name='idlinea' value=$idlinea>
                <input type='submit' class='btn btn-danger mb-5 mr-5' name='confbajalin' value='Confirmar baja'>
                <input type='submit' class='btn btn-secondary mb-5 mr-5' name='numped' value='Cancelar'></div></form>";
    }
}
$nom_pag = "Modificación pedidos";
include('Nuevacabecera.php');
include('Nuevolateral.php');
?>

<div class='col-md-8'>
<!-- 
<p class='text-danger'><?php echo $mostrar?></p>
<h2><?php echo $err_pedido?></h2>
<div >
<form method='POST' action='modificarPedidos.php'>
<label>Introduzca nº pedido: </label>
<input type='text' name='idpedido' value=<?php echo $idpedido?> >
<input type='submit' name='numped' class='btn btn-primary' value='Enviar' >
<label class='text-success font-weight-bold'><?php echo $msg_ok?></label>
</form><br>

<br><?php echo "<p class='text-danger'> $err_idart </p>
                <p class='text-danger'> $err_cant </p>
                <p class='text-danger'> $err_pre </p>";
?>

 </div>
 
  -->
<div class='mt-5'>
<?php

if($pedido){ echo "<h4>PEDIDO Nº $idpedido de fecha ".$fecha['mday']."/".$fecha['mon']."/".$fecha['year'].
            " Cliente: ".$cliente->getNom_usr()." ".$cliente->getApe_usr()." - Estado: ".
            devuelve_estado($pedido[3])[1]."</h4>";
    modificar_lineas($idpedido);
}
?>

</div>


</div>


<?php
//include('Nuevocentral.php');




include('Nuevaautentificacion.php');
include('Nuevopie.php');
?>