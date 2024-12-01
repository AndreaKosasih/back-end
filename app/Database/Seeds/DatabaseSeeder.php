<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Panggil seeder lainnya di sini
        $this->call('RolePermissionSeeder');
        // $this->call('AnotherSeeder');
    }
}
