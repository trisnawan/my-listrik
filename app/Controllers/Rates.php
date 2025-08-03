<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RateModel;

class Rates extends BaseController
{
    public function getIndex()
    {
        if(!$userId = $this->session->get('id') && $this->session->get('is_admin')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            $this->session->destroy();
            return redirect()->to('login');
        }

        $model = new RateModel();
        $data['title'] = 'Biaya Listrik';
        $data['data'] = $model->orderBy('price', 'ASC')->findAll();
        $data['alert'] = getAlert();
        return view('rates/list', $data);
    }

    public function postIndex(){
        $model = new RateModel();
        $data = $this->request->getPost();

        if($data['id'] ?? false){
            if(!$model->update($data['id'], $data)){
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

        $this->session->setFlashdata('success', 'Tarif berhasil disimpan');
        return redirect()->back();
    }

    public function getRate_delete($id){
        $model = new RateModel();
        $model->delete($id);
        return redirect()->back();
    }
}
