<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class UserCustomer extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
            ],
            'rate_id' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'nomor_kwh' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'constraint' => 60,
                'null' => true,
                'default' => null,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('rate_id', 'rates', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_customer', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('user_customer');
    }
}
