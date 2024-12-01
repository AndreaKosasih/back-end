<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Teacher;  // Import model Teacher
use App\Models\User;     // Import model User (untuk mengubah role)

class TeacherController extends BaseController
{
    protected $teacherModel;  // Properti untuk model
    protected $userModel;     // Properti untuk model User

    // Constructor untuk inisialisasi model
    public function __construct()
    {
        $this->teacherModel = new Teacher();  // Inisialisasi model Teacher
        $this->userModel = new User();        // Inisialisasi model User
    }

    public function dashboard()
    {
        return view('teacher/dashboard');  // Tampilan dashboard untuk teacher
    }

    public function index()
    {
        // Ambil semua data teachers
        $data['teachers'] = $this->teacherModel->findAll();
        return view('admin/teachers/index', $data);  // Tampilkan daftar teacher
    }

    public function create()
    {
        return view('admin/teachers/create');  // Tampilkan form untuk menambah teacher
    }

    public function store()
    {
        // Validasi input form
        if (!$this->validate([
            'email' => 'required|valid_email|is_unique[users.email]',  // Validasi email
        ])) {
            // Jika validasi gagal, kembalikan dengan pesan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil data email dari form
        $email = $this->request->getPost('email');
        
        // Cari user berdasarkan email
        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            // Jika user tidak ditemukan, tampilkan pesan error
            return redirect()->back()->withInput()->with('errors', ['Email tidak terdaftar']);
        }

        // Mengubah role user menjadi teacher
        $this->userModel->update($user['id'], ['role' => 'teacher']);

        // Menyimpan data teacher ke tabel teachers
        $teacherData = [
            'user_id' => $user['id'],
        ];
        
        // Simpan data teacher
        $this->teacherModel->save($teacherData);

        // Redirect dengan pesan sukses
        session()->setFlashdata('success', 'Teacher added successfully');
        return redirect()->to('/admin/teachers');
    }
}
