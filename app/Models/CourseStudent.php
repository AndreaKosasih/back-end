<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseStudent extends Model
{
    protected $table            = 'course_students';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'course_id'];
}
