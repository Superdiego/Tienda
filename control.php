<?php
include_once("validaciones.php");
include_once("funciones.php");
$nombre_usr = (isset($_POST['usuario'])) ? $_POST['usuario'] : null;
$pass_usr = (isset($_POST['password'])) ? $_POST['password'] : null;
$titulo = "Inicio sesion";
if((isset($_POST['usuario']))) {
    if(!val_texto($nombre_usr)){
        header("location:index.php?error=1"); //$titulo = "Debe introducir un nombre";
    }else if(!val_pass($pass_usr,$pass_usr)){
        header("location:index.php?error=2&usr=$nombre_usr"); //$titulo = "El password debe contener tres caracteres";
    }else{
        switch(buscar_usuario($nombre_usr, $pass_usr)){
            case 0:
                session_start();
                $_SESSION['autenticado']="$nombre_usr";
                header("location:index_cliente.php");
                break;
            case 1:
                header("location:index.php?error=3&usr=$nombre_usr");
                break;
            case 2:
                header("location:index.php?error=4&usr=$nombre_usr");
        }
    }
}
?>
