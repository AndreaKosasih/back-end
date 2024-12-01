<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\RoleModel;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Membuat beberapa role
        $roleModel = new RoleModel();

        $ownerRole = $roleModel->insert([
            'name' => 'owner',
        ]);
        $studentRole = $roleModel->insert([
            'name' => 'student',
        ]);
        $teacherRole = $roleModel->insert([
            'name' => 'teacher',
        ]);

        // Membuat default user untuk super admin
        $userModel = new User();

        $userOwner = $userModel->insert([
            'name'       => 'Andreas',
            'occupation' => 'Mahasiswa',
            'avatar'     => 'images/default-avatar.png',
            'email'      => 'andre@owner.com',
            'password'   => password_hash('123123123', PASSWORD_BCRYPT),
        ]);

        // Menyimpan relasi role ke user (manual)
        $db = \Config\Database::connect();
        $db->table('role_user')->insert([
            'user_id' => $userOwner,
            'role_id' => $ownerRole,
        ]);

        echo "Seeding roles and user completed!";
    }
}
