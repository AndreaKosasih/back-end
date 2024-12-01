<?php

namespace App\Models;

use CodeIgniter\Model;

class Course extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'slug', 'about', 'path_trailer', 'thumbnail', 'teacher_id', 'category_id'];

    public function category()
    {
        $categoryModel = new \App\Models\Category();
        return $categoryModel->find($this->category_id);
    }

    public function teacher()
    {
        $teacherModel = new \App\Models\Teacher();
        return $teacherModel->find($this->teacher_id);
    }

    public function course_videos()
    {
        $courseVideoModel = new \App\Models\CourseVideo();
        return $courseVideoModel->where('course_id', $this->id)->findAll();
    }

    public function course_keypoints()
    {
        $courseKeypointModel = new \App\Models\CourseKeypoint();
        return $courseKeypointModel->where('course_id', $this->id)->findAll();
    }

    public function students()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('course_students')
                      ->select('users.*')
                      ->join('users', 'users.id = course_students.user_id')
                      ->where('course_students.course_id', $this->id);

        return $builder->get()->getResultArray();
    }
}
