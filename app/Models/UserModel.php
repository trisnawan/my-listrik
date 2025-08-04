<?php

namespace App\Models;

use CodeIgniter\Model;
use Ulid\Ulid;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'full_name', 'email', 'password',
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
        'full_name' => 'required',
        'email' => 'required|is_unique[users.email]',
        'password' => 'required',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = ['insertID','passHash'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['passHash'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // pembuatan ID dengan algoritma ULID setiap data user ditambahkan
    protected function insertID(array $data){
        $ulid = Ulid::generate(); // menggunakan library ULID
        $data['data']['id'] = (string) $ulid; // memastikan format string
        return $data;
    }

    // melakukan hashing terhadap kata sandi setiap insert dan update
    protected function passHash(array $data){
        // menggunakan algoritma hash default
        if($data['data']['password'] ?? false){
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    // memuat data yang diperlukan dalam sesi login
    public function getDataLogin($userId){
        $this->select("users.id, users.full_name, IF(user_admin.state = 'active', 1, 0) as is_admin");
        $this->join("user_admin", "user_admin.user_id = users.id", "left"); // join untuk validasi admin/customer
        return $this->find($userId);
    }

    // melakukan pengecekan terhadap percobaan login
    public function login($email, $password){
        $data = $this->where("email", $email)->first();
        if(!$data) return null;

        // pengecekan validasi kata sandi dengan algorima hasing
        if(password_verify($password, $data['password'])){
            return $this->getDataLogin($data['id']);
        }

        return null;
    }
}
