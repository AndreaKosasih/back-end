<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseVideo extends Model
{
    protected $table            = 'course_videos';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'path_video', 'course_id'];

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
