<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\SubscribeTransaction;
use CodeIgniter\HTTP\ResponseInterface;

class SubscribeTransactionController extends BaseController
{
    public function index()
    {
        // Ambil koneksi database
        $db = \Config\Database::connect();

        // Buat query builder untuk join dengan tabel users
        $builder = $db->table('subscribe_transactions')
            ->select('subscribe_transactions.*, users.name as user_name') // Pilih kolom yang diperlukan, alias untuk name
            ->join('users', 'users.id = subscribe_transactions.user_id')  // Join dengan tabel users berdasarkan user_id
            ->orderBy('subscribe_transactions.id', 'desc');  // Urutkan berdasarkan id transaksi

        // Ambil hasil transaksi
        $transactions = $builder->get()->getResult();

        // Kirim data transaksi ke view
        return view('admin/transactions/index', ['transactions' => $transactions]);
    }
}
