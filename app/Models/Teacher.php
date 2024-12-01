<?php

namespace App\Models;

use CodeIgniter\Model;

class Teacher extends Model
{
    protected $table            = 'teachers';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'is_active'];

    public function user()
    {
        $userModel = new \App\Models\User();
        return $userModel->find($this->user_id);
    }

    public function courses()
    {
        $courseModel = new \App\Models\Course();
        return $courseModel->where('teacher_id', $this->id)->findAll();
    }
}
