<?php
namespace App\Libraries\Xendit;

class GatewayResponse {
    private $statusCode = 0;
    private $body = null;
    private $type = null;
    private $method = null;
    private $channel = null;

    public function __construct($response, $type = 'direct', $channel = null, $method = null){
        $this->type = $type;
        $this->method = $method;
        $this->channel = $channel;
        $this->statusCode = $response->getStatusCode();
        if (str_contains($response->header('content-type'), 'application/json')) {
            $this->body = json_decode($response->getBody(), true);
        }else{
            $this->body = $response->getBody();
        }

        if($this->statusCode < 200 || $this->statusCode >= 300){
            log_message('error', "Gateway Response: [$this->statusCode] " . json_encode($this->body));
        }
    }

    public function isSuccess(){
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    public function getBody(){
        return [
            'id' => $this->body['external_id'] ?? $this->body['reference_id'] ?? null,
            'provider_code' => $this->body['id'],
            'type' => $this->type,
            'status' => in_array(strtolower($this->body['status']), ['unpaid','paid','failed']) ? strtolower($this->body['status']) : null,
            'buyer_name' => $this->body['name'] ?? null,
            'charge_amount' => $this->body['amount'] ?? $this->body['expected_amount'] ?? 0,
            'capture_amount' => $this->body['amount'] ?? $this->body['expected_amount'] ?? 0,
            'fee_amount' => 0,
            'payment_method' => $this->method,
            'payment_provider' => $this->body['bank_code'] ?? $this->body['channel_code'] ?? null,
            'period_time' => null,
            'cycle_number' => null,
            'expired_at' => date("Y-m-d H:i:s", strtotime($this->body['expiry_date'] ?? $this->body['expiration_date'] ?? $this->body['expires_at'] ?? '+1 hour')),
            'direct' => [
                'virtual_account' => $this->body['account_number'] ?? null,
                'qr_string' => $this->body['qr_string'] ?? null,
            ],
            'redirect' => [
                'redirect_url' => $this->body['invoice_url'] ?? null,
                'redirect_mobile' => null,
                'redirect_deeplink' => null,
            ],
            'properties' => [
                'mobile_number' => null,
                'cashtag' => null,
                'return_url' => null,
            ]
        ];
    }
}