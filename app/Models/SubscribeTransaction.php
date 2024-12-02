<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscribeTransaction extends Model
{
    protected $table            = 'subsribe_transactions';
    protected $primaryKey       = 'id';

    // Tambahkan ini agar CI4 menangani timestamps otomatis
    protected $useTimestamps = true;

    // Kolom timestamps
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    protected $allowedFields    = ['total_amount', 'is_paid', 'user_id', 'proof', 'subscription_start_date'];

    /**
     * Get the user associated with this subscription transaction.
     *
     * 
     */

     // Definisikan relasi 'user'
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    // public function user()
    // {
    //     $userModel = new \App\Models\User();
    //     return $userModel->find($this->user_id);
    // }

    // Menggunakan query builder
    public function getTransactions()
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }
}
