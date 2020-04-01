<?php

function conectar(){
    try{
        $conex = new PDO("mysql:dbname=tienda;host=localhost","jefe","jefe");
        $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conex;
        
    }catch(PDOException $e){
        echo $e->getMessage();
    }   
}

function registrar_clientes($nic,$dni,$nom,$ape,$dir,$loc,$pro,$ema,$tel,$pas){
    $conex = conectar();
    $codigo = "INSERT INTO usuarios (rol_usr,nic_usr,dni_usr,nom_usr,ape_usr,dir_usr,loc_usr,pro_usr,
                                     ema_usr,tel_usr,pas_usr,act_usr) 
               VALUES (:rol,:nic,:dni,:nom,:ape,:dir,:loc,:pro,:ema,:tel,:pas,:act);";
    $insert = $conex->prepare($codigo);
    try{
        $fila = $insert->execute(array(':rol'=>2,':nic'=>$nic,':dni'=>$dni,':nom'=>$nom,':ape'=>$ape,':dir'=>$dir,
            ':loc'=>$loc,':pro'=>$pro,':ema'=>$ema,':tel'=>$tel,':pas'=>$pas,':act'=>1));
    
        if($fila==1){
        echo "<br>Registro completado";
        }
    }catch(PDOException $e){
        echo "<br><span class='error'>Este DNI ya esta registrado</span>";
    
    }
}

function registrar_categoria($nom){
    $conex = conectar();
    $codigo = "INSERT INTO categorias (nom_cat) VALUES (:nom);";
    $insert = $conex->prepare($codigo);
    try{
    $fila = $insert->execute(array(':nom'=>$nom));
        if($fila==1){
            echo '<br><span class="correcto">Registro completado correctamente</span>';
        }
    }catch(PDOException $e){
        echo "<br>Nombre de la categoría utilizado anteriormente";     
    }
}

function leer_categoria($cat){
        $conex = conectar();
        $codigo = "SELECT nom_cat FROM categorias WHERE id_cat= :cat ";
        $consulta = $conex->prepare($codigo);
        $consulta->bindParam(':cat', $cat, PDO::PARAM_INT);
        $consulta->execute();
        $nombre = $consulta->fetch();

        if($nombre==1){
        if ($nombre[0] != '' && $nombre[0]!=null){
                return "<span class='correcto'>$nombre[0]</span>";

        if (isset($nombre[0]) && $nombre[0] != ''){
                return $nombre[0];

        }else{

            return "<span class='error'>No existe esa categoria</span>";
        }}

            return null;
        }
}

function leer_subcategoria($sub){
    $conex = conectar();
    $codigo = "SELECT nom_sub FROM subcategorias WHERE id_sub= :sub ";
    $consulta = $conex->prepare($codigo);
    $consulta->bindParam(':sub', $sub, PDO::PARAM_INT);
    $consulta->execute();
    $nombre = $consulta->fetch();
    if (isset($nombre[0]) && $nombre[0] != ''){
        return $nombre[0];
    }else{
        return null;
    }
}

function registrar_subcategoria($cat,$nom){
    $conex = conectar();
    $codigo = "INSERT INTO subcategorias(cat_sub, nom_sub) VALUES (:cat,:nom);";
    $insert = $conex->prepare($codigo);
    try{
        $fila = $insert->execute(array(':cat'=>$cat,':nom'=>$nom));
        if($fila==1){
            echo '<br><span class="correcto">Registro completado correctamente</span>';
        }
    }catch(PDOException $e){
        echo "<br>Nombre de la subcategoría utilizado anteriormente";
    }
}

function registrar_articulos($nom,$sub,$cat,$des,$pre){
    $conex = conectar();
    $codigo = "INSERT INTO articulos (nom_art,sub_art,cat_art,des_art,pre_art,act_art,sto_art)
               VALUES (:nom,:sub,:cat,:des,:pre,:act,:sto);";
    $insert = $conex->prepare($codigo);
    try{
        $fila = $insert->execute(array(':nom'=>$nom,':sub'=>$sub,':cat'=>$cat,':des'=>$des,
            ':pre'=>$pre,':act'=>'0',':sto'=>'0'));
        
        if($fila==1){
            echo '<br><span class="correcto">Registro completado correctamente</span>';
        }
    }catch(PDOException $e){
        echo "<br><span class='error'>Error en el registro</span>";
    }
}

?>