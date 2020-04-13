<?php
session_start();
include_once('funciones.php');
if(!isset($_SESSION['autenticado'])){
    header("location:index.php");
}else{
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if($admin->getRol_usr()!=3){
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
		<div class="container-fluid text-white pt-5 pb-1">
			<h1 class="display-4">Cachivaches</h1>
		</div></div>
		<h1>PAGINA DE EMPLEADO</h1>
		</body>
</html>