<?php
namespace App\Libraries\Xendit;

class GatewayRequest {
    public $type = 'direct';
    public $channel = null;
    public $method = null;
    protected $baseApi = [
        'development' => 'https://api.xendit.co/',
        'production' => 'https://api.xendit.co/',
    ];
    
    public function requestPost($endpoint, $data){
        $baseApi = $this->baseApi[getenv('CI_ENVIRONMENT') == 'production' ? 'production' : 'development'];
        $client = service('curlrequest', ['timeout' => 5]);

        $response = $client->request('POST', $baseApi.$endpoint, [
            'auth' => [getenv('XENDIT_API_KEY'), ''],
            'connect_timeout' => 5,
            'http_errors' => false,
            'json' => $data,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]);
        return new GatewayResponse($response, $this->type, $this->channel, $this->method);
    }

    public function requestGet($endpoint, $params = null){
        $baseApi = $this->baseApi[getenv('CI_ENVIRONMENT') == 'production' ? 'production' : 'development'];
        $client = service('curlrequest', ['timeout' => 5]);

        if($params ?? false){
            $endpoint .= "?" . http_build_query($params);
        }
        $response = $client->request('GET', $baseApi.$endpoint, [
            'auth' => [getenv('XENDIT_API_KEY'), ''],
            'connect_timeout' => 5,
            'http_errors' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]);
        return new GatewayResponse($response, $this->type, $this->channel, $this->method);
    }
}