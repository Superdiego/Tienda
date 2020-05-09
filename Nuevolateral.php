

	<div class="col-md-2 text-center">

		<ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
			aria-orientation="vertical">
<?php
include_once ("funciones.php");
$categ = mostrar_categorias();
foreach ($categ as $cat) {
    if(articulos_categoria($cat[0])>0){
        echo '<li class="nav-item">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
						role="button" aria-haspopup="true" aria-expanded="false">' . $cat[1] . '</a>
						<div class="dropdown-menu">';
        $subcateg = mostrar_subcategorias($cat[0]);
        foreach ($subcateg as $subcat) {
            if(articulos_subcategoria($cat[0], $subcat[1])>0){
                echo '<a class="dropdown-item" href="Subcategorias.php?sub=' . $subcat[2] . '">' . $subcat[2] . '</a>';
            }
        
        }
        echo '</div></li>';
    }
}
?>
	</ul>
	</div>