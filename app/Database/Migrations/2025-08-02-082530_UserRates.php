<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class UserRates extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
            ],
            'month' => [
                'type' => 'INT',
                'constraint' => 2,
            ],
            'year' => [
                'type' => 'YEAR',
            ],
            'meter_start' => [
                'type' => 'DECIMAL',
                'constraint' => '12,0',
                'default' => 0,
            ],
            'meter_end' => [
                'type' => 'DECIMAL',
                'constraint' => '12,0',
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_rates', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('user_rates');
    }
}
