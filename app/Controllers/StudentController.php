<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class StudentController extends BaseController
{
    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Get user data from session
        $data['user'] = [
            'name' => session()->get('name'),
            'email' => session()->get('email'),
            'role' => session()->get('role'),
            'avatar' => session()->get('avatar'),
            'occupation' => session()->get('occupation')
        ];

        return view('student/dashboard', $data);
    }
}
