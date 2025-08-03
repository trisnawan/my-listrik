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

function rupiah($n){
    return "Rp" . number_format($n,0);
}

function getAlert(){
    $session = session();
    return [
        'warning' => $session->getFlashdata('warning'),
        'success' => $session->getFlashdata('success'),
    ];
}

function showAlert($alert){
    if($alert['warning'] ?? false){
        return '<div class="alert alert-warning">'.$alert['warning'].'</div>';
    }
    if($alert['success'] ?? false){
        return '<div class="alert alert-success">'.$alert['success'].'</div>';
    }
}