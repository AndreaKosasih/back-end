<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Teacher;  // Import model Teacher
use App\Models\User;     // Import model User (untuk mengubah role)
use App\Models\RoleUserModel;
use App\Models\Course;

class TeacherController extends BaseController
{
    protected $teacherModel;  // Properti untuk model
    protected $userModel;     // Properti untuk model User
    protected $roleUserModel;
    protected $courseModel;

    // Constructor untuk inisialisasi model
    public function __construct()
    {
        $this->teacherModel = new Teacher();  // Inisialisasi model Teacher
        $this->userModel = new User();        // Inisialisasi model User
        $this->roleUserModel = new RoleUserModel();
        $this->courseModel = new Course();
    }

    public function dashboard()
    {
        // Step 1: Get the user_id from the session
        $userId = session()->get('user_id');

        // Step 2: Fetch the user from the userModel
        $user = $this->userModel->find($userId);

        // If the user is not found, redirect to login
        if (!$user) {
            return redirect()->to('/login');
        }

        // Step 3: Check the user's role from RoleUserModel
        $roleUser = $this->roleUserModel->where('user_id', $userId)->first();

        // If the roleUser is not found or the role_id is not for a teacher (e.g., role_id == 3), deny access
        if (!$roleUser || $roleUser['role_id'] != 3) {
            return redirect()->to('/login'); // Unauthorized access if not a teacher
        }

        // Step 4: Teacher is validated, fetch the teacher's name
        $teacherName = $user['name']; // Assuming the name is stored in the 'name' column of the user table

        // Step 5: Fetch the courses managed by the teacher
        $courses = $this->courseModel->where('teacher_id', $userId)->findAll();

        // Step 6: Pass the teacher's name and the courses to the view
        return view('teacher/dashboard', [
            'teacherName' => $teacherName,
            'courses' => $courses
        ]);
    }

    public function index()
    {
        // $data['teachers'] = $this->teacherModel->findAll();
        // return view('admin/teachers/index', $data);  // Tampilkan daftar teacher

        // Get the list of teachers (this assumes you already have a method to get teachers)
        $teachers = $this->teacherModel->findAll();

        // Pass teacher data to the view
        return view('admin/teachers/index', [
            'teachers' => $teachers,
            'userModel' => $this->userModel  // Pass userModel ke view jika diperlukan
        ]);
    }

    public function create()
    {
        return view('admin/teachers/create');  // Tampilkan form untuk menambah teacher
    }

    public function store()
    {
        // Validasi input form
        if (!$this->validate([
            'email' => 'required|valid_email',  // Validasi email
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

        // Cek apakah user sudah memiliki role teacher (role_id 3)
        $roleUser = $this->roleUserModel->where('user_id', $user['id'])->first();

        if ($roleUser) {
            // Jika role_user ditemukan, cek apakah sudah memiliki role teacher
            if ($roleUser['role_id'] !== 3) {
                // Jika role_user bukan teacher (role_id 3), update role_id menjadi 3
                $this->roleUserModel->where('user_id', $user['id'])
                    ->set('role_id', 3)
                    ->update();
            }
        } else {
            // Jika tidak ada role_user untuk user_id ini, maka insert role teacher
            $this->roleUserModel->insert([
                'user_id' => $user['id'],
                'role_id' => 3, // Role teacher
            ]);
        }

        // Masukkan data ke tabel teachers
        $this->teacherModel->insert([
            'user_id' => $user['id'],   // user_id yang sesuai dengan user
            'is_active' => 1,            // status aktif teacher
        ]);

        // Redirect dengan pesan sukses
        session()->setFlashdata('success', 'User successfully updated to Teacher');
        return redirect()->to('/admin/teachers');
    }

    public function delete($id)
    {
        // Cari teacher berdasarkan id
        $teacher = $this->teacherModel->find($id);

        if (!$teacher) {
            // Jika teacher tidak ditemukan, redirect dengan pesan error
            return redirect()->to('/admin/teachers')->with('error', 'Teacher not found');
        }

        // Ambil user_id dari teacher
        $userId = $teacher['user_id'];

        // Hapus data teacher dari tabel teachers
        $this->teacherModel->delete($id);

        // Ubah role user menjadi 'student' (role_id = 2, misalnya)
        $this->roleUserModel->where('user_id', $userId)
            ->where('role_id', 3) // Hanya update yang memiliki role_teacher (role_id = 3)
            ->set('role_id', 2) // Set role_id menjadi 2 (Student)
            ->update();

        // Redirect dengan pesan sukses
        session()->setFlashdata('success', 'Teacher deleted and role updated to Student');
        return redirect()->to('/admin/teachers');
    }
}
