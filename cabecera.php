
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
			<div class="row">
				<div class="col-md-10">
					<p class="lead">Bienvenid@s a la tienda de Diego
					
					
					<p>
				
				</div>
				<div class="col-md-2">
					<a href="carro.php">
						<button class=" bg-primary  rounded float-right ">
							<svg class="rounded float-right " viewBox="0 0 32 32" width="32"
								height="32" fill="none" stroke="white" stroke-linecap="round"
								stroke-linejoin="round" stroke-width="2">
    				<path d="M6 6 L30 6 27 19 9 19 M27 23 L10 23 5 2 2 2" />
    				<circle cx="25" cy="27" r="2" />
   		 			<circle cx="12" cy="27" r="2" />
				</svg>
						</button>
					</a>
				</div>
			</div>

		</div>
	</div>
	</div>
	<div class="container-fluid bg-primary">
		<nav class="navbar navbar-expand-lg navbar-dark">
			<button class="navbar-toggler" type="button" data-toggle="collapse"
				data-target="#navbarNav" aria-controls="navbarNav"
				aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
					<li class="nav-item"><a class="nav-link" href="productos.php">Productos</a></li>
					<li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
					<li class="nav-item"><a class="nav-link"
						href="registroClientes.php">Registro</a></li>
				</ul>
			</div>
		</nav>
	</div>
	<div class="container text-center mt-4">
		<h1><?php echo $nom_pag ?></h1>
	</div>
	<div class="container-fluid">
		<div class="row text-center">
			<div class="col-md-2">

				<ul class="nav flex-column nav-pills" id="v-pills-tab"
					role="tablist" aria-orientation="vertical">
		<?php
include_once ("funciones.php");
$categ = mostrar_categorias();
foreach($categ as $cat) {
    echo '<li class="nav-item">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
						role="button" aria-haspopup="true" aria-expanded="false">' . $cat[1] . '</a>
						<div class="dropdown-menu">';
    $subcateg = mostrar_subcategorias($cat[0]);
    foreach($subcateg as $subcat) {
        echo '<a class="dropdown-item" href="Subcategorias.php?sub='.$subcat[2]. '">' . $subcat[2] . '</a>';
    }
    echo '</div></li>';

			}
        ?>
				</ul>
			</div>
			<div class="col-md-8">