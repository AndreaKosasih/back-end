<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\SubscribeTransaction;
use CodeIgniter\HTTP\ResponseInterface;

class SubscribeTransactionController extends BaseController
{
    public function index()
    {
        // Memuat database connection
        $db = \Config\Database::connect();
        $builder = $db->table('subscribe_transactions');

        // Melakukan join dengan tabel 'users' dan mengurutkan berdasarkan 'id'
        $builder->select('subscribe_transactions.*, users.name as user_name')
                ->join('users', 'users.id = subscribe_transactions.user_id')
                ->orderBy('subscribe_transactions.id', 'DESC');

        // Ambil hasilnya
        $transactions = $builder->get()->getResult();

        // Kirim data transaksi ke view
        return view('admin/transactions/index', ['transactions' => $transactions]);
    }
}
