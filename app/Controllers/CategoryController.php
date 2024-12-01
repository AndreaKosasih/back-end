<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Category;  // Import model Category

class CategoryController extends BaseController
{
    protected $categoryModel;  // Properti untuk model

    // Constructor untuk inisialisasi model
    public function __construct()
    {
        $this->categoryModel = new Category();  // Inisialisasi CategoryModel
    }

    // Menampilkan daftar kategori
    public function index()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/categories/index', $data);
    }

    // Menampilkan form tambah kategori
    public function create()
    {
        return view('admin/categories/create');
    }

    // Menyimpan kategori baru
    public function store()
    {
        // Validasi input
        $validation = \Config\Services::validation();

        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'icon' => 'uploaded[icon]|is_image[icon]|mime_in[icon,image/jpg,image/jpeg,image/png]|max_size[icon,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Proses upload ikon
        $file = $this->request->getFile('icon');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/categories', $newName);

            // Menyimpan data kategori ke database
            $data = [
                'name' => $this->request->getPost('name'),
                'icon' => $newName,
            ];

            if ($this->categoryModel->save($data)) {
                session()->setFlashdata('success', 'Category added successfully');
                return redirect()->to('/admin/categories');
            } else {
                session()->setFlashdata('error', 'Failed to add category');
                return redirect()->back()->withInput();
            }
        } else {
            session()->setFlashdata('error', 'Failed to upload the icon');
            return redirect()->back()->withInput();
        }
    }

     // Menampilkan form edit kategori
    public function edit($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/categories/edit', ['category' => $category]);
    }

    // Menyimpan perubahan kategori
    public function update($id)
    {
        // Validasi input
        $validation =  \Config\Services::validation();

        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'icon' => 'is_image[icon]|mime_in[icon,image/jpg,image/jpeg,image/png]|max_size[icon,2048]', 
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil data kategori yang ingin diubah
        $category = $this->categoryModel->find($id);

        // Proses upload ikon jika ada
        if ($file = $this->request->getFile('icon')) {
            if ($file->isValid()) {
                // Hapus ikon lama jika ada
                if (file_exists(WRITEPATH . 'uploads/categories/' . $category['icon'])) {
                    unlink(WRITEPATH . 'uploads/categories/' . $category['icon']);
                }

                // Upload file baru
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/categories', $newName);
                $category['icon'] = $newName; // Update ikon
            }
        }

        // Update kategori di database
        $category['name'] = $this->request->getPost('name');
        $this->categoryModel->save($category);

        session()->setFlashdata('success', 'Category updated successfully');
        return redirect()->to('/admin/categories');
    }


    // Hapus kategori
    public function delete($id)
    {
        if ($this->categoryModel->delete($id)) {
            session()->setFlashdata('success', 'Category deleted successfully');
        } else {
            session()->setFlashdata('error', 'Failed to delete category');
        }
        return redirect()->to('/admin/categories');
    }
}
