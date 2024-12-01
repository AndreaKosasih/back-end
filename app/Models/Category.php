<?php

namespace App\Models;

use CodeIgniter\Model;

class Category extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'slug', 'icon'];

    public function courses()
    {
        $courseModel = new \App\Models\Course();
        return $courseModel->where('category_id', $this->id)->findAll();
    }
}
