<?php

function val_texto($texto){
    if(preg_match("/^[a-zA-Z]+(\s[a-zA-Z]+)*$/",trim($texto))){
        return true;
    }else{
        return false;
    }
}

?>