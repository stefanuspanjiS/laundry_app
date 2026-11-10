<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with([
            'customer',
            'cashier',
        ])
        ->where('status_laundry', '!=', 'selesai');

        // Search invoice / nama pelanggan
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('invoice', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customer) use ($search) {
                        $customer->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter status laundry
        if ($request->filled('status')) {
            $query->where('status_laundry', $request->status);
        }

        $pesanan = $query
            ->latest('tanggal_masuk')
            ->latest('id')
            ->get();

        $statuses = [
            'menunggu' => 'Menunggu',
            'dicuci' => 'Dicuci',
            'dikeringkan' => 'Dikeringkan',
            'disetrika' => 'Disetrika',
            'siap_diambil' => 'Siap Diambil',
        ];

        return view('admin.pesanan.index', compact(
            'pesanan',
            'statuses'
        ));
    }
}
