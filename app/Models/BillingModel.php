<?php

namespace App\Models;

use CodeIgniter\Model;
use Ulid\Ulid;

class BillingModel extends Model
{
    protected $table            = 'billings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'rate_id', 'meter_total', 'amount', 'state'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [
        'rate_id' => 'required',
        'meter_total' => 'required',
        'amount' => 'required',
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
