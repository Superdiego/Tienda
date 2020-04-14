<?php
session_start();
include_once('funciones.php');
if(!isset($_SESSION['autenticado'])){
    header("location:index.php");
}else{
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if($admin->getRol_usr()!=4){
        header("location:index.php");
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="bootstrap/bootstrap.css">
<!--  <link rel="stylesheet" type="text/css" href="estilo.css"> -->
<title>Cachivaches</title>

</head>
<body>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
		integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
		crossorigin="anonymous"></script>
	<script
		src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
		integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
		crossorigin="anonymous"></script>
	<script src="bootstrap/bootstrap.js"></script>

	<div class="container-fluid bg-primary">
		<div class="container-fluid pt-5 pb-1">
			<a href="index.php"><h1 class="display-4 text-white">Cachivaches</h1></a>
		</div></div>
		<h1 class="text-center py-5">PAGINA DE ADMINISTRADOR</h1>
		<a href="adminusers.php"><button class="bg-primary text-white">
		<svg class="bi bi-people-fill width="2em" height="2em" viewBox="0 0 16 16" fill="white">
  			<path fill-rule="evenodd" d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 100-6 3 3 0 000 6zm-5.784 6A2.238 2.238 0 015 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 005 9c-4 0-5 3-5 4s1 1 1 1h4.216zM4.5 8a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" clip-rule="evenodd"/>
			</svg><span class="pl-2">Administrar usuarios</span></button></a>
		<a href="registroCategorias.php"><button class="bg-primary text-white">
		<svg class="bi bi-bookmarks" width="2em" height="2em" viewBox="0 0 16 16" fill="white" >
  			<path fill-rule="evenodd" d="M7 13l5 3V4a2 2 0 00-2-2H4a2 2 0 00-2 2v12l5-3zm-4 1.234l4-2.4 4 2.4V4a1 1 0 00-1-1H4a1 1 0 00-1 1v10.234z" clip-rule="evenodd"/>
  			<path d="M14 14l-1-.6V2a1 1 0 00-1-1H4.268A2 2 0 016 0h6a2 2 0 012 2v12z"/>
			</svg><span class="pl-2">Administrar categorias</span></button></a>
		<a href="adminartic.php"><button>Administrar articulos</button></a>
		</body>
</html>