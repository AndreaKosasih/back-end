<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseKeypoint extends Model
{
    protected $table            = 'course_keypoints';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'course_id'];

    /**
     * Get the user associated with this subscription transaction.
     *
     * 
     */
    public function course()
    {
        $courseModel = new \App\Models\Course();
        return $courseModel->find($this->course_id);
    }
}
