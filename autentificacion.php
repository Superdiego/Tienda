
<?php
include_once("funciones.php");
include_once("validaciones.php");
include_once("control.php");

$nombre_usr = (isset($_GET['usr'])) ? $_GET['usr'] : null;
$titulo = "Inicio sesion";
$ver= null;
$nover = "hidden";

if((isset($_GET['error']))) {
    switch($_GET['error']){
        case 1:
            $titulo = "Debe introducir un nombre";
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
?>
<?php

if(isset($_SESSION['autenticado'])){
    $ver= "hidden";
    $nover = null;
    $titulo = $_SESSION['autenticado'];
}
echo "<h5> $titulo </h5>";
?>
<form method="POST" action="control.php" <?php echo $ver?> >	
  <div class="form-group">
 
    <label for="usuario">Usuario</label>
    <input type="text" class="form-control" name="usuario" value="<?php echo $nombre_usr?>">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" name="password">
  </div>
  
  <button type="submit" class="btn btn-primary">Enviar</button>
</form><br>

<a href="edicion_cliente.php" <?php echo $nover?>><button>Modificar datos</button></a><br><br>
<form method="POST" action="control.php" <?php echo $nover?>>
<input type="text" name="salir" value="1" hidden>
<input type="submit" value="Abandonar sesion" >
</form>




