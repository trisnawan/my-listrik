<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Billings extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
            ],
            'rate_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'meter_total' => [
                'type' => 'DECIMAL',
                'constraint' => '12,0',
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'state' => [
                'type' => 'ENUM',
                'constraint' => ['unpaid','paid'],
                'default' => 'unpaid',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('rate_id', 'user_rates', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('billings', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('billings');
    }
}
