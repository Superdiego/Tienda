<?php 
session_start();
if(!isset($_SESSION['autenticado'])){
    header("location:index.php");
}
include_once("funciones.php");
include_once("validaciones.php");
$nom_pag = "Bienvenido {$_SESSION['autenticado']}";
include_once("cabecera.php");
mostrar_articulos();
?>
</div>
			</div>
			<div class="col-sm-12 col-md-2">
			<a href="edicion_cliente.php">Editar perfil</a>
			</div>
		</div>
	</div>
</body>
</html>
