<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\Controller;

// class AuthController extends Controller
// {
//     public function login()
//     {
//         return view('login'); // Tampilkan halaman login
//     }

//     public function register()
//     {
//         return view('register');
//     }

//     public function authenticate()
//     {
//         $session = session();
//         $userModel = new User();
//         $db = \Config\Database::connect();

//         // Validasi input
//         $validation = \Config\Services::validation();
//         $validation->setRules([
//             'email'    => 'required|valid_email',
//             'password' => 'required',
//         ]);

//         if (!$validation->withRequest($this->request)->run()) {
//             return redirect()->back()->withInput()->with('errors', $validation->getErrors());
//         }

//         $email = $this->request->getPost('email');
//         $password = $this->request->getPost('password');
//         $user = $userModel->where('email', $email)->first();

//         if ($user && password_verify($password, $user['password'])) {
//             $roleQuery = $db->table('role_user')
//                 ->select('roles.name as role')
//                 ->join('roles', 'role_user.role_id = roles.id')
//                 ->where('role_user.user_id', $user['id'])
//                 ->get()
//                 ->getRow();

//             $role = $roleQuery ? $roleQuery->role : 'student';

//             $dashboardData = $this->getDashboardData($role, $user['id']);

//             $sessionData = array_merge([
//                 'user_id'    => $user['id'],
//                 'name'       => $user['name'],
//                 'role'       => $role,
//                 'isLoggedIn' => true,
//             ], $dashboardData);

//             $session->set($sessionData);
//             return $this->redirectBasedOnRole($role);
//         }

//         $session->setFlashdata('login_error', 'Invalid email or password.');
//         return redirect()->back()->withInput();
//     }


//     // public function authenticate()
//     // {
//     //     $session = session();
//     //     $userModel = new User();
//     //     $db = \Config\Database::connect();

//     //     // Validasi input
//     //     $validation = \Config\Services::validation();
//     //     $validation->setRules([
//     //         'email'    => 'required|valid_email',
//     //         'password' => 'required',
//     //     ]);

//     //     if (!$validation->withRequest($this->request)->run()) {
//     //         return redirect()->back()->withInput()->with('errors', $validation->getErrors());
//     //     }

//     //     // Ambil data input
//     //     $email = $this->request->getPost('email');
//     //     $password = $this->request->getPost('password');

//     //     // Cari user berdasarkan email
//     //     $user = $userModel->where('email', $email)->first();

//     //     if ($user) {
//     //         // Verifikasi password
//     //         if (password_verify($password, $user['password'])) {
//     //             // Ambil role pengguna dari tabel role_user melalui join
//     //             $roleQuery = $db->table('role_user')
//     //                 ->select('roles.name as role')
//     //                 ->join('roles', 'role_user.role_id = roles.id')
//     //                 ->where('role_user.user_id', $user['id'])
//     //                 ->get()
//     //                 ->getRow();

//     //             // Cek apakah role ditemukan
//     //             $role = $roleQuery ? $roleQuery->role : 'student'; // Default role jika tidak ditemukan

//     //             // Simpan data user ke session
//     //             $sessionData = [
//     //                 'user_id'    => $user['id'],
//     //                 'name'       => $user['name'],
//     //                 'role'       => $role, // Role dari tabel role_user
//     //                 'isLoggedIn' => true,
//     //             ];
//     //             $session->set($sessionData);

//     //             // Redirect berdasarkan role
//     //             return $this->redirectBasedOnRole($role);
//     //         } else {
//     //             // Password salah
//     //             $session->setFlashdata('login_error', 'Invalid password. Please try again.');
//     //             return redirect()->back()->withInput();
//     //         }
//     //     } else {
//     //         // User tidak ditemukan
//     //         $session->setFlashdata('login_error', 'No account found with that email.');
//     //         return redirect()->back()->withInput();
//     //     }
//     // }

//     private function getDashboardData($role, $userId)
//     {
//         $db = \Config\Database::connect();

//         switch ($role) {
//             case 'owner':
//                 return [
//                     'courses'      => $db->table('courses')->countAllResults(),
//                     'transactions' => $db->table('subscribe_transactions')->countAllResults(),
//                     'students'     => $db->table('role_user')
//                         ->join('roles', 'role_user.role_id = roles.id')
//                         ->where('roles.name', 'student')
//                         ->countAllResults(),
//                     'teachers'     => $db->table('teachers')->countAllResults(),
//                     'categories'   => $db->table('categories')->countAllResults(),
//                 ];
//             case 'teacher':
//                 return [
//                     'courses'  => $db->table('courses')->where('teacher_id', $userId)->countAllResults(),
//                     'students' => $db->table('course_students')
//                         ->join('courses', 'course_students.course_id = courses.id')
//                         ->where('courses.teacher_id', $userId)
//                         ->countAllResults(),
//                 ];
//             case 'student':
//                 return [
//                     'enrolled_courses' => $db->table('course_students')->where('user_id', $userId)->countAllResults(),
//                     'transactions'     => $db->table('subscribe_transactions')->where('user_id', $userId)->countAllResults(),
//                 ];
//             default:
//                 return [];
//         }
//     }


