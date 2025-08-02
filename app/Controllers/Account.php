<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class Account extends BaseController
{

    public function getIndex(){
        if(!$userId = $this->session->get('id')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            return redirect()->to('login');
        }

        $userModel = new UserModel();
        $data['title'] = 'Profile';
        $data['profile'] = $userModel->find($userId);
        return view('account/profile', $data);
    }

    public function getRegister(){
        $data['title'] = 'Daftar Pengguna Baru';
        return view('account/register', $data);
    }

    public function postRegister(){
        $data = $this->request->getPost();

        $userModel = new UserModel();
        $userId = $userModel->insert($data);
        if(!$userId){
            $error = getOneError($userModel->errors());
            $this->session->setFlashdata('warning', $error);
            return redirect()->back();
        }

        $login = $userModel->getDataLogin($userId);
        $this->session->set($login);
        return redirect()->to('account');
    }
}
