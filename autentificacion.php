<?php
include_once("funciones.php");
include_once("validaciones.php");

$nombre_usr = (isset($_POST['usuario'])) ? $_POST['usuario'] : null;
$pass_usr = (isset($_POST['password'])) ? $_POST['password'] : null;
$texorr = null;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!val_text($nombre_usr)){
        $texorr = "Debe introducir un nombre";
    }else if(!val_pass){
        $texorr = "El password debe contener cuatro caracteres";
    }else{
        buscar_usuario($nombre_usr, $pass_usr);
    }
}

?>
<h5>Inicio sesion</h5>
<form type="POST" action="index.php">	
  <div class="form-group">
  <p><?php echo $nombre_usr?></p>
    <label for="usuario">Usuario</label>
    <input type="text" class="form-control" name="usuario">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" name="password">
  </div>
  
  <button type="submit" class="btn btn-primary">Enviar</button>
</form>


