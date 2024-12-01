<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Role implements FilterInterface
{
    /**
     * Pre-filters the incoming request
     * @param RequestInterface $request
     * @param array|null $arguments
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Ambil role dari session
        $role = session()->get('role');

        // Jika tidak ada role, atau role yang diberikan tidak sesuai
        if (!$role || ($arguments && !in_array($role, $arguments))) {
            // Redirect ke dashboard dengan pesan error
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access. You do not have the required permissions.');
        }
    }

    /**
     * Post-filters the outgoing response (not needed for this case)
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param array|null $arguments
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada tindakan setelah request
    }
}