//     public function registerUser()
//     {
//         $session = session();
//         $userModel = new User();
//         $roleUserModel = new \App\Models\RoleUserModel();
//         $db = \Config\Database::connect();

//         // Validasi input
//         $validation = \Config\Services::validation();
//         $validation->setRules([
//             'name'      => 'required|min_length[3]|max_length[50]',
//             'email'     => 'required|valid_email|is_unique[users.email]',
//             'password'  => 'required|min_length[8]',
//             'occupation' => 'required|min_length[3]|max_length[100]', // Validasi untuk occupation
//             'avatar'    => 'is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|max_size[avatar,1024]',
//         ]);

//         if (!$validation->withRequest($this->request)->run()) {
//             return redirect()->back()->withInput()->with('errors', $validation->getErrors());
//         }

//         // Ambil data input
//         $name = $this->request->getPost('name');
//         $email = $this->request->getPost('email');
//         $occupation = $this->request->getPost('occupation');
//         $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

//         // Handle avatar upload
//         $avatar = $this->request->getFile('avatar');
//         $avatarName = null;

//         if ($avatar->isValid() && !$avatar->hasMoved()) {
//             // Generate unique file name
//             $avatarName = $avatar->getRandomName();
//             // Move file to the desired directory
//             $avatar->move(WRITEPATH . 'uploads/avatars', $avatarName);
//         }

//         // Siapkan data untuk disimpan ke tabel users
//         $userData = [
//             'name'       => $name,
//             'email'      => $email,
//             'password'   => $password,
//             'avatar'     => $avatarName,  // Save avatar name in the database
//             'occupation' => $occupation, // Tambahkan occupation
//         ];

//         // Cek apakah $userData tidak kosong
//         if (empty($userData['name']) || empty($userData['email']) || empty($userData['password']) || empty($userData['occupation'])) {
//             return redirect()->back()->withInput()->with('errors', ['Please fill in all required fields.']);
//         }

//         // Insert user data into the database
//         $userModel->save($userData);

//         // Ambil user_id berdasarkan email
//         $user = $userModel->where('email', $email)->first(); // Cari berdasarkan email
//         if (!$user) {
//             // Jika user tidak ditemukan setelah insert
//             return redirect()->back()->withInput()->with('errors', ['Failed to register user.']);
//         }

//         $userId = $user['id']; // Ambil user_id

//         // Role ID untuk student adalah 2
//         $roleId = 2; // Default role_id untuk student adalah 2

//         // Masukkan data ke tabel role_user
//         $roleUserModel->insert([
//             'user_id' => $userId,
//             'role_id' => $roleId, // Role student
//         ]);

//         // Set session data
//         $session->set([
//             'user_id'    => $userId,
//             'name'       => $name,
//             'role'       => 'student',  // Default role is 'student'
//             'isLoggedIn' => true,
//         ]);

//         // Redirect ke halaman login atau halaman yang sesuai
//         return redirect()->to('/login');
//     }

//     private function redirectBasedOnRole($role)
//     {
//         switch ($role) {
//             case 'owner':
//                 return redirect()->to('/admin/dashboard'); // Redirect ke dashboard admin
//             case 'teacher':
//                 return redirect()->to('/teacher/dashboard'); // Redirect ke dashboard teacher
//             case 'student':
//                 return redirect()->to('/student/dashboard'); // Redirect ke dashboard student
//             default:
//                 return redirect()->to('/dashboard'); // Default redirect jika role tidak dikenali
//         }
//     }

//     public function logout()
//     {
//         $session = session();
//         $session->destroy(); // Hapus semua data session
//         return redirect()->to('/login'); // Redirect ke halaman login
//     }
// }

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

    // public function authenticate()
    // {
    //     $session = session();
    //     $userModel = new User();
    //     $db = \Config\Database::connect();

    //     if (!$this->validate([
    //         'email'    => 'required|valid_email',
    //         'password' => 'required',
    //     ])) {
    //         return redirect()->back()
    //             ->withInput()
    //             ->with('errors', $this->validator->getErrors());
    //     }

    //     $email = $this->request->getPost('email');
    //     $password = $this->request->getPost('password');

    //     $user = $userModel->where('email', $email)->first();

    //     if ($user && password_verify($password, $user['password'])) {
    //         // Get role
    //         $roleQuery = $db->table('role_user')
    //             ->select('roles.name as role')
    //             ->join('roles', 'role_user.role_id = roles.id')
    //             ->where('role_user.user_id', $user['id'])
    //             ->get()
    //             ->getRow();

    //         $role = $roleQuery ? $roleQuery->role : 'student';

    //         // Set session data with user info
    //         $sessionData = [
    //             'user_id' => $user['id'],
    //             'name' => $user['name'],
    //             'email' => $user['email'],
    //             'role' => $role,
    //             'avatar' => $user['avatar'],
    //             'occupation' => $user['occupation'],
    //             'isLoggedIn' => true
    //         ];

    //         $session->set($sessionData);

    //         // Redirect with user data
    //         return $this->redirectBasedOnRole($role);
    //     }

    //     return redirect()->back()
    //         ->withInput()
    //         ->with('login_error', 'Invalid email or password');
    // }

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


    public function authenticate()
    {
        $session = session();
        $userModel = new User();
        $db = \Config\Database::connect();

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email'    => 'required|valid_email',
            'password' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $rememberMe = $this->request->getPost('remember') == 'on';

        // Find user by email
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Get user role
            $roleQuery = $db->table('role_user')
                ->select('roles.name as role')
                ->join('roles', 'role_user.role_id = roles.id')
                ->where('role_user.user_id', $user['id'])
                ->get()
                ->getRow();

            $role = $roleQuery ? $roleQuery->role : 'student';

            // Handle Remember Me
            if ($rememberMe) {
                $rememberToken = bin2hex(random_bytes(32));
                $expiresAt = date('Y-m-d H:i:s', strtotime('+30 days'));

                try {
                    $userModel->update($user['id'], [
                        'remember_token' => $rememberToken,
                        'remember_expires_at' => $expiresAt
                    ]);

                    $response = service('response');
                    $response->setCookie([
                        'name' => 'remember_token',
                        'value' => $rememberToken,
                        'expire' => 2592000,
                        'secure' => true,
                        'httponly' => true
                    ]);
                } catch (\Exception $e) {
                    log_message('error', 'Remember token update failed: ' . $e->getMessage());
                }
            }

            // Set session data
            $sessionData = [
                'user_id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $role,
                'avatar' => $user['avatar'] ?? 'images/default-avatar.png',
                'occupation' => $user['occupation'],
                'isLoggedIn' => true
            ];

            $session->set($sessionData);

            // Redirect based on role
            return $this->redirectBasedOnRole($role);
        }

        return redirect()->back()
            ->withInput()
            ->with('login_error', 'Invalid email or password');
    }

    private function getDashboardData($role, $userId)
    {
        switch ($role) {
            case 'owner':
                return [
                    'courses'     => $this->getCoursesCount(),
                    'transactions' => $this->getTransactionsCount(),
                    'students'    => $this->getStudentsCount(),
                    'teachers'    => $this->getTeachersCount(),
                    'categories'  => $this->getCategoriesCount(),
                ];
            case 'teacher':
                return [
                    'courses'     => $this->getCoursesTaught($userId),
                    'students'    => $this->getStudentsForTeacher($userId),
                    'categories'  => $this->getCategoriesForTeacher($userId),
                ];
            case 'student':
                return [
                    'enrolledCourses' => $this->getEnrolledCourses($userId),
                    'categories'      => $this->getCategoriesForStudent($userId),
                ];
            default:
                return [];
        }
    }

    private function getCoursesCount()
    {
        $db = \Config\Database::connect();
        return $db->table('courses')->countAllResults();
    }

    private function getTransactionsCount()
    {
        $db = \Config\Database::connect();
        return $db->table('subscribe_transactions')->countAllResults();
    }

    private function getStudentsCount()
    {
        $db = \Config\Database::connect();
        return $db->table('users')
            ->join('role_user', 'users.id = role_user.user_id')
            ->where('role_user.role_id', 2) // Role ID untuk student
            ->countAllResults();
    }

    private function getTeachersCount()
    {
        $db = \Config\Database::connect();
        return $db->table('users')
            ->join('role_user', 'users.id = role_user.user_id')
            ->where('role_user.role_id', 3) // Role ID untuk teacher
            ->countAllResults();
    }

    private function getCategoriesCount()
    {
        $db = \Config\Database::connect();
        return $db->table('categories')->countAllResults();
    }

    private function getCoursesTaught($teacherId)
    {
        $db = \Config\Database::connect();
        return $db->table('courses')->where('teacher_id', $teacherId)->countAllResults();
    }

    private function getStudentsForTeacher($teacherId)
    {
        $db = \Config\Database::connect();
        return $db->table('course_students')
            ->join('courses', 'courses.id = course_students.course_id')
            ->where('courses.teacher_id', $teacherId)
            ->countAllResults();
    }

    private function getCategoriesForTeacher($teacherId)
    {
        $db = \Config\Database::connect();
        return $db->table('categories')
            ->select('categories.name')
            ->join('courses', 'categories.id = courses.category_id')
            ->where('courses.teacher_id', $teacherId)
            ->countAllResults();
    }

    private function getEnrolledCourses($studentId)
    {
        $db = \Config\Database::connect();
        return $db->table('courses')
            ->join('course_students', 'courses.id = course_students.course_id')
            ->where('course_students.user_id', $studentId)
            ->countAllResults();
    }

    private function getCategoriesForStudent($studentId)
    {
        $db = \Config\Database::connect();
        return $db->table('categories')
            ->select('categories.name')
            ->join('courses', 'categories.id = courses.category_id')
            ->join('course_students', 'courses.id = course_students.course_id')
            ->where('course_students.user_id', $studentId)
            ->countAllResults();
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
