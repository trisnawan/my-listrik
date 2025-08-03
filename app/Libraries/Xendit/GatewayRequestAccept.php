<?php
namespace App\Libraries\Xendit;

class GatewayRequestAccept extends GatewayRequest {
    
    public function createVirtualAccount($arrayModel){
        $this->type = 'direct';
        $this->channel = 'Virtual Account';
        $this->method = $arrayModel['bank_code'] ?? null;

        $body['external_id'] = $arrayModel['id'];
        $body['bank_code'] = $arrayModel['bank_code'];
        $body['name'] = $arrayModel['buyer_name'];
        $body['country'] = 'ID';
        $body['currency'] = 'IDR';
        $body['is_single_use'] = true;
        $body['is_closed'] = true;
        $body['expected_amount'] = $arrayModel['charge_amount'] ?? $arrayModel['capture_amount'];
        $body['expiration_date'] = date('c', strtotime('+1 day'));
        return $this->requestPost("callback_virtual_accounts", $body);
    }

    public function getVirtualAccount($id, $data){
        return $this->requestGet("callback_virtual_accounts/$id");
    }

    public function createEwallet($arrayModel){
        $this->type = 'redirect';
        $this->channel = 'E-Wallet';
        $this->method = $arrayModel['bank_code'] ?? null;

        $body['external_id'] = $arrayModel['id'];
        $body['amount'] = $arrayModel['charge_amount'];
        $body['success_redirect_url'] = $arrayModel['properties']['return_url'];
        $body['failure_redirect_url'] = $body['success_redirect_url'];
        $body['payment_methods'] = [$arrayModel['bank_code']];
        $body['currency'] = 'IDR';
        return $this->requestPost("v2/invoices", $body);
    }

    public function getEwallet($id, $data){
        return $this->requestGet("v2/invoices/$id");
    }

    public function createCreditCard($arrayModel){
        $this->type = 'redirect';
        $this->channel = 'Credit Card';
        $this->method = null;

        $body['external_id'] = $arrayModel['id'];
        $body['amount'] = $arrayModel['charge_amount'];
        $body['success_redirect_url'] = $arrayModel['properties']['return_url'];
        $body['failure_redirect_url'] = $body['success_redirect_url'];
        $body['payment_methods'] = ["CREDIT_CARD"];
        $body['currency'] = 'IDR';
        return $this->requestPost("v2/invoices", $body);
    }

    public function getCreditCard($id, $data){
        return $this->requestGet("v2/invoices/$id");
    }

    public function createPayLater($arrayModel){
        $this->type = 'redirect';
        $this->channel = 'Pay Later';
        $this->method = $arrayModel['bank_code'] ?? null;

        $body['external_id'] = $arrayModel['id'];
        $body['amount'] = $arrayModel['charge_amount'];
        $body['success_redirect_url'] = $arrayModel['properties']['return_url'];
        $body['failure_redirect_url'] = $body['success_redirect_url'];
        $body['payment_methods'] = [$arrayModel['bank_code']];
        $body['currency'] = 'IDR';
        return $this->requestPost("v2/invoices", $body);
    }

    public function getPayLater($id, $data){
        return $this->requestGet("v2/invoices/$id");
    }

    public function createQRIS($arrayModel){
        $this->type = 'direct';
        $this->channel = 'QR CODES';
        $this->method = 'QRIS';

        $body['reference_id'] = $arrayModel['id'];
        $body['external_id'] = $arrayModel['id'];
        $body['callback_url'] = base_url('webhook/xendit/qris');
        $body['type'] = 'DYNAMIC';
        $body['currency'] = 'IDR';
        $body['amount'] = $arrayModel['charge_amount'];
        $body['expires_at'] = date('c', strtotime('+1 day'));
        return $this->requestPost("qr_codes", $body);
    }

    public function getQRIS($id, $data){
        return $this->requestGet("qr_codes/$id");
    }

    public function createInvoice($id, $amount, $url){
        $this->type = 'redirect';
        $this->channel = 'Invoices';

        $body['external_id'] = $id;
        $body['amount'] = $amount;
        $body['success_redirect_url'] = $url;
        $body['failure_redirect_url'] = $url;
        $body['currency'] = 'IDR';
        return $this->requestPost("v2/invoices", $body);
    }

    public function getInvoice($id, $data){
        return $this->requestGet("v2/invoices/$id");
    }
}