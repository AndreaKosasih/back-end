<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoleUserTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'role_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('role_user');
    }

    public function down()
    {
        $this->forge->dropTable('role_user');
    }
}