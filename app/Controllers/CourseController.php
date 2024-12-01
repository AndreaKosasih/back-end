<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Course;
use App\Models\RoleUserModel;
use App\Models\Category;
use App\Models\Teacher;

class CourseController extends BaseController
{
    protected $courseModel;
    protected $roleUserModel;
    protected $categoryModel;
    protected $teacherModel;

    public function __construct()
    {
        // Inisialisasi model yang diperlukan
        $this->courseModel = new Course();
        $this->roleUserModel = new RoleUserModel();
        $this->categoryModel = new Category();
        $this->teacherModel = new Teacher();
    }

    public function index()
    {
        // Ambil user_id dari session
        $userId = session()->get('user_id');
        
        // Ambil role_id dari user berdasarkan user_id
        $roleUser = $this->roleUserModel->where('user_id', $userId)->first();
        
        if (!$roleUser) {
            // Jika tidak ditemukan role_user, redirect atau tampilkan error
            return redirect()->to('/login')->with('error', 'Unauthorized access');
        }
    
        // Ambil role_id pengguna
        $roleId = $roleUser['role_id'];
    
        // Jika role_id adalah owner (misalnya role_id 1 untuk owner)
        if ($roleId == 1) {
            // Tampilkan semua course jika user adalah owner
            $courses = $this->courseModel->findAll();
        } else if ($roleId == 3) {
            // Jika role_id adalah teacher (misalnya role_id 3 untuk teacher)
            // Tampilkan kursus yang dimiliki oleh teacher
            $courses = $this->courseModel->where('teacher_id', $userId)->findAll();
        } else {
            // Jika role bukan owner atau teacher, redirect ke halaman error atau tidak diizinkan
            return redirect()->to('/login')->with('error', 'Unauthorized access');
        }
    
        // Menambahkan jumlah siswa dan video untuk setiap kursus
        foreach ($courses as &$course) {
            // Mengambil objek model dari ID kursus
            $courseObj = $this->courseModel->find($course['id']);
            
            // Pastikan $courseObj adalah objek model, dan tidak array
            if ($courseObj) {
                // Hitung jumlah siswa
                $course['students_count'] = count($courseObj->students());
    
                // Hitung jumlah video
                $course['videos_count'] = count($courseObj->course_videos());
            }
        }
    
        // Tampilkan view dengan data courses yang sesuai dengan role
        return view('admin/courses/index', [
            'courses' => $courses,
            'categories' => $this->categoryModel->findAll(),
            'teachers' => $this->teacherModel->findAll()
        ]);
    }
    
    
    

    

    public function create()
    {
        // Load models to get categories and teachers
        $categories = $this->categoryModel->findAll();  // Assuming you have categories in your database
        $teachers = $this->teacherModel->findAll();    // Assuming you have teachers in your database

        // Return the view with the data
        return view('admin/courses/create', [
            'categories' => $categories,
            'teachers' => $teachers
        ]);
    }

    public function store()
    {
        // Validasi input
        $validation = \Config\Services::validation();
        if (!$this->validate([
            'name' => 'required|min_length[3]',
            'slug' => 'required|min_length[3]',
            'about' => 'required',
            'category_id' => 'required',
            'teacher_id' => 'required',
        ])) {
            // Kembalikan dengan pesan error jika validasi gagal
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }

        // Ambil data dari form
        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
            'about' => $this->request->getPost('about'),
            'category_id' => $this->request->getPost('category_id'),
            'teacher_id' => $this->request->getPost('teacher_id'),
            'path_trailer' => $this->request->getPost('path_trailer'), // Optional
            'thumbnail' => $this->request->getPost('thumbnail') // Optional
        ];

        // Simpan data kursus ke database
        $this->courseModel->save($data);

        // Redirect ke halaman kursus dengan pesan sukses
        return redirect()->to('/admin/courses')->with('success', 'Course created successfully');
    }

    public function edit($id)
    {
        // Ambil data kursus yang ingin diedit
        $course = $this->courseModel->find($id);

        if (!$course) {
            return redirect()->to('/admin/courses')->with('error', 'Course not found');
        }

        // Ambil kategori dan guru untuk pilihan dropdown
        $categories = $this->categoryModel->findAll();
        $teachers = $this->teacherModel->findAll();

        return view('admin/courses/edit', [
            'course' => $course,
            'categories' => $categories,
            'teachers' => $teachers
        ]);
    }

    public function update($id)
    {
        // Validasi input
        $validation = \Config\Services::validation();
        if (!$this->validate([
            'name' => 'required|min_length[3]',
            'slug' => 'required|min_length[3]',
            'about' => 'required',
            'category_id' => 'required',
            'teacher_id' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }

        // Ambil data dari form
        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => $this->request->getPost('slug'),
            'about' => $this->request->getPost('about'),
            'category_id' => $this->request->getPost('category_id'),
            'teacher_id' => $this->request->getPost('teacher_id'),
            'path_trailer' => $this->request->getPost('path_trailer'), // Optional
            'thumbnail' => $this->request->getPost('thumbnail') // Optional
        ];

        // Update data kursus di database
        $this->courseModel->update($id, $data);

        // Redirect ke halaman kursus dengan pesan sukses
        return redirect()->to('/admin/courses')->with('success', 'Course updated successfully');
    }

    public function delete($id)
    {
        // Cek apakah kursus ada
        $course = $this->courseModel->find($id);

        if (!$course) {
            return redirect()->to('/admin/courses')->with('error', 'Course not found');
        }

        // Hapus kursus
        $this->courseModel->delete($id);

        // Redirect ke halaman kursus dengan pesan sukses
        return redirect()->to('/admin/courses')->with('success', 'Course deleted successfully');
    }
}
