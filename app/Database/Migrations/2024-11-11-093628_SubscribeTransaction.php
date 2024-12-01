<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SubscribeTransaction extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'total_amount' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'constraint'     => 20,
            ],
            'is_paid' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'subscription_start_date' => [
                'type'       => 'DATE',
                'null'       => true,
            ],
            'proof' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        // Add primary key
        $this->forge->addKey('id', true);

        // Add foreign key for user_id referencing users table
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        // Create the subscribe_transactions table
        $this->forge->createTable('subscribe_transactions');
    }

    public function down()
    {
        // Drop the subscribe_transactions table
        $this->forge->dropTable('subscribe_transactions');
    }
}
