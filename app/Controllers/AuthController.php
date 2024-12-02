<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function authenticate()
    {
        $session = session();
        $userModel = new User();
        $db = \Config\Database::connect();

        if (!$this->validate([
            'email'    => 'required|valid_email',
            'password' => 'required',
        ])) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Get role
            $roleQuery = $db->table('role_user')
                ->select('roles.name as role')
                ->join('roles', 'role_user.role_id = roles.id')
                ->where('role_user.user_id', $user['id'])
                ->get()
                ->getRow();

            $role = $roleQuery ? $roleQuery->role : 'student';

            // Set session data with user info
            $sessionData = [
                'user_id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $role,
                'avatar' => $user['avatar'],
                'occupation' => $user['occupation'],
                'isLoggedIn' => true
            ];

            $session->set($sessionData);

            // Handle remember me
            if ($remember) {
                // ... existing remember me code ...
            }

            // Redirect with user data
            return $this->redirectBasedOnRole($role);
        }

        return redirect()->back()
            ->withInput()
            ->with('login_error', 'Invalid email or password');
    }

    //     public function registerUser()
    // {
    //     $session = session();
    //     $userModel = new User();
    //     $roleUserModel = new \App\Models\RoleUserModel();
    //     $db = \Config\Database::connect();

    //     // Validasi input
    //     $validation = \Config\Services::validation();
    //     $validation->setRules([
    //         'name'      => 'required|min_length[3]|max_length[50]',
    //         'email'     => 'required|valid_email|is_unique[users.email]',
    //         'password'  => 'required|min_length[8]',
    //         'occupation' => 'required|min_length[3]|max_length[100]', // Validasi untuk occupation
    //         'avatar'    => 'is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|max_size[avatar,1024]',
    //     ]);

    //     if (!$validation->withRequest($this->request)->run()) {
    //         return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    //     }

    //     // Ambil data input
    //     $name = $this->request->getPost('name');
    //     $email = $this->request->getPost('email');
    //     $occupation = $this->request->getPost('occupation');
    //     $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

    //     // Handle avatar upload
    //     $avatar = $this->request->getFile('avatar');
    //     $avatarName = null;

    //     if ($avatar->isValid() && !$avatar->hasMoved()) {
    //         // Generate unique file name
    //         $avatarName = $avatar->getRandomName();
    //         // Move file to the desired directory
    //         $avatar->move(WRITEPATH . 'uploads/avatars', $avatarName);
    //     }

    //     // Siapkan data untuk disimpan ke tabel users
    //     $userData = [
    //         'name'       => $name,
    //         'email'      => $email,
    //         'password'   => $password,
    //         'avatar'     => $avatarName,  // Save avatar name in the database
    //         'occupation' => $occupation, // Tambahkan occupation
    //     ];

    //     // Cek apakah $userData tidak kosong
    //     if (empty($userData['name']) || empty($userData['email']) || empty($userData['password']) || empty($userData['occupation'])) {
    //         return redirect()->back()->withInput()->with('errors', ['Please fill in all required fields.']);
    //     }

    //     // Insert user data into the database
    //     $userModel->save($userData);

    //     // Ambil user_id secara manual berdasarkan email
    //     $user = $userModel->where('email', $email)->first(); // Cari berdasarkan email
    //     if (!$user) {
    //         // Jika user tidak ditemukan setelah insert
    //         return redirect()->back()->withInput()->with('errors', ['Failed to register user.']);
    //     }

    //     $userId = $user['id']; // Ambil user_id

    //     // Pastikan role_id yang ingin disimpan ada di tabel roles
    //     $roleId = 2; // Default role_id untuk student adalah 2

    //     // Pastikan role_id valid dan ada di tabel roles
    //     $roleModel = new \App\Models\RoleModel(); // Ambil model role
    //     $role = $roleModel->find($roleId);

    //     if (!$role) {
    //         // Jika role tidak ditemukan, tampilkan error
    //         return redirect()->back()->withInput()->with('errors', ['Invalid role_id']);
    //     }

    //     // Masukkan data ke tabel role_user untuk role student
    //     $roleUserModel->save([
    //         'user_id' => $userId,
    //         'role_id' => $roleId, // Role student
    //     ]);

    //     // Set session data
    //     $session->set([
    //         'user_id'    => $userId,
    //         'name'       => $name,
    //         'role'       => 'student',  // Default role is 'student'
    //         'isLoggedIn' => true,
    //     ]);

    //     // Redirect ke halaman login atau halaman yang sesuai
    //     return redirect()->to('/login');
    // }

    public function registerUser()
    {
        $session = session();
        $userModel = new User();
        $roleUserModel = new \App\Models\RoleUserModel();
        $db = \Config\Database::connect();
    {
        $session = session();
        $userModel = new User();
        $roleUserModel = new \App\Models\RoleUserModel();
        $db = \Config\Database::connect();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'      => 'required|min_length[3]|max_length[50]',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'password'  => 'required|min_length[8]',
            'occupation' => 'required|min_length[3]|max_length[100]',
            'avatar'    => 'is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|max_size[avatar,1024]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $occupation = $this->request->getPost('occupation');
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        $avatar = $this->request->getFile('avatar');
        $avatarName = null;

        if ($avatar->isValid() && !$avatar->hasMoved()) {
            $avatarName = $avatar->getRandomName();
            $avatar->move(WRITEPATH . 'uploads/avatars', $avatarName);
        }

        $userData = [
            'name'       => $name,
            'email'      => $email,
            'password'   => $password,
            'avatar'     => $avatarName,
            'occupation' => $occupation,
        ];

        if (empty($userData['name']) || empty($userData['email']) || empty($userData['password']) || empty($userData['occupation'])) {
            return redirect()->back()->withInput()->with('errors', ['Please fill in all required fields.']);
        }

        $userModel->save($userData);

        $user = $userModel->where('email', $email)->first();
        if (!$user) {
            return redirect()->back()->withInput()->with('errors', ['Failed to register user.']);
        }

        $userId = $user['id'];

        $roleUserModel->save([
            'user_id' => $userId,
            'role_id' => 2,
        ]);

        $session->set([
            'user_id'    => $userId,
            'name'       => $name,
            'role'       => 'student',
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/login');
    }

    private function redirectBasedOnRole($role)
    {
        switch ($role) {
            case 'owner':
                return redirect()->to('/admin/dashboard');
            case 'teacher':
                return redirect()->to('/teacher/dashboard');
            case 'student':
                return redirect()->to('/student/dashboard')->with('user', session()->get());
            default:
                return redirect()->to('/dashboard');
        }
    }

    public function logout()
    {
        $session = session();

        // Clear remember token from database
        if ($session->get('user_id')) {
            $userModel = new User();
            try {
                // Use updateWhere instead of update
                $userModel->where('id', $session->get('user_id'))
                    ->set([
                        'remember_token' => null,
                        'remember_expires_at' => null
                    ])
                    ->update();
            } catch (\Exception $e) {
                log_message('error', 'Logout update failed: ' . $e->getMessage());
            }
        }

        // Delete remember cookie
        $response = service('response');
        $response->deleteCookie('remember_token');

        $session->destroy();
        return redirect()->to('/login');
    }
}
