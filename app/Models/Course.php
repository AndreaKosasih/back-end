<?php

namespace App\Models;

use CodeIgniter\Model;

class Course extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'slug', 'about', 'path_trailer', 'thumbnail', 'teacher_id', 'category_id'];

    // Relasi ke Category
    public function category()
    {
        $categoryModel = new \App\Models\Category();
        // Menampilkan category berdasarkan category_id
        return $categoryModel->find($this->category_id);
    }

    // Relasi ke Teacher
    public function teacher()
    {
        $teacherModel = new \App\Models\Teacher();
        // Menampilkan teacher berdasarkan teacher_id
        return $teacherModel->find($this->teacher_id);
    }

    // Relasi ke Course Videos
    public function course_videos()
    {
        $courseVideoModel = new \App\Models\CourseVideo();
        // Menampilkan videos berdasarkan course_id
        return $courseVideoModel->where('course_id', $this->id)->findAll();
    }

    // Relasi ke Course Keypoints
    public function course_keypoints()
    {
        $courseKeypointModel = new \App\Models\CourseKeypoint();
        // Menampilkan keypoints berdasarkan course_id
        return $courseKeypointModel->where('course_id', $this->id)->findAll();
    }

    // Relasi ke Students (Menggunakan Query Builder)
    public function students()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('course_students')
                      ->select('users.*')
                      ->join('users', 'users.id = course_students.user_id')
                      ->where('course_students.course_id', $this->id);
        
        // Mengembalikan hasil query dalam bentuk array
        return $builder->get()->getResultArray();
    }

    // Menambahkan count siswa dan video ke dalam kursus
    public function getStudentsCount()
    {
        return count($this->students());
    }

    public function getVideosCount()
    {
        return count($this->course_videos());
    }
}
