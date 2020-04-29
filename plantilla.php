<?php
session_start();
include_once("funciones.php");
include_once("validaciones.php");
if (! isset($_SESSION['autenticado'])) {
    header("location:index.php");
} else {
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if (($admin->getRol_usr() != 4) && ($admin->getRol_usr() != 3) && ($admin->getRol_usr() != 2)) {
        header("location:index.php");
    }
}

include_once("funciones.php");
include_once("validaciones.php");
$nom_pag = "Almacén";
include('Nuevacabecera.php');
include('Nuevolateral.php');


//include('Nuevocentral.php');

?>

<div class='col-md-8'>







</div>


<?php
//include('Nuevocentral.php');




include('Nuevaautentificacion.php');
include('Nuevopie.php');
?>