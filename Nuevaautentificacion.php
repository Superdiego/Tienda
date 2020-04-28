<?php
include_once("funciones.php");
include_once("validaciones.php");
include_once("control.php");


$nombre_usr = (isset($_GET['usr'])) ? $_GET['usr'] : null;


if((isset($_GET['error']))) {
    switch($_GET['error']){
        case 1:
            $titulo = "El nombre debe comenzar con una letra";
            break;
        case 2:
            $titulo = "El password debe contener tres caracteres";
            break;
        case 3:
            $titulo = "Password equivocado";
            break;
        case 4:
            $titulo = "Usuario no registrado";
    }
}

echo "<div class='col-md-2'><div class='container'>";

if(!isset($_SESSION['autenticado'])){
    echo "<div class='row justify-content-center'>
    <div><h5 class='text-center'>Inicio sesión</h5></div>
    <div><form method='POST' action='control.php'>
    <div class='form-group'>
    <label for='usuario'>Usuario</label>
    <input type='text' class='form-control' name='usuario' value='$nombre_usr'>
    </div>
    <div class='form-group'>
    <label for='password'>Password</label>
    <input type='password' class='form-control' name='password'>
    </div>
  
    <button type='submit' class='btn btn-primary'>Enviar</button>
    </form></div><br>";
    
}


if(isset($_SESSION['autenticado'])){
    $nick = $_SESSION['autenticado'];
    $user = datos_usuario($nick);
    $idrol = $user->getRol_usr();
    echo "<div class='row justify-content-center pb-3'><h5>".$user->getNom_usr()."</h5></div>
        <div class='row justify-content-center pb-3'><a href='edicion_cliente.php'><button>Modificar perfil</button></a></div>
        <div class='row justify-content-center pb-3'><form action='control.php' method='POST'>
        <input type='submit' name='salir' value='Abandonar sesión'></form></div>
        <div class='row justify-content-center pb-3'><form action='listar_pedidos.php' method='POST'>
        <button type='submit' name='mispedidos' value='".$user->getId_usr()."'>Mis pedidos</button></div></form>";
    if($idrol == 3){
        echo "<div class='row justify-content-center'><a href='empleado.php'><button>Menú empleado</button></a></div>";
    }
    if($idrol == 4){
        echo "<div class='row justify-content-center'><a href='administrador.php'><button>Menú administrador</button></a></div>";
    }

}
echo "</div></div></div>";
?>

