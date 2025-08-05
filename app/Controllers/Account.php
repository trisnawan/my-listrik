<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

/** Controller Account 
 * - login
 * - register
 * - profile
*/
class Account extends BaseController
{

    // untuk menampilkan profile akun
    public function getIndex(){
        // validasi login
        if(!$userId = $this->session->get('id')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            return redirect()->to('account/login');
        }

        $userModel = new UserModel();
        $data['title'] = 'Profile';
        $data['profile'] = $userModel->find($userId);
        $data['alert'] = getAlert();
        return view('account/profile', $data);
    }

    // untuk menyimpan data profile
    public function postIndex(){
        // validasi login
        if(!$userId = $this->session->get('id')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            return redirect()->to('account/login');
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $data['full_name'] = $this->request->getPost('full_name');
        if($user['email'] != $this->request->getPost('email')){
            $data['email'] = $this->request->getPost('email');
        }

        if($this->request->getPost('password')){
            $data['password'] = $this->request->getPost('password');
        }

        if(!$userModel->update($userId, $data)){
            $error = getOneError($userModel->errors());
            $this->session->setFlashdata('warning', $error);
            return redirect()->back();
        }

        $this->session->setFlashdata('success', 'Profile berhasil diperbaharui');
        return redirect()->back();
    }

    // menampilkan form pendaftaran
    public function getRegister(){
        $data['title'] = 'Daftar Pengguna Baru';
        return view('account/register', $data);
    }

    // memproses pendaftaran
    public function postRegister(){
        $data = $this->request->getPost();

        $userModel = new UserModel();
        $userId = $userModel->insert($data);
        if(!$userId){
            $error = getOneError($userModel->errors());
            $this->session->setFlashdata('warning', $error);
            return redirect()->back();
        }

        // menyimpan sesi login
        $login = $userModel->getDataLogin($userId);
        $this->session->set($login);
        return redirect()->to('account');
    }

    // menampilkan form login
    public function getLogin(){
        $data['title'] = 'Masuk';
        return view('account/login', $data);
    }

    // memproses login
    public function postLogin(){
        $data = $this->request->getPost();

        $userModel = new UserModel();
        $login = $userModel->login($data['email'], $data['password']);
        if(!$login){
            $this->session->setFlashdata('warning', 'Email atau kata sandi yang Anda masukan tidak tepat, silahkan coba kembali.');
            return redirect()->back();
        }

        // menyimpan sesi login
        $this->session->set($login);
        return redirect()->to('account');
    }

    // logout dan mengakhiri sesi
    public function getLogout(){
        $this->session->destroy();
        return redirect()->to('account/login');
    }
}
