<?php
function val_dni($dni){
    if(preg_match("/^[0-9]{8}[a-zA-Z]$/",$dni)){
        return true;
    }else{
        return false;
    }
}
function val_texto($texto){
    if(preg_match("/^[a-zA-Z]+.*$/",trim($texto))){
        return true;
    }else{
        return false;
    }
}



function val_telef($telef){
    if(preg_match("/^\d{9}$/",$telef)){
        return true;
    }else{
        return false;
    }
}

function val_correo($correo){
    if(preg_match("/^\w+@\w+\.\w+$/",$correo)){
        return true;
    }else{
        return false;
    }
}

function val_pass($pass){
    if(preg_match("/^.{3}$/",$pass)){     
        return true;
    }else{
        return false;
    }
}

function val_confirmpass($pass,$confirm){
    if($pass == $confirm){
        return true;
    }
    else{
        return false;
    }
}


?>