<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CourseVideo extends Migration {
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
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'path_video' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'course_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        // Add primary key
        $this->forge->addKey('id', true);

        // Add foreign key for course_id referencing courses table
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');

        // Create the table
        $this->forge->createTable('course_videos');
    }

    public function down()
    {
        $this->forge->dropTable('course_videos');
    }
}
