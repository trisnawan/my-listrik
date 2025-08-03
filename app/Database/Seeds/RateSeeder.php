<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RateSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('rates')->insertBatch([
            [ 'id' => '450', 'title' => '450 VA', 'price' => 750,],
            [ 'id' => '900', 'title' => '900 VA', 'price' => 1000,],
            [ 'id' => '2200', 'title' => '2200 VA', 'price' => 1400,],
            [ 'id' => '4400', 'title' => '4400 VA', 'price' => 1400,],
        ]);
    }
}
