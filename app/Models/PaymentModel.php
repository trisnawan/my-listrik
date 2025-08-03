<?php

namespace App\Models;

use CodeIgniter\Model;
use Ulid\Ulid;

class PaymentModel extends Model
{
    protected $table            = 'payments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'billing_id', 'gateway_code',
        'amount', 'fee', 'total',
        'paid_at', 'expired_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [
        'billing_id' => 'required',
        'gateway_code' => 'required',
        'amount' => 'required',
        'total' => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = ['insertID'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // otomatis menghasilkan id unik dengan algoritma ULID
    protected function insertID(array $data){
        $ulid = Ulid::generate();
        $data['data']['id'] = (string) $ulid;
        return $data;
    }
}
