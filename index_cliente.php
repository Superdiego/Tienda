<?php 
session_start();
if(!isset($_SESSION['autenticado']))
    header("location:index.php");
?>

<h1>Por fin!!!!! Bienvenido <?php echo $_SESSION['autenticado']; ?></h1>