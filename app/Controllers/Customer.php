<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\UserCustomerModel;
use App\Models\RateModel;

class Customer extends BaseController
{
    public function getIndex()
    {
        if(!$userId = $this->session->get('id') && $this->session->get('is_admin')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            $this->session->destroy();
            return redirect()->to('login');
        }

        $data['title'] = 'Data Pelanggan';

        $rate = new RateModel();
        $data['rates'] = $rate->findAll();

        $model = new UserModel();
        $model->select("users.*, user_customer.*");
        $model->select("rates.title as rate_title, rates.price as rate_price");
        $model->join('user_customer', 'user_customer.user_id = users.id', 'left');
        $model->join('rates', 'rates.id = user_customer.rate_id', 'left');
        $data['data'] = $model->orderBy('nomor_kwh', 'ASC')->findAll();

        $data['alert'] = getAlert();
        return view('customer/list', $data);
    }

    public function postIndex(){
        if(!$userId = $this->session->get('id') && $this->session->get('is_admin')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            $this->session->destroy();
            return redirect()->to('login');
        }

        $model = new UserCustomerModel();
        $data = $this->request->getPost();

        if($model->find($data['user_id'])){
            if(!$model->update($data['user_id'], $data)){
                $error = getOneError($model->errors());
                $this->session->setFlashdata('warning', $error);
                return redirect()->back();
            }
        }else{
            if(!$model->insert($data)){
                $error = getOneError($model->errors());
                $this->session->setFlashdata('warning', $error);
                return redirect()->back();
            }
        }

        $this->session->setFlashdata('success', 'Pelanggan berhasil diperbaharui');
        return redirect()->back();
    }

    public function getBilling()
    {
        if(!$userId = $this->session->get('id') && $this->session->get('is_admin')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            $this->session->destroy();
            return redirect()->to('login');
        }

        $billing = new \App\Models\BillingModel();
        $billing->join('user_rates', 'user_rates.id = billings.rate_id');
        $billing->join('users', 'users.id = user_rates.user_id');
        $data['data'] = $billing->orderBy('year,month', 'desc')->findAll();
        $data['title'] = 'Data Tagihan';
        $data['alert'] = getAlert();
        return view('customer/billing', $data);
    }

    public function postBilling()
    {
        if(!$userId = $this->session->get('id') && $this->session->get('is_admin')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            $this->session->destroy();
            return redirect()->to('login');
        }

        $data = $this->request->getPost();
        $model = new \App\Models\UserRateModel();
        if(!$insertId = $model->insert($data)){
            $error = getOneError($model->errors());
            $this->session->setFlashdata('warning', $error);
            return redirect()->back();
        }

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

        $bill['rate_id'] = $insertId;
        $bill['meter_total'] = $data['meter_end'] - $data['meter_start'];
        $bill['amount'] = $bill['meter_total'] * $userRate['price'];
        $bill['state'] = 'unpaid';

        if($bill['meter_total'] <= 0){
            $model->delete($insertId);
            $this->session->setFlashdata('warning', 'Silahkan masukan meter dengan valid');
            return redirect()->back();
        }

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

    public function getBilling_delete($id){
        if(!$userId = $this->session->get('id') && $this->session->get('is_admin')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            $this->session->destroy();
            return redirect()->to('login');
        }

        $model = new \App\Models\UserRateModel();
        $model->delete($id);
        return redirect()->back();
    }
}
