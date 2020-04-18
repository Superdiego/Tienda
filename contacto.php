<?php
session_start();
$nom_pag = "Contacto";
include_once("funciones.php");
include_once("validaciones.php");
include_once("cabecera.php");
?>
<div class='row'>

<div class='container'>
<div class= ' row row-cols-1 row-cols-md-2'>
<div class='card py-5 bg-light px-3'><h3 class='text-center'>Confianza </h3><p>Adquirir productos en nuestra web sera una experiencia que jamas olvidara. Garantizado.</p></div>
<div class='card py-5 bg-light px-3'><h3 class='text-center'>Tienda fisica situada en:</h3><p>C/ La estafa, 34 Cod.Postal 6666 Timolandia PANAMA</p></div>
<div class='card py-5 bg-light px-3'><h3 class='text-center'>Webs asociadas</h3><p>Buscandoganzuas.com Abrecualquierpuerta.es Serpoliticoconcienpalabras.com</p></div>




</div></div></div></div>
<div class="col-md-2">
<?php include ("autentificacion.php")?>
			</div>
</div>
</div>
<?php include("pie.php")?>
</body>
</html>
