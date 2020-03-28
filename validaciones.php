<?php

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

function val_pass($pass, $conf_pass){
    if(trim($pass)!='' && $pass!=null && $pass == $conf_pass){
        return true;
    }else{
        return false;
    }
}



?>