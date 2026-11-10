<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $customerId = Auth::id();

        // Semua pesanan milik pelanggan yang sedang login
        $transactions = Transaction::where('customer_id', $customerId);

        // Pesanan aktif = belum selesai
        $pesananAktif = (clone $transactions)
            ->where('status_laundry', '!=', 'selesai')
            ->count();

        // Pesanan yang belum dibayar
        $menungguPembayaran = (clone $transactions)
            ->where('status_pembayaran', 'belum_bayar')
            ->count();

        // Pesanan yang sedang diproses
        $sedangDiproses = (clone $transactions)
            ->whereIn('status_laundry', [
                'menunggu',
                'dicuci',
                'dikeringkan',
                'disetrika',
                'siap_diambil',
                'selesai',
            ])
            ->count();

        // Pesanan selesai
        $pesananSelesai = (clone $transactions)
            ->where('status_laundry', 'selesai')
            ->count();

        // Pesanan terbaru
        $pesananTerbaru = (clone $transactions)
            ->with(['details.package'])
            ->latest('tanggal_masuk')
            ->latest('id')
            ->take(5)
            ->get();

        return view('pelanggan.dashboard', compact(
            'pesananAktif',
            'menungguPembayaran',
            'sedangDiproses',
            'pesananSelesai',
            'pesananTerbaru'
        ));
    }
}
