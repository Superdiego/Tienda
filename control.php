<?php

include_once("validaciones.php");
include_once("funciones.php");
$nombre_usr = (isset($_POST['usuario'])) ? $_POST['usuario'] : null;
$pass_usr = (isset($_POST['password'])) ? $_POST['password'] : null;
$salir = (isset($_POST['salir'])) ? $_POST['salir'] : null;
$titulo = "Inicio sesion";

if((isset($_POST['usuario']))) {
    if(!val_texto($nombre_usr)){
        header("location:index.php?error=1");
    }else if(!val_pass($pass_usr,$pass_usr)){
        header("location:index.php?error=2&usr=$nombre_usr");
    }else{
        switch(buscar_usuario($nombre_usr, $pass_usr)){
            case 0:
                session_start();
                $_SESSION['autenticado']="$nombre_usr";
                header("location:".$_SERVER['HTTP_REFERER']);
                break;
            case 1:
                header("?error=3&usr=$nombre_usr");
                break;
            case 2:
                header("location:index.php?error=4&usr=$nombre_usr");
                break;
            case 3:
                header("location:empleado.php");
                break;
            case 4:
                header("location:administrador.php");
                break;
            case 5:
                header("location:index.php");
        }
    }
}
if(isset($_POST["salir"])){
    if($_POST["salir"]==1){
        session_start();
        session_destroy();
        header("location:".$_SERVER['HTTP_REFERER']);
            
    }else{
        echo "no va";
    }
}
?>
