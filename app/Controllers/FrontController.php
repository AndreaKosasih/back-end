<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Course;
use CodeIgniter\HTTP\ResponseInterface;

class FrontController extends BaseController
{
    public function index()
    {
        return view('front/index'); 
    }

    public function details($slug)
    {
        $courseModel = new Course();

        // Cari kursus berdasarkan slug
        $course = $courseModel->where('slug', $slug)->first();

        // Jika kursus tidak ditemukan, tampilkan halaman 404
        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Course with slug '$slug' not found");
        }

        // Kirim data kursus ke view
        return view('front/details', ['course' => $course]);
    }

    // Halaman kategori berdasarkan slug
    public function category($slug)
    {
        // Cari kategori berdasarkan slug
        $categoryModel = new \App\Models\Category();
        $category = $categoryModel->where('slug', $slug)->first();

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Category not found.");
        }

        return view('front/category', ['category' => $category]);
    }

    // Halaman pricing
    public function pricing()
    {
        return view('front/pricing');
    }

    // Halaman checkout (hanya bisa diakses jika login)
    public function checkout()
    {
        return view('front/checkout');
    }

    // Proses checkout (POST)
    public function checkout_store()
    {
        $data = $this->request->getPost();

        // Proses data transaksi
        // ...

        return redirect()->to('/checkout/success');
    }
}
