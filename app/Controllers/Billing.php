<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Billing extends BaseController
{
    public function getIndex(){
        if(!$userId = $this->session->get('id')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            return redirect()->to('login');
        }

        $billing = new \App\Models\BillingModel();
        $billing->select('billings.*, user_rates.month, user_rates.year, payments.id as payment_id');
        $billing->join('user_rates', 'user_rates.id = billings.rate_id');
        $billing->join('payments', 'payments.billing_id = billings.id', 'left');
        $data['data'] = $billing->orderBy('year,month', 'desc')->where('user_rates.user_id', $userId)->findAll();
        $data['title'] = 'Data Tagihan';
        $data['alert'] = getAlert();
        return view('billing/list', $data);
    }

    public function getPayment($billingId){
        if(!$userId = $this->session->get('id')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            return redirect()->to('login');
        }

        $billing = new \App\Models\BillingModel();
        $billing->select('billings.id, billings.meter_total, billings.state, user_rates.month, user_rates.year, payments.id as payment_id');
        $billing->select('payments.amount, payments.fee, payments.total, payments.gateway_code');
        $billing->join('user_rates', 'user_rates.id = billings.rate_id');
        $billing->join('payments', 'payments.billing_id = billings.id', 'left');
        $data['data'] = $billing->find($billingId);
        $data['title'] = 'Detail Tagihan';
        $data['alert'] = getAlert();
        return view('billing/payment', $data);
    }

    public function getPayment_order($billingId){
        if(!$userId = $this->session->get('id')){
            $this->session->setFlashdata('warning', 'Silahkan login terlebih dahulu untuk mengakses fitur ini!');
            return redirect()->to('login');
        }

        $billing = new \App\Models\BillingModel();
        $bill = $billing->find($billingId);

        $fee = 5000;
        $total = $bill['amount'] + $fee;

        $xendit = new \App\Libraries\Xendit\GatewayRequestAccept();
        $payment = $xendit->createInvoice($bill['id'], $total, base_url('billing/payment/'.$bill['id']));
        if(!$payment->isSuccess()){
            $this->session->setFlashdata('warning', 'Kegagalan koneksi payment gateway');
            return redirect()->back();
        }

        $paymentData = $payment->getBody();

        $paymentModel = new \App\Models\PaymentModel();
        $insertId = $paymentModel->insert(
            [
                'billing_id' => $billingId,
                'gateway_code' => $paymentData['provider_code'],
                'amount' => $bill['amount'],
                'fee' => $fee,
                'total' => $total,
                'expired_at' => date('Y-m-d H:i:s', strtotime('+1 hour')),
            ]
        );

        return redirect()->to('billing/payment/'.$bill['id']);
    }
}
