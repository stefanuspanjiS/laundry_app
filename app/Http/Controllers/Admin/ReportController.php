<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dariTanggal = $request->input('dari_tanggal');
        $sampaiTanggal = $request->input('sampai_tanggal');

        $query = Transaction::query();

        // Filter berdasarkan tanggal masuk
        if ($dariTanggal) {
            $query->whereDate('tanggal_masuk', '>=', $dariTanggal);
        }

        if ($sampaiTanggal) {
            $query->whereDate('tanggal_masuk', '<=', $sampaiTanggal);
        }

        // Clone query agar data laporan tetap menggunakan filter yang sama
        $totalTransaksi = (clone $query)->count();

        $totalBerat = (clone $query)->sum('total_berat');

        $totalPendapatan = (clone $query)->sum('total_bayar');

        $transactions = $query
            ->with('customer')
            ->latest('tanggal_masuk')
            ->get();

        return view('admin.reports.index', compact(
            'dariTanggal',
            'sampaiTanggal',
            'totalTransaksi',
            'totalBerat',
            'totalPendapatan',
            'transactions'
        ));
    }
}
