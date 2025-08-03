<?php

/** untuk menampilan error dari validasi menjadi format string
 * yang mudah di implementasikan
 */
function getOneError($errors){
    if(!$errors) return null; // jika tidak ada pesan error, mengembalikan null
    $return = "";
    foreach($errors as $key => $err){ // looping untuk mengambil pesan error
        if($return){
            $return .= " "; // antar pesan error dipisahkan dengan spasi
        }
        $return .= $err;
    }
    return $return;
}

// menampilkan mata uang rupiah
function rupiah($n){
    return "Rp" . number_format($n,0); // number formatting ribuan
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