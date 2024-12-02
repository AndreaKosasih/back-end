<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRememberMeColumns extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'remember_token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'password'
            ],
            'remember_expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'remember_token'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['remember_token', 'remember_expires_at']);
    }
}
