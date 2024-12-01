<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Course;
use App\Models\RoleUserModel;
use App\Models\Category;
use App\Models\Teacher;
use App\Models\User;
use App\Models\CourseStudent;

class CourseController extends BaseController
{
    protected $courseModel;
    protected $roleUserModel;
    protected $categoryModel;
    protected $teacherModel;
    protected $userModel;
    protected $courseStudentModel;

    public function __construct()
    {
        // Inisialisasi model yang diperlukan
        $this->courseModel = new Course();
        $this->roleUserModel = new RoleUserModel();
        $this->categoryModel = new Category();
        $this->teacherModel = new Teacher();
        $this->userModel = new User();
        $this->courseStudentModel = new CourseStudent();
    }

    public function index()
    {
        // Get the logged-in user
        $userId = session()->get('user_id');  // Assuming 'user_id' is stored in session
        $userModel = new User();
        
        // Fetch user object from the database
        $user = $userModel->find($userId);  // Returns the user as an object, not an array
        
        if (!$user) {
            // Handle the case when user is not found
            return redirect()->to('/login');
        }
        
        // Load CourseModel
        $courseModel = new Course();
        
        // Start the query
        $builder = $courseModel->select('courses.*, categories.name as category_name, teachers.name as teacher_name')
                               ->join('categories', 'categories.id = courses.category_id')
                               ->join('teachers', 'teachers.id = courses.teacher_id')
                               ->orderBy('courses.id', 'DESC');
        
        // Check if the user has the 'teacher' role
        if ($user->hasRole('teacher')) {
            // If the user is a teacher, filter courses where the teacher_id matches the user's ID
            $builder->where('teachers.user_id', $user->id);
        }

        // Get the courses with pagination
        $courses = $builder->paginate(10);
        
        // Pass the courses data to the view
        return view('admin/courses/index', ['courses' => $courses]);
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
