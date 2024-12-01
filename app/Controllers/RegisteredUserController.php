<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\RoleModel;
use CodeIgniter\Controller;

class RegisteredUserController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function store()
    {
        $userModel = new User();
        $roleModel = new RoleModel();

        // Validate user input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'    => 'required|min_length[3]|max_length[255]|is_unique[users.name]',
            'email'       => 'required|valid_email|is_unique[users.email]',
            'occupation'  => 'required|min_length[3]|max_length[255]',
            'avatar'      => 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]',
            'password'    => 'required|min_length[8]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Process file upload for the avatar
        $avatarFile = $this->request->getFile('avatar');
        if ($avatarFile->isValid() && !$avatarFile->hasMoved()) {
            // Store the avatar in the "uploads/avatars" directory
            $avatarPath = $avatarFile->store('avatars');
        } else {
            // Set a default avatar if file upload fails or is not provided
            $avatarPath = 'images/avatar-default.png';
        }

        // Save user data
        $userId = $userModel->insert([
            'name'   => $this->request->getPost('name'),
            'email'      => $this->request->getPost('email'),
            'occupation' => $this->request->getPost('occupation'),
            'avatar'     => $avatarPath,
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        // Assign a default role to the new user
        $role = $roleModel->where('name', 'student')->first();
        if ($role) {
            $userModel->db->table('role_user')->insert([
                'user_id' => $userId,
                'role_id' => $role['id']
            ]);
        }

        return redirect()->to('/login')->with('success', 'Registration successful!');
    }
}
