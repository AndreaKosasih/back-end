<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function adminDashboard()
    {
        $db = \Config\Database::connect();
    
        // Mengambil data dari tabel terkait
        $courses = $db->table('courses')->countAllResults();
        $transactions = $db->table('subscribe_transactions')->countAllResults();
        $students = $db->table('role_user')
                       ->join('roles', 'role_user.role_id = roles.id')
                       ->where('roles.name', 'student')
                       ->countAllResults();
        $teachers = $db->table('teachers')->countAllResults();
        $categories = $db->table('categories')->countAllResults();
    
        // Mendapatkan data pengguna dari session
        $session = session();
        $user = [
            'id'   => $session->get('user_id'),
            'name' => $session->get('name'),
            'role' => $session->get('role'),
        ];
    
        // Pastikan semua data dikirim ke view
        return view('admin/dashboard', compact('courses', 'transactions', 'students', 'teachers', 'categories', 'user'));
    }
    
}
