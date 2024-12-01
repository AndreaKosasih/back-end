<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class StudentController extends BaseController
{
    public function dashboard()
    {
        return view('student/dashboard');  // Tampilan dashboard untuk student
    }
}
