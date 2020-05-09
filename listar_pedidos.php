<?php
session_start();
if(!isset($_SESSION['autenticado'])){
    header("location:index.php");
}
include_once('funciones.php');
include_once('validaciones.php');

$user = datos_usuario($_SESSION['autenticado'])->getId_usr();
$nom_pag = "Listado pedidos";

include('Nuevacabecera.php');
include('Nuevolateral.php');


echo "<div class='col-md-8'>";



if(isset($_POST['mispedidos'])){
    mis_pedidos("$user");
}



//if((datos_user($user)->getRol_usr() == 3) || (datos_user($user)->getRol_usr() == 4)){
//    mostrar_pedidos();}


echo "</div>";

include('Nuevaautentificacion.php');
include('Nuevopie.php');
?>

