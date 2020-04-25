<?php
session_start();
include_once ('funciones.php');
include_once ("validaciones.php");
$nom_pag = "";

if (! isset($_SESSION['autenticado'])) {
    header("location:index.php");
} else {
    $usr = $_SESSION['autenticado'];
    $admin = datos_usuario($usr);
    if (($admin->getRol_usr() != 4) && ($admin->getRol_usr() != 3)) {
        header("location:index.php");
    }
}
include_once ("cabecera.php");

?>
<div class="row">
	<div class="col-sm-5  pt-3 bg-light">
		<h3 class="pb-3">ALTA Categorias</h3>
		<form method="POST" action="controlCategorias.php">
			<p>Nombre nueva categoria:</p>
			<input type="text" name="solocat">
			<p class="pt-2">
			<?php
if (isset($_GET['errcat']) && ($_GET['errcat'] == 'cat')) {
    echo "<span class='error'>El nombre debe empezar con una letra</span>";
}
?>
			</p>
			<br> <br> <input class="bg-primary text-white py-2" type="submit"
				value="Insertar nueva categoria">
		</form>
		<br> <br>
	</div>
	<div class="col-sm-1"></div>
	<div class="col-sm-6 pt-3 bg-light">
		<h3 class="pb-3">ALTA Subcategorias</h3>
		<p class="text-left">Categoria:
		
		
		<p>
		
		
		<form method="POST" action="controlCategorias.php" name="registcateg">
			<?php
$alert = "";
if (isset($_GET['errsub']) && ($_GET['errsub'] == 'catsub' || $_GET['errsub'] == 'cat')) {
    $alert = "class='bg-warning'";
}
?>
		<div class="text-left ">
				<select class='custom-select' name='categoria' <?php echo $alert ?>>
					<option disabled selected>Seleccione una categoria</option>
                    <?php menu_categorias()?>
                    </select>
			</div>
			<p>
                    <?php
                    if (isset($_GET['reg']) && (($_GET['reg'] == 'cat'))) {
                        echo "<span>Registro correcto</span>";
                    }
                    ?>
                    </p>
			<div class="text-right pt-4 pb-3">
				<label>Nombre nueva subcategoría:</label> <input type="text"
					name="subcategoria">
				<p>
            <?php
            if (isset($_GET['errsub']) && (($_GET['errsub'] == 'sub') || ($_GET['errsub'] == 'catsub'))) {
                echo "<span class='error'>El nombre debe empezar con una letra</span>";
            }
            ?>
            <?php
            if (isset($_GET['reg']) && (($_GET['reg'] == 'sub'))) {
                echo "<span>Registro correcto</span>";
            }
            ?>
            </p>
				<br>
				<button class="bg-primary text-white py-2" type="submit" value="">Registrar
					nueva categoría</button>
			</div>
		</form>
	</div>


	<!--  -------------EDICION CATEGORIAS ------------------------------------- -->


	<div class="col-sm-5 mt-4 pt-3 bg-light">
		<h3 class="pb-3">EDICIÓN Categorias</h3>
		<form method="POST" action="controlCategorias.php">
		<?php
$vista = "";
if (isset($_GET['modifcat'])) {
    $vista = "hidden";
    echo "<p class='bg-warning'>Modifique el nombre:</p>";
}
if (isset($_GET['bajacat'])) {
    $vista = "hidden";
    $idcat = $_GET['bajacat'];
    echo "<p>¿Confirmar baja de la categoría <b>".devuelve_categoria($idcat)[1]."</b>?<p>";
}
if(isset($_GET['errconfbajacat'])){
    $vista = "hidden";
    $idcat = $_GET['errconfbajacat'];
    $nomcat = devuelve_categoria($idcat)[1];
    $count = $_GET['count'];
    echo "No puede eliminar <span class='font-weight-bolder'>$nomcat </span><br>porque contiene $count subcategorías<br>"; 
}
if(isset($_GET['okbajacat'])){
    $idcat = $_GET['okbajacat'];
    $nomcat = leer_categoria($idcat);
    $vista = "hidden";
    echo "Ha eliminado $nomcat de las categorías";
    
}
?>      
			<p <?php echo $vista ?>></p>
			<?php
$alert = "";
if (isset($_GET['errmodif']) && ($_GET['errmodif'] == 'cat')) {
    $alert = "bg-warning";
}
?>
	<select class='custom-select <?php echo $alert ?>' name='modificat' <?php echo $vista ?>>
		<option disabled selected>Seleccione una categoria</option>
<?php menu_categorias(); ?>
    </select>

                    <?php
                    if (isset($_GET['modifcat'])) {
                        $idcat = $_GET['modifcat'];
                        echo "</p><input type='hidden' name='idcat' value=$idcat>
                        <input type='text' value='" . devuelve_categoria($idcat)[1] . "'name='confmodif'><br>";
                        if (isset($_GET['errnommodif'])) {
                            echo "<p>El nombre debe empezar con una letra</p>";
                        }

                        echo "<button class='bg-primary text-white m-2 p-2' type='submit'>Confirmar</button>   
                        <button class='bg-primary text-white m-2 p-2' >
                        <a class='text-white' href='registroCategorias.php'>
                        Cancelar</a></button><br>";
                    }
                    if (isset($_GET['bajacat'])) {
                        $idcat = $_GET['bajacat'];
                        echo "<button class='bg-primary text-white m-2 p-2' type='submit' name='confbajacat'>
                        Confirmar baja</button>
                        <button class='bg-primary text-white m-2 p-2' >
                        <a class='text-white' href='registroCategorias.php'>
                        Cancelar</a></button><br>";
                        echo "</p><input type='hidden' name='idbajacat' value=$idcat>";
                        }
                        if(isset($_GET['errconfbajacat'])){                           
                            echo "<button class='bg-primary text-white m-2 p-2' >
                            <a class='text-white' href='registroCategorias.php'>
                            Cancelar</a></button>";
                        }

                    ?>         
			<br>
			<button name='bodificat' <?php echo $vista ?>
				class="bg-primary text-white m-2 p-2" type="submit">Modificación</button>
			<button <?php echo $vista ?> class="bg-primary text-white m2 p-2"
				type="submit" name='bajacat'>Baja</button>
		</form>

	</div>
	<div class="col-sm-1"></div>
	
