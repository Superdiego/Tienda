<?php

function conectar(){
    try{
        $conex = new PDO("mysql:dbname=tienda;host=localhost","jefe","jefe");
        $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Funciona!!!!!!";
        
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    
}


?>