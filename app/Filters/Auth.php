<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            // Check for remember token cookie
            $rememberToken = get_cookie('remember_token');
            if ($rememberToken) {
                $userModel = new \App\Models\User();
                $user = $userModel->where('remember_token', $rememberToken)
                    ->where('remember_expires_at >', date('Y-m-d H:i:s'))
                    ->first();

                if ($user) {
                    // Get user role
                    $db = \Config\Database::connect();
                    $roleQuery = $db->table('role_user')
                        ->select('roles.name as role')
                        ->join('roles', 'roles.id = role_user.role_id')
                        ->where('role_user.user_id', $user['id'])
                        ->get()
                        ->getRow();

                    $role = $roleQuery ? $roleQuery->role : 'student';

                    // Log user in
                    session()->set([
                        'user_id'    => $user['id'],
                        'name'       => $user['name'],
                        'role'       => $role,
                        'isLoggedIn' => true,
                    ]);

                    return;
                }
            }
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak diperlukan untuk after
    }
}
