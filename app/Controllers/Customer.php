<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\UserCustomerModel;
use App\Models\RateModel;

class Customer extends BaseController
{

    // menampilkan data pelanggan
    public function getIndex()
    {
        // validasi login dan admin
        if(!$userId = $this->session->get('id') && $this->session->get('is_admin')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            $this->session->destroy();
            return redirect()->to('account/login');
        }

        $data['title'] = 'Data Pelanggan';

        $rate = new RateModel();
        $data['rates'] = $rate->findAll(); // data tarif daya

        $model = new UserModel();
        $model->select("users.*, user_customer.*");
        $model->select("rates.title as rate_title, rates.price as rate_price");
        $model->join('user_customer', 'user_customer.user_id = users.id', 'left');
        $model->join('rates', 'rates.id = user_customer.rate_id', 'left');
        $data['data'] = $model->orderBy('nomor_kwh', 'ASC')->findAll();

        $data['alert'] = getAlert();
        return view('customer/list', $data);
    }

    // menyimpan data tarif pelanggan
    public function postIndex(){
        // validasi login dan admin
        if(!$userId = $this->session->get('id') && $this->session->get('is_admin')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            $this->session->destroy();
            return redirect()->to('account/login');
        }

        $model = new UserCustomerModel();
        $data = $this->request->getPost();

        if($model->find($data['user_id'])){
            // ketika data sudah ada, maka proses update
            if(!$model->update($data['user_id'], $data)){
                $error = getOneError($model->errors());
                $this->session->setFlashdata('warning', $error);
                return redirect()->back();
            }
        }else{
            // ketika data belum ada, maka proses insert
            if(!$model->insert($data)){
                $error = getOneError($model->errors());
                $this->session->setFlashdata('warning', $error);
                return redirect()->back();
            }
        }

        $this->session->setFlashdata('success', 'Pelanggan berhasil diperbaharui');
        return redirect()->back();
    }

    // menampilkan data riwayan tagihan
    public function getBilling()
    {
        // validasi login dan admin
        if(!$userId = $this->session->get('id') && $this->session->get('is_admin')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            $this->session->destroy();
            return redirect()->to('account/login');
        }

        $billing = new \App\Models\BillingModel();
        $billing->join('user_rates', 'user_rates.id = billings.rate_id');
        $billing->join('users', 'users.id = user_rates.user_id');
        $data['data'] = $billing->orderBy('year,month', 'desc')->findAll();
        $data['title'] = 'Data Tagihan';
        $data['alert'] = getAlert();
        return view('customer/billing', $data);
    }

    // memproses tagihan pelanggan
    public function postBilling()
    {
        // validasi login dan admin
        if(!$userId = $this->session->get('id') && $this->session->get('is_admin')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            $this->session->destroy();
            return redirect()->to('account/login');
        }

        // insert data tagihan pelanggan
        $data = $this->request->getPost();
        $model = new \App\Models\UserRateModel();
        if(!$insertId = $model->insert($data)){
            // validasi insert jika gagal
            $error = getOneError($model->errors());
            $this->session->setFlashdata('warning', $error);
            return redirect()->back();
        }

        // mengambil data daya pelanggan dan profile pelanggan
        $user = new UserModel();
        $user->select('rates.price');
        $user->join('user_customer', 'user_customer.user_id = users.id', 'left');
        $user->join('rates', 'rates.id = user_customer.rate_id', 'left');
        $userRate = $user->find($data['user_id']);
        if(!$userRate){
            $model->delete($insertId);
            $this->session->setFlashdata('warning', 'Pelanggan yang dipilih belum ditetapkan daya');
            return redirect()->back();
        }

        // memproses data tagihan total
        $bill['rate_id'] = $insertId;
        $bill['meter_total'] = $data['meter_end'] - $data['meter_start'];
        $bill['amount'] = $bill['meter_total'] * $userRate['price'];
        $bill['state'] = 'unpaid';

        // validasi kesalahan input meter_awal dan meter_akhir dari meter_total
        if($bill['meter_total'] <= 0){
            $model->delete($insertId);
            $this->session->setFlashdata('warning', 'Silahkan masukan meter dengan valid');
            return redirect()->back();
        }

        // menyimpan data tagihan total
        $billing = new \App\Models\BillingModel();
        if(!$billing->insert($bill)){
            $model->delete($insertId);
            $error = getOneError($billing->errors());
            $this->session->setFlashdata('warning', $error);
            return redirect()->back();
        }

        $this->session->setFlashdata('success', 'Tagihan berhasil diterbitkan');
        return redirect()->to('customer/billing');
    }

    // menghapus data tagihan pelanggan
    public function getBilling_delete($id){
        // validasi login dan admin
        if(!$userId = $this->session->get('id') && $this->session->get('is_admin')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            $this->session->destroy();
            return redirect()->to('account/login');
        }

        $model = new \App\Models\UserRateModel();
        $model->delete($id);
        return redirect()->back();
    }
}
