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

	<div class=" container ">
	<div class="row">
	<div class="col-7 bg-dark py-5">
	<div class="row">
	<div class="col-6 bg-danger">La mitad de 7</div>
	<div class="col-6 bg-success">La otra mitad</div>
	</div>
	</div>
	<div class="col-5" style="background:pink">
    <p class="text-white">This page uses frames.</p>
    </div></div></div>
    <?php 
    include("funciones.php");
    $conex = conectar();
    $consulta = $conex->prepare("SELECT * FROM articulos");
    $consulta->execute();
   // $consulta->setFetchMode(PDO::FETCH_CLASS,"articulos");
    while($fila = $consulta->fetch()){;
    echo $fila[1] . "<br>"; //->getPre_art(); 
    }
    
   echo "<br>". datos_usuario("Diego")->getPas_usr();
   conectar();
   buscar_articulo(1)->setDes_art("La peor cafetera del mundo");
   
   
    
    ?>
    
    
    
    </body>

</html>