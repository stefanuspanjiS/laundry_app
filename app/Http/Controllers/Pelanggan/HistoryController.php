<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class HistoryController extends Controller
{
    public function index()
    {
        $riwayat = Transaction::with([
                'details.package'
            ])
            ->where('customer_id', auth()->id())
            ->where('status_laundry', 'selesai')
            ->latest('tanggal_selesai')
            ->latest('id')
            ->get();

        return view('pelanggan.history.index', compact('riwayat'));
    }
}
