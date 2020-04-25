<?php
include_once('validaciones.php');
include_once('funciones.php');

if(isset($_POST['solocat'])){
    if(!val_texto($_POST['solocat'])){
        header('location:registroCategorias.php?errcat=cat');
    }else{
        $nombre = $_POST['solocat'];
        $registro = registrar_categoria($nombre);
        header('location:registroCategorias.php?reg=cat');
    }
}

if(isset($_POST['subcategoria'])){
    $msgcat = empty($_POST['categoria']) ? "cat" : "";
    $msgsub = empty($_POST['subcategoria']) ? "sub" : "";
    header("location:registroCategorias.php?errsub=$msgcat$msgsub");
}
if(isset($_POST['subcategoria'])){
    if(!empty($_POST['categoria']) && !empty($_POST['subcategoria'])){
        $subcategoria = $_POST['subcategoria'];
        $categoria = $_POST['categoria'];
        $registro = registrar_subcategoria($categoria,$subcategoria);
        header("location:registroCategorias.php?reg=sub");
    }
}

if(isset($_POST['bodificat'])){
    if(isset($_POST['modificat'])){
        $id_cat = $_POST['modificat'];
            header("location:registroCategorias.php?modifcat=$id_cat");
        }else{
    header("location:registroCategorias.php?errmodif=cat");
        }
            
}

if(isset($_POST['confmodif'])){
    $nommodif = $_POST['confmodif'];
    $idcat = $_POST['idcat'];
    if(!val_texto($nommodif)){
        header("location:registroCategorias.php?modifcat=$idcat&errnommodif=cat");
    }else{
        $registrar = modificar_categoria($nommodif,$idcat);
        header("location:registroCategorias.php");
    }
}

if(isset($_POST['modifsub'])){
    if(!isset($_POST['catsubcat'])){
        header('location:registroCategorias.php?errmodifsub=sub');
    }else{
        $ids = $_POST['catsubcat'];
        $dato = explode(",",$ids);
        $idcat=$dato[0];
        $idsub= $dato[1];
        header("location:registroCategorias.php?modifsub=sub&cat=$idcat&sub=$idsub");
    }
}

if (isset($_POST['confmodifsub'])){
    $catsubcat = $_POST['nomsub'];
    $idcat=$_POST['idcat'];
    $idsub= $_POST['idsub'];
    if(!val_texto($catsubcat)){
        header("location:registroCategorias.php?modifsub=sub&cat=$idcat&sub=$idsub&errnomsub=sub");
    }else{
        $modificado = modificar_subcategoria($catsubcat,$idcat, $idsub);
        if ($modificado){
            header("location:registroCategorias.php?registrado=si");
        }else{
            header("location:registroCategorias.php?registrado=no");
        }
    }
}

if (isset($_POST['bajacat'])){
    if(isset($_POST['modificat'])){
    $id_cat = $_POST['modificat'];
    header("location:registroCategorias.php?bajacat=$id_cat");
    }else{
    header("location:registroCategorias.php?errmodif=cat");
    }
}
if (isset($_POST['confbajacat'])){
    $id_cat = $_POST['idbajacat'];
    $subcat = mostrar_subcategorias($id_cat);
    if(empty($subcat)){
        borrar_categoria($id_cat);
        header('location:registroCategorias.php?okbajacat=$id_cat');
    }else{
        $url=count($subcat);
        header("location:registroCategorias.php?errconfbajacat=$id_cat&count=$url");
    }
}

if(isset($_POST['bajasub'])){
    if(isset($_POST['catsubcat'])){
        $ids = $_POST['catsubcat'];
        $dato = explode(",",$ids);
        $idcat=$dato[0];
        $idsub= $dato[1];
        header("location:registroCategorias.php?bajasub=$idsub&cat=$idcat");
    }else{
        header('location:registroCategorias.php?errmodifsub=sub');
    }
}

if (isset($_POST['confbajasub'])){
    $idcat= $_POST['idcat'];
    $idsub= $_POST['idsub'];
    $articulos = cargar_articulos($idcat, $idsub);
        if(empty($articulos)){
            $url = count($articulos);
           borrar_subcategoria($idcat,$idsub);
           
           header("location:registroCategorias.php?okbajasub=$idsub&cat=$idcat&count=&url");
        }else{
            $url = count($articulos);
            header("location:registroCategorias.php?errconfbajasub=$idsub&cat=$idcat&count=$url");
    }
}





?>