<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Payment extends BaseCommand
{

    protected $group = 'App';
    protected $name = 'payment';
    protected $description = '';
    protected $usage = 'payment [arguments] [options]';
    protected $arguments = [];
    protected $options = [];

    public function run(array $params)
    {
        $action = $params[0] ?? null;
        if($action == "paid" && ($params['id'] ?? false)){
            $billing = new \App\Models\BillingModel();
            $billing->update($params['id'], ['state' => 'paid']);
        }

        if($action == "unpaid" && ($params['id'] ?? false)){
            $billing = new \App\Models\BillingModel();
            $billing->update($params['id'], ['state' => 'unpaid']);
        }
    }
}
