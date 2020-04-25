
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



echo "";
if(!isset($_SESSION['autenticado'])){
echo "<h5>Inicio sesión</h5><form method='POST' action='control.php'>	
  <div class='form-group'>
    <label for='usuario'>Usuario</label>
    <input type='text' class='form-control' name='usuario' value='$nombre_usr'>
  </div>
  <div class='form-group'>
    <label for='password'>Password</label>
    <input type='password' class='form-control' name='password'>
  </div>
  
  <button type='submit' class='btn btn-primary'>Enviar</button>
</form><br></div>";

}

 
if(isset($_SESSION['autenticado'])){
    $nick = $_SESSION['autenticado'];
    $user = datos_usuario($nick);
    $idrol = $user->getRol_usr();
    echo "<h5>".$user->getNom_usr()."</h5><a href='edicion_cliente.php'><button>Modificar datos</button></a><br><br>
        <form action='control.php' method='POST'><input type='submit' name='salir' value='Abandonar sesión'></form><br><br>";
    if($idrol == 3){
        echo "<a href='empleado.php'><button>Menú empleado</button></a><br>";
    }
    if($idrol == 4){
        echo "<a href='administrador.php'><button>Menú administrador</button></a><br>";
    }
}

?>
</form>




