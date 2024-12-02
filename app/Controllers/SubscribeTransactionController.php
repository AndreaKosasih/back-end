<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class SubscribeTransactionController extends BaseController
{
    public function index()
    {
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

    public function show($id)
    {
        $db = \Config\Database::connect();
    
        // Ambil detail transaksi beserta nama pengguna dan bukti pembayaran
        $transaction = $db->table('subscribe_transactions')
            ->select('subscribe_transactions.*, users.name as user_name, users.avatar as user_avatar')  // Gabungkan dengan nama dan avatar pengguna
            ->join('users', 'users.id = subscribe_transactions.user_id')  // Join dengan tabel users
            ->where('subscribe_transactions.id', $id)
            ->get()
            ->getRow();
    
        if (!$transaction) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Transaction not found');
        }
    
        // Tentukan jalur untuk proof
        $proofPath = WRITEPATH . 'uploads/proof/' . $transaction->proof;
        if (!file_exists($proofPath) || empty($transaction->proof)) {
            $transaction->proof_url = base_url('uploads/proof/default-proof.jpg'); // Gambar default jika bukti pembayaran tidak ditemukan
        } else {
            $transaction->proof_url = base_url('uploads/proof/' . $transaction->proof); // URL untuk file proof
        }
    
        // Kirim data ke view
        return view('admin/transactions/show', ['transaction' => $transaction]);
    }

    public function update($id)
    {
        $db = \Config\Database::connect();

        // Gunakan query builder untuk melakukan update
        $builder = $db->table('subscribe_transactions');
        $updateData = [
            'is_paid' => true,
            'subscription_start_date' => date('Y-m-d H:i:s'), // Gunakan format datetime sekarang
        ];

        try {
            $builder->where('id', $id)->update($updateData);
            return redirect()->to('/admin/transactions/show/' . $id)->with('success', 'Transaction updated successfully.');
        } catch (DatabaseException $e) {
            return redirect()->back()->with('error', 'Failed to update transaction: ' . $e->getMessage());
        }
    }

    public function updatePending($id)
    {
        $db = \Config\Database::connect();

        // Gunakan query builder untuk melakukan update
        $builder = $db->table('subscribe_transactions');
        $updateData = [
            'is_paid' => false,
            'subscription_start_date' => date('Y-m-d H:i:s'), // Gunakan format datetime sekarang
        ];

        try {
            $builder->where('id', $id)->update($updateData);
            return redirect()->to('/admin/transactions/show/' . $id)->with('success', 'Transaction updated successfully.');
        } catch (DatabaseException $e) {
            return redirect()->back()->with('error', 'Failed to update transaction: ' . $e->getMessage());
        }
    }
}