<!-- -----------------------EDICION SUBCATEGORIAS ------------------>
<div class="col-sm-6 mt-4 pt-3 bg-light">
		<h3 class="pb-3">EDICION Subcategorias</h3>

		<form method="POST" action="controlCategorias.php"
			name="registsubcateg">			
		<?php
$errcatsubcat = "";
$mostrar = "";
if (isset($_GET['errmodifsub']) && $_GET['errmodifsub'] == 'sub') {
    $errcatsubcat = "bg-warning";
}
if (isset($_GET['modifsub']) || isset($_GET['bajasub']) || isset($_GET['errconfbajasub'])){
    $mostrar = "hidden";
}
if(isset($_GET['okbajacat'])){
    $idcat = $_GET['okbajacat'];
    $nomcat = leer_categoria($idcat);
    $mostrar = "hidden";
    echo "Ha eliminado $nomcat de las categorías";
    
}

?>
 
	<select class='custom-select  <?php echo $errcatsubcat ?>' name='catsubcat' <?php echo $mostrar?>>

					<option disabled selected>Elija categoria - subcategoria</option>";
    <?php

$lista = listadesubcategorias();
    foreach ($lista as $sub) {
        echo "<option value='" . $sub[0] . "," . $sub[1] . "'>" . leer_categoria($sub[0]) . "&nbsp; &nbsp;" . $sub[2] . "</option>";
    }
    echo "</select>"?> 
    
    	<?php

if (isset($_GET['modifsub'])) {
        $idcat = $_GET['cat'];
        $idsub = $_GET['sub'];
        echo "</p><input type='hidden' name='idcat' value=$idcat><input type='hidden' name='idsub' value=$idsub>
                        <input type='text' readonly class='bg-light' value='" . devuelve_categoria($idcat)[1] . "'name='nomcat'><br>
                        <p class='mt-2'>Modifique el nombre:
                        <input type='text' value='" . devuelve_subcategoria($idcat, $idsub)[2] . "' name='nomsub'></p>";
        if (isset($_GET['errnommodifsub'])) {
            echo "<p>El nombre debe empezar con una letra</p>";
        }
        if(isset($_GET['errnomsub'])){
            echo "El nombre debe de empezar con una letra";
        }
        echo "<button class='bg-primary text-white m-2 p-2' name ='confmodifsub' type='submit'>Confirmar</button>   
                        <button class='bg-primary text-white m-2 p-2'>
                        <a class='text-white' href='registroCategorias.php'>
                        Cancelar</a></button><br>";
    }
    
    if(isset($_GET['bajasub'])){
        $idcat = $_GET['cat'];
        $idsub = $_GET['bajasub'];
        $nomsub = devuelve_subcategoria($idcat, $idsub);
        echo "<input type='hidden' name='idcat' value=$idcat>
              <input type='hidden' name='idsub' value=$idsub>
            <span >
            <input style:'float-left' size= 25 type='text' readonly class='bg-light pl-2' value='" . devuelve_categoria($idcat)[1] . "'name='nomcat'> </span>
            <br><p >¿Confirmar baja de la subcategoría <b>$nomsub[2]</b>?</p>
            <button class='bg-primary text-white p-2' name ='confbajasub' type='submit'>Confirmar</button>   
            <button class='bg-primary text-white p-2'>
            <a class='text-white' href='registroCategorias.php'>
            Cancelar</a></button><br>";
    }
    
    ?>
    
    <?php 
    if(isset($_GET['registrado'])){
        if ($_GET['registrado'] =='si'){
            echo "Modificacion realizada";
        }else{
            echo "Error en la modificación realizada";
            }
    }
    ?>
                    

    
            <br>
				<button class="bg-primary text-white m-2 p-2" type="submit"
						name="modifsub" <?php echo $mostrar?>>Modificación</button>
					<button class="bg-primary text-white m2 p-2" type="submit" name="bajasub"
						<?php echo $mostrar?>>Baja</button>
			
			
			<?php 
			if(isset($_GET['errconfbajasub'])){
			    $idcat=$_GET['cat'];
			    $idsub=$_GET['errconfbajasub'];
			    $nomsub= devuelve_subcategoria($idcat, $idsub);
			    $nomcat = leer_categoria($idcat);
			    $count = $_GET['count'];
			    echo "No puede eliminar <b> $nomsub[2] </b> de la categoría $nomcat porque contiene $count artículos
			    <br><button class='bg-primary text-white m-2 p-2' >
                            <a class='text-white' href='registroCategorias.php'>
                            Cancelar</a></button>";
			}
			if (isset($_GET['okbajasub'])){
			    $idcat = $_GET['cat'];
			    $idsub = $_GET['okbajasub'];
			    $nomsub= devuelve_subcategoria($idcat, $idsub);
			    $nomcat = leer_categoria($idcat);
			    echo "La subcategoría $nomsub[2] de la categoría $nomcat ha sido eliminada"; 
			}
			?>
			</div>
		</form>
	</div>
	

	<!-- AUTENTIFICACION Y PIE-->


</div>
<div class="col-md-2">
			<?php include ("autentificacion.php")?>
			</div>
</div>
</div>
<?php include("pie.php")?>
</body>
</html>