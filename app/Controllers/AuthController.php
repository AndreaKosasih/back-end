<?php
namespace App\Controllers;

use App\Models\User;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return view('login'); // Tampilkan halaman login
    }

    public function register()
    {
        return view('register'); 
    }

    public function authenticate()
    {
        $session = session();
        $userModel = new User();
        $db = \Config\Database::connect();

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email'    => 'required|valid_email',
            'password' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil data input
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan email
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Ambil role pengguna dari tabel role_user melalui join
                $roleQuery = $db->table('role_user')
                    ->select('roles.name as role')
                    ->join('roles', 'role_user.role_id = roles.id')
                    ->where('role_user.user_id', $user['id'])
                    ->get()
                    ->getRow();

                // Cek apakah role ditemukan
                $role = $roleQuery ? $roleQuery->role : 'student'; // Default role jika tidak ditemukan

                // Simpan data user ke session
                $sessionData = [
                    'user_id'    => $user['id'],
                    'name'       => $user['name'],
                    'role'       => $role, // Role dari tabel role_user
                    'isLoggedIn' => true,
                ];
                $session->set($sessionData);

                // Redirect berdasarkan role
                return $this->redirectBasedOnRole($role);
            } else {
                // Password salah
                $session->setFlashdata('login_error', 'Invalid password. Please try again.');
                return redirect()->back()->withInput();
            }
        } else {
            // User tidak ditemukan
            $session->setFlashdata('login_error', 'No account found with that email.');
            return redirect()->back()->withInput();
        }
    }

    public function registerUser()
{
    $session = session();
    $userModel = new User();
    $roleUserModel = new \App\Models\RoleUserModel(); // Menggunakan RoleModel untuk menyisipkan data ke role_user
    $db = \Config\Database::connect();

    // Validasi input
    $validation = \Config\Services::validation();
    $validation->setRules([
        'name'      => 'required|min_length[3]|max_length[50]',
        'email'     => 'required|valid_email|is_unique[users.email]',
        'password'  => 'required|min_length[8]',
        'occupation' => 'required|min_length[3]|max_length[100]', // Validasi untuk occupation
        'avatar'    => 'is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|max_size[avatar,1024]',
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    // Ambil data input
    $name = $this->request->getPost('name');
    $email = $this->request->getPost('email');
    $occupation = $this->request->getPost('occupation');
    $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

    // Handle avatar upload
    $avatar = $this->request->getFile('avatar');
    $avatarName = null;

    if ($avatar->isValid() && !$avatar->hasMoved()) {
        // Generate unique file name
        $avatarName = $avatar->getRandomName();
        // Move file to the desired directory
        $avatar->move(WRITEPATH . 'uploads/avatars', $avatarName);
    }

    // Siapkan data untuk disimpan ke tabel users
    $userData = [
        'name'       => $name,
        'email'      => $email,
        'password'   => $password,
        'avatar'     => $avatarName,  // Save avatar name in the database
        'occupation' => $occupation, // Tambahkan occupation
    ];

    // Cek apakah $userData tidak kosong
    if (empty($userData['name']) || empty($userData['email']) || empty($userData['password']) || empty($userData['occupation'])) {
        return redirect()->back()->withInput()->with('errors', ['Please fill in all required fields.']);
    }

    // Insert user data into the database
    $userModel->save($userData);

    // Ambil user_id secara manual berdasarkan email
    $user = $userModel->where('email', $email)->first(); // Cari berdasarkan email
    if (!$user) {
        // Jika user tidak ditemukan setelah insert
        return redirect()->back()->withInput()->with('errors', ['Failed to register user.']);
    }
    
    $userId = $user['id']; // Ambil user_id

    // Set default role as 'student' and save to role_user table
    // Here, we set the default role as 2 (student)
    $roleUserModel->save([
        'user_id' => $userId,
        'role_id' => 2, // Default role_id for student is 2
    ]);

    // Set session data
    $session->set([
        'user_id'    => $userId,
        'name'       => $name,
        'role'       => 'student',  // Default role is 'student'
        'isLoggedIn' => true,
    ]);

    // Redirect to the student dashboard or the appropriate page
    return redirect()->to('/login');
}
    

    

    private function redirectBasedOnRole($role)
    {
        switch ($role) {
            case 'owner':
                return redirect()->to('/admin/dashboard'); // Redirect ke dashboard admin
            case 'teacher':
                return redirect()->to('/teacher/dashboard'); // Redirect ke dashboard teacher
            case 'student':
                return redirect()->to('/student/dashboard'); // Redirect ke dashboard student
            default:
                return redirect()->to('/dashboard'); // Default redirect jika role tidak dikenali
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy(); // Hapus semua data session
        return redirect()->to('/login'); // Redirect ke halaman login
    }
}
