<?php
include_once("funciones.php");
include_once("validaciones.php");
include_once("control.php");

$nombre_usr = (isset($_POST['usuario'])) ? $_POST['usuario'] : null;
$pass_usr = (isset($_POST['password'])) ? $_POST['password'] : null;
$titulo = "Inicio sesion";

if((isset($_GET['error']))) {
    if($_GET['error'] == 1){
        $titulo = "Debe introducir un nombre";
    }else if($_GET['error'] == 2){
        $titulo = "El password debe contener tres caracteres";
    }else if($_GET['error'] == 3){
        $titulo = "Password equivocado";
    }else if($_GET['error'] == 4){
        $titulo = "Usuario no registrado";
    }
}
?>
<h5><?php echo $titulo?></h5>
<form method="POST" action="control.php">	
  <div class="form-group">
 
    <label for="usuario">Usuario</label>
    <input type="text" class="form-control" name="usuario" value="<?php echo $nombre_usr?>">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" name="password">
  </div>
  
  <button type="submit" class="btn btn-primary">Enviar</button>
</form>


