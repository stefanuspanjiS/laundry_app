<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = User::where('role', 'pelanggan')->count();

        $totalTransaksi = Transaction::count();

        $belumBayar = Transaction::where(
            'status_pembayaran',
            'belum_bayar'
        )->count();

        $laundryDiproses = Transaction::whereNotIn(
            'status_laundry',
            ['selesai']
        )->count();

        // Transaksi terbaru
        $transaksiTerbaru = Transaction::with('customer')
            ->latest('tanggal_masuk')
            ->take(5)
            ->get();

        // Statistik status laundry
        $statusLaundry = [
            'menunggu' => Transaction::where(
                'status_laundry',
                'menunggu'
            )->count(),

            'dicuci' => Transaction::where(
                'status_laundry',
                'dicuci'
            )->count(),

            'dikeringkan' => Transaction::where(
                'status_laundry',
                'dikeringkan'
            )->count(),

            'disetrika' => Transaction::where(
                'status_laundry',
                'disetrika'
            )->count(),

            'siap_diambil' => Transaction::where(
                'status_laundry',
                'siap_diambil'
            )->count(),

            'selesai' => Transaction::where(
                'status_laundry',
                'selesai'
            )->count(),
        ];

        return view('kasir.dashboard', compact(
            'totalPelanggan',
            'totalTransaksi',
            'belumBayar',
            'laundryDiproses',
            'transaksiTerbaru',
            'statusLaundry'
        ));
    }
}
