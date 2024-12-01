<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyRoleUserTable extends Migration
{
    public function up()
    {
        // Modify role_user table
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => false
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'null' => false
            ],
        ]);

        // Drop existing primary key if exists and add the new primary key constraint
        $this->forge->addPrimaryKey('user_id'); // Make user_id the primary key

        // You can optionally create a unique constraint on the combination of user_id and role_id
        $this->forge->addUniqueKey(['user_id', 'role_id']); // To ensure unique combination of user_id and role_id

        // Create the role_user table
        $this->forge->createTable('role_user', true);
    }

    public function down()
    {
        // Drop the table if we need to rollback the migration
        $this->forge->dropTable('role_user');
    }
}
