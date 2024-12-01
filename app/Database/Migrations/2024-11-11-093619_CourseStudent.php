<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CourseStudent extends Migration
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
            'course_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
        ]);

        // Add primary key
        $this->forge->addKey('id', true);

        // Add foreign key for user_id referencing users table
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');

        // Add foreign key for user_id referencing users table
        $this->forge->addForeignKey('course_id', 'courses', 'id', '', 'CASCADE');

        // Create the teachers table
        $this->forge->createTable('course_students');
    }

    public function down()
    {
        // Drop the teachers table
        $this->forge->dropTable('course_students');
    }
}
