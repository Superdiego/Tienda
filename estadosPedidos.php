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




$idped = (isset($_POST['idped']) || isset($_POST['estado'])) ? $_POST['idped'] : null;
$err_idped = "";
$texto ='';
if(isset($_POST['buscaped'])){
    if(empty(trim($idped))){
        $err_idped = "El campo id del pedido está vacío";
    }else if (!ctype_digit($idped)){
        $err_idped = "El campo id debe ser un número entero";
    }else{
        $err_idped = (!mostrar_pedido($idped)) ? "No existe el pedido número $idped" : null;
    }
    
}
if(isset($_POST['estado'])){
    $newestado = $_POST['newestado'];
    cambiar_estado($idped, $newestado);
    header("location:modificarPedidos.php?idpedido=$idped");
}
//include('Nuevocentral.php');
$nom_pag = "Modificación de pedidos";
include('Nuevacabecera.php');
include('Nuevolateral.php');
?>

<div class='col-md-8 mt-5'>
<div class='row justify-content-center'>
<form method='POST' action='estadosPedidos.php'>
<label>Introduzca Id. Pedido: </label>
<input type='text' size='4'name='idped' value='<?php echo $idped?>'>
<input class='btn btn-primary' type='submit' name='buscaped' value='Buscar'>
<br><span class='text-danger'><?php echo $err_idped?></span>

</form></div><div class='row justify-content-center mt-5'>
<?php 
if(isset($_POST['buscaped'])){
    if(empty($err_idped)){
        $pedido = mostrar_pedido($idped);
        $cliente = busca_cliente($pedido[1]);
        $oldestado = $pedido[3];
        $fecha = getDate($pedido[2]);
        $dia = $fecha['mday'];
        $mes = $fecha['mon'];
        $anyo = $fecha['year'];
        echo  "<h5>Pedido: $idped - Cliente: ". $cliente->getNom_usr()." ".$cliente->getApe_usr().
                " de fecha $dia/$mes/$anyo </h5><br></div><div class='row justify-content-center mt-2'>
                <form method='POST' action='estadosPedidos.php'>
                <input type='hidden' name='idped' value=$idped>
                <select name='newestado'><option ";
        if($oldestado==1){
            echo "selected";
        }
        echo " value='1'>Pedido</option><option ";
        if($oldestado==2){
            echo "selected";
        }
        echo " value='2'>Enviado</option><option ";
        if($oldestado==3){
            echo "selected";
        }
        echo " value='3'>Recibido</option><option ";
        if($oldestado==4){
            echo "selected";
        }
        echo " value='4'>Pagado</option></select>
              <input type='submit' class='btn btn-success ml-5' name='estado' value='Modificar'></form>";
    }
}


    ?>
</div></div>


<?php
//include('Nuevocentral.php');




include('Nuevaautentificacion.php');
include('Nuevopie.php');
?>