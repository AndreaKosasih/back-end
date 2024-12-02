<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class StudentController extends BaseController
{
    public function dashboard()
    {
        $session = session();

        $data = [
            'name'        => $session->get('name'), // Ambil data nama dari session
            'enrolledCourses' => $session->get('enrolledCourses'), // Kursus yang diikuti
            'categories'  => $session->get('categories'), // Kategori dari kursus yang diikuti
        ];

        return view('student/dashboard', $data);
    }
}
