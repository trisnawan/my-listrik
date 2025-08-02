<?php

function getOneError($errors){
    if(!$errors) return null;
    $return = "";
    foreach($errors as $key => $err){
        if($return){
            $return .= " ";
        }
        $return .= $err;
    }
    return $return;
}