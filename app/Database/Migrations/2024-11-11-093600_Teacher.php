<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Teacher extends Migration
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'is_active' => [
                'type'       => 'BOOLEAN',
                'default'    => true,
            ],
        ]);

        // Add primary key
        $this->forge->addKey('id', true);

        // Add foreign key for user_id referencing users table
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');

        // Create the teachers table
        $this->forge->createTable('teachers');
    }

    public function down()
    {
        // Drop the teachers table
        $this->forge->dropTable('teachers');
    }
}