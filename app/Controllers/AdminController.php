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
        $session = session();

        $data = [
            'name'        => $session->get('name'), // Ambil data nama dari session
            'courses'     => $session->get('courses'), // Data courses
            'transactions'=> $session->get('transactions'), // Data transactions
            'students'    => $session->get('students'), // Data students
            'teachers'    => $session->get('teachers'), // Data teachers
            'categories'  => $session->get('categories'), // Data categories
        ];
    
        return view('admin/dashboard', $data);
    }

    public function courses()
    {
        // Get all courses for the admin
        $courses = $this->courseModel->findAll();
        
        return view('admin/courses', ['courses' => $courses]);
    }
}
