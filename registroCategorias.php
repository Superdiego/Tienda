<?php

include("funciones.php");
include("validaciones.php");


$nombre = (isset ($_POST['nombre'])) ? $_POST['nombre'] : '';


?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>ALTA DE CATEGORIAS</h1>
<br><br>
<form method="POST" action="registroCategorias.php">
Nombre nueva categoria: <input type="text" name="nombre" value="<?php echo $nombre?>">
<br><br>
<input type="submit" value="Insertar nueva categoria">
</form>
<?php 
if($_SERVER['REQUEST_METHOD']=='POST'){

    if(val_texto($nombre)){
        registrar_categoria($nombre);   
    }
}
?>

</body>
</html>