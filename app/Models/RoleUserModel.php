<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleUserModel extends Model
{
    protected $table            = 'role_user';
    protected $primaryKey       = 'user_id';
    protected $allowedFields    = ['user_id','role_id'];
}
