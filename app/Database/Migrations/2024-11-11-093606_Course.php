<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Course extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'path_trailer' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'about' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'thumbnail' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'teacher_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
        ]);

        // Add primary key
        $this->forge->addKey('id', true);

        // Add foreign key for user_id referencing users table
        $this->forge->addForeignKey('teacher_id', 'teachers', 'id', '', 'CASCADE');

        // Add foreign key for user_id referencing users table
        $this->forge->addForeignKey('category_id', 'categories', 'id', '', 'CASCADE');

        // Create the teachers table
        $this->forge->createTable('courses');
    }

    public function down()
    {
        // Drop the teachers table
        $this->forge->dropTable('courses');
    }
}
