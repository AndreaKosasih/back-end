<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Course;
use App\Models\CourseKeypoint;
use Config\Database;

class CourseController extends Controller
{
    public function manageAdmin()
    {
        $db = Database::connect();

        $courses = $db->table('courses')
            ->select('courses.*, users.name as teacher_name, categories.name as category_name')
            ->join('teachers', 'teachers.id = courses.teacher_id')
            ->join('users', 'users.id = teachers.user_id') // Ambil nama guru dari tabel users
            ->join('categories', 'categories.id = courses.category_id')
            ->select('(SELECT COUNT(*) FROM course_students WHERE course_students.course_id = courses.id) as students_count')
            ->select('(SELECT COUNT(*) FROM course_videos WHERE course_videos.course_id = courses.id) as videos_count')
            ->orderBy('courses.id', 'DESC')
            ->get()
            ->getResult();
    

        return view('admin/courses/index', ['courses' => $courses]);
    }

    public function manageTeacher()
    {
        $db = Database::connect();
        $session = session();
        $teacherId = $session->get('user_id'); // Ambil ID teacher dari sesi login

        $courses = $db->table('courses')
            ->select('courses.*, categories.name as category_name')
            ->join('categories', 'categories.id = courses.category_id')
            ->select('(SELECT COUNT(*) FROM course_students WHERE course_students.course_id = courses.id) as students_count')
            ->select('(SELECT COUNT(*) FROM course_videos WHERE course_videos.course_id = courses.id) as videos_count')
            ->where('teacher_id', $teacherId)
            ->orderBy('id', 'DESC')
            ->get()
            ->getResult();

        return view('teacher/courses/index', ['courses' => $courses]);
    }

    public function create()
    {
        $db = Database::connect();

        // Ambil daftar kategori
        $categories = $db->table('categories')->select('id, name')->get()->getResult();

        // Tampilkan form create dengan kategori
        return view('teacher/courses/create', ['categories' => $categories]);
    }
    
    public function store()
    {
        // Validasi input form
        $validation = \Config\Services::validation();
        
        // Aturan validasi
        $rules = [
            'name'             => 'required|min_length[3]|max_length[255]',
            'category_id'      => 'required',  // Tidak perlu is_not_empty, cukup required
            'thumbnail'        => 'uploaded[thumbnail]|is_image[thumbnail]|max_size[thumbnail,2048]',
            'about'            => 'required|min_length[10]',
        ];
        
        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan ke form dengan error
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil data input
        $name         = $this->request->getVar('name');
        $category_id  = $this->request->getVar('category_id');
        $about        = $this->request->getVar('about');

        // Menangani upload file thumbnail
        $thumbnail = $this->request->getFile('thumbnail');
        
        if ($thumbnail->isValid() && !$thumbnail->hasMoved()) {
            $thumbnailName = $thumbnail->getRandomName();  // Nama file acak
            $thumbnail->move(WRITEPATH . 'uploads/courses', $thumbnailName); // Pindahkan ke folder yang diinginkan
        } else {
            return redirect()->back()->withInput()->with('errors', ['thumbnail' => 'Gagal mengupload thumbnail']);
        }

        // Menyimpan data kursus ke dalam database
        $courseModel = new Course();
        
        $data = [
            'name'         => $name,
            'slug'         => url_title($name, '-', true), // Generating slug from course name
            'category_id'  => $category_id,
            'about'        => $about,
            'thumbnail'    => $thumbnailName,
            'teacher_id'   => session()->get('user_id'),  // ID guru diambil dari session
        ];

        // Insert data kursus ke tabel 'courses'
        $courseModel->insert($data);  // Menyimpan data kursus

        // Redirect ke halaman kursus dengan pesan sukses
        return redirect()->to('/teacher/courses')->with('message', 'Course successfully created!');
    }
}
