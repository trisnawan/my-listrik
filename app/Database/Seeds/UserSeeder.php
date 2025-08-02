<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ulid\Ulid;

class UserSeeder extends Seeder
{
    public function run()
    {
        $ulid = Ulid::generate();
        $this->db->table('users')->insert([
            'id' => (string) $ulid,
            'full_name' => 'Admin',
            'email' => 'admin@trisnawan.com',
            'password' => password_hash('rindu', PASSWORD_DEFAULT),
        ]);

        $this->db->table('user_admin')->insert([
            'user_id' => (string) $ulid,
            'state' => 'active',
        ]);
    }
}
