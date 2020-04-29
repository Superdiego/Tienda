<?php
session_start();
$nom_pag= "EDICION ARTICULOS";
include_once("funciones.php");
include_once("validaciones.php");

if(!isset($_SESSION['autenticado'])){
    header("location:index.php");
}else{
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if(($admin->getRol_usr()!=4) && ($admin->getRol_usr()!=3)){
        header("location:index.php");
    }
}

<form name='pedido'>
<label>Id_Ped:</label>
<label>Id_Cliente</label>
<label>Cliente:</label>
<label>Fecha:</label>
</form>
<form name='lineas'>
<label></label>
<label></label>
<label></label>
</form>