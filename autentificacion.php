<?php
include_once("funciones.php");
include_once("validaciones.php");

$nombre_usr = (isset($_POST['usuario'])) ? $_POST['usuario'] : null;
$pass_usr = (isset($_POST['password'])) ? $_POST['password'] : null;
$titulo = "Inicio sesion";

if((isset($_POST['usuario']))) {
    if(!val_texto($nombre_usr)){
        $titulo = "Debe introducir un nombre";
    }else if(!val_pass($pass_usr)){
        $titulo = "El password debe contener tres caracteres";
    }else{
        buscar_usuario($nombre_usr, $pass_usr);
    }
}

?>
<h5><?php echo $titulo?></h5>
<form method="POST" action="index.php">	
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


