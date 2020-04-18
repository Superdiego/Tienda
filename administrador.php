<?php
session_start();
$nom_pag= "PAGINA DE ADMINISTRACION";
include_once("funciones.php");
include_once("validaciones.php");


if(!isset($_SESSION['autenticado'])){
    header("location:index.php");
}else{
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if($admin->getRol_usr()!=4){
        header("location:index.php");
    }
}
include_once("cabecera.php");
?>
<div class="row">
<div class="col-sm-6 col-xl-4">
		<a href="adminusers.php"><button class="bg-primary text-white py-3">
		<svg class="bi bi-people-fill width="2em" height="2em" viewBox="0 0 16 16" fill="white">
  			<path fill-rule="evenodd" d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 100-6 3 3 0 000 6zm-5.784 6A2.238 2.238 0 015 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 005 9c-4 0-5 3-5 4s1 1 1 1h4.216zM4.5 8a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" clip-rule="evenodd"/>
			</svg><span class="pl-2">Administrar usuarios</span></button></a>
</div>
<div class="col-sm-6 col-xl-4">			
		<a href="registroCategorias.php"><button class="bg-primary text-white py-3">
		<svg class="bi bi-bookmarks" width="2em" height="2em" viewBox="0 0 16 16" fill="white" >
  			<path fill-rule="evenodd" d="M7 13l5 3V4a2 2 0 00-2-2H4a2 2 0 00-2 2v12l5-3zm-4 1.234l4-2.4 4 2.4V4a1 1 0 00-1-1H4a1 1 0 00-1 1v10.234z" clip-rule="evenodd"/>
  			<path d="M14 14l-1-.6V2a1 1 0 00-1-1H4.268A2 2 0 016 0h6a2 2 0 012 2v12z"/>
			</svg><span class="pl-2">Administrar categorias</span></button></a>
</div>
<div class="col-sm-6 col-xl-4">
		<a href="adminArtic.php"><button class="bg-primary text-white py-3">
		<svg class="bi bi-grid-3x3-gap-fill" width="2em" height="2em" viewBox="0 0 16 16" fill="white" >
  			<path d="M1 2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1H2a1 1 0 01-1-1V2zm5 0a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1H7a1 1 0 01-1-1V2zm5 0a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1h-2a1 1 0 01-1-1V2zM1 7a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1H2a1 1 0 01-1-1V7zm5 0a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1H7a1 1 0 01-1-1V7zm5 0a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1h-2a1 1 0 01-1-1V7zM1 12a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1H2a1 1 0 01-1-1v-2zm5 0a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1H7a1 1 0 01-1-1v-2zm5 0a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1h-2a1 1 0 01-1-1v-2z"/>
			</svg><span class="pl-2">Administrar articulos</span></button></a>
</div>	
		</div></div>
		<div class="col-md-2">
			<?php include ("autentificacion.php")?>
			</div>
</div>
</div>
<?php include("pie.php")?>
</body>
</html>