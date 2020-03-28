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

function registrar_clientes($nic,$nom,$ape,$dir,$loc,$pro,$ema,$tel,$pas){
    $conex = conectar();
    $codigo = "INSERT INTO usuarios (rol_usr,nic_usr,nom_usr,ape_usr,dir_usr,loc_usr,pro_usr,
                                     ema_usr,tel_usr,pas_usr,act_usr) 
               VALUES (:rol,:nic,:nom,:ape,:dir,:loc,:pro,:ema,:tel,:pas,:act);";
    $insert = $conex->prepare($codigo);
    $fila = $insert->execute(array(':rol'=>2,':nic'=>$nic,':nom'=>$nom,':ape'=>$ape,':dir'=>$dir,
            ':loc'=>$loc,':pro'=>$pro,':ema'=>$ema,':tel'=>$tel,':pas'=>$pas,':act'=>1));
    
    if($fila==1){
        echo "Registro completado";
    }
}


?>