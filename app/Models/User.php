<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password', 'avatar', 'occupation'];

    /**
     * Get all roles assigned to the user.
     *
     * @return array
     */
    public function roles()
    {
        return $this->db->table('role_user')
            ->where('user_id', $this->id)
            ->join('roles', 'role_user.role_id = roles.id')
            ->get()
            ->getResult();
    }

    /**
     * Check if the user has a specific role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        $roles = $this->roles();
        if (!$roles) {
            return false;
        }

        foreach ($roles as $r) {
            if ($r->name === $role) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get all courses the user is enrolled in.
     *
     * @return array
     */
    public function courses()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('course_students')
            ->select('courses.*')
            ->join('courses', 'courses.id = course_students.course_id')
            ->where('course_students.user_id', $this->id);

        return $builder->get()->getResultArray();
    }

    public function subscribe_transactions()
    {
        $db = \Config\Database::connect();
        return $db->table('subscribe_transactions')
            ->where('user_id', $this->id)
            ->get()
            ->getResultArray();
    }


    public function hasActiveSubscription()
    {
        $db = \Config\Database::connect();
    
        // Ambil langganan terbaru yang sudah dibayar
        $latestSubscription = $db->table('subscribe_transactions')
            ->where('user_id', $this->id)
            ->where('is_paid', true)
            ->orderBy('updated_at', 'DESC')
            ->get()
            ->getRow();
    
        if (!$latestSubscription || !$latestSubscription->subscription_start_date) {
            return false; // Tidak ada langganan aktif
        }
    
        // Hitung tanggal akhir langganan
        $subscriptionStartDate = new \DateTime($latestSubscription->subscription_start_date);
        $subscriptionEndDate = (clone $subscriptionStartDate)->modify('+1 month');
    
        // Cek apakah tanggal sekarang masih dalam rentang langganan
        $currentDate = new \DateTime();
        return $currentDate <= $subscriptionEndDate;
    }
}    
