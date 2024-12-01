<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Course;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    protected $courseModel;

    public function __construct()
    {
        $this->courseModel = new Course();
    }
    
    public function dashboard()
    {
        return view('admin/dashboard');  // Tampilan dashboard untuk admin
    }

    public function courses()
    {
        // Get all courses for the admin
        $courses = $this->courseModel->findAll();
        
        return view('admin/courses', ['courses' => $courses]);
    }
}
