<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Daftar pembayaran
     */
    public function index(Request $request)
    {
        $query = Payment::with([
            'transaction.customer',
        ]);

        // Search invoice / pelanggan
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('transaction', function ($transaction) use ($search) {
                $transaction
                    ->where('invoice', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customer) use ($search) {
                        $customer->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        // Filter metode
        if ($request->filled('metode')) {
            $query->where(
                'metode',
                $request->metode
            );
        }

        // Filter tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->dari_tanggal
            );
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->sampai_tanggal
            );
        }

        $payments = $query
            ->latest()
            ->paginate(10);

        // Statistik
        $pembayaranBerhasil = Payment::where(
            'status',
            'success'
        )->count();

        $menungguPembayaran = Payment::where(
            'status',
            'pending'
        )->count();

        $pembayaranGagal = Payment::whereIn(
            'status',
            ['failed', 'expire']
        )->count();

        $totalPendapatan = Payment::where(
            'status',
            'success'
        )->sum('jumlah');

        return view(
            'admin.payments.index',
            compact(
                'payments',
                'pembayaranBerhasil',
                'menungguPembayaran',
                'pembayaranGagal',
                'totalPendapatan'
            )
        );
    }


    /**
     * Detail pembayaran
     */
    public function show(Payment $payment)
    {
        $payment->load([
            'transaction.customer',
            'transaction.cashier',
            'transaction.details.package',
        ]);

        return view(
            'admin.payments.show',
            compact('payment')
        );
    }


    /**
     * Form pembayaran cash
     */
    public function createCash(Transaction $transaction)
    {
        $transaction->load([
            'customer',
            'payment',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Kalau sudah dibayar
        |--------------------------------------------------------------------------
        |
        | Jangan gunakan return back() karena bisa menyebabkan redirect loop.
        |
        */
        if ($transaction->status_pembayaran === 'dibayar') {
            return redirect()
                ->route(
                    'admin.transactions.show',
                    $transaction
                )
                ->with(
                    'error',
                    'Transaksi ini sudah dibayar.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan payment tersedia
        |--------------------------------------------------------------------------
        */
        $payment = $transaction->payment;

        if (!$payment) {
            return redirect()
                ->route(
                    'admin.transactions.show',
                    $transaction
                )
                ->with(
                    'error',
                    'Data pembayaran untuk transaksi ini belum tersedia.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Payment yang sudah success tidak boleh diproses lagi
        |--------------------------------------------------------------------------
        */
        if ($payment->status === 'success') {
            return redirect()
                ->route(
                    'admin.transactions.show',
                    $transaction
                )
                ->with(
                    'error',
                    'Pembayaran transaksi ini sudah berhasil.'
                );
        }

        return view(
            'admin.payments.cash',
            compact(
                'transaction',
                'payment'
            )
        );
    }


    /**
     * Simpan / konfirmasi pembayaran cash
     */
    public function storeCash(
        Request $request,
        Transaction $transaction
    ) {
        $transaction->load('payment');

        $payment = $transaction->payment;

        /*
        |--------------------------------------------------------------------------
        | Pastikan payment tersedia
        |--------------------------------------------------------------------------
        */
        if (!$payment) {
            return redirect()
                ->route(
                    'admin.transactions.show',
                    $transaction
                )
                ->with(
                    'error',
                    'Data pembayaran untuk transaksi ini belum tersedia.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Jangan proses pembayaran yang sudah success
        |--------------------------------------------------------------------------
        */
        if (
            $transaction->status_pembayaran === 'dibayar' ||
            $payment->status === 'success'
        ) {
            return redirect()
                ->route(
                    'admin.transactions.show',
                    $transaction
                )
                ->with(
                    'error',
                    'Pembayaran transaksi ini sudah dikonfirmasi.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi nominal uang diterima
        |--------------------------------------------------------------------------
        */
        $validated = $request->validate([
            'jumlah' => [
                'required',
                'numeric',
                'min:' . $transaction->total_bayar,
            ],
        ], [
            'jumlah.required' =>
                'Jumlah uang yang diterima wajib diisi.',

            'jumlah.numeric' =>
                'Jumlah uang yang diterima harus berupa angka.',

            'jumlah.min' =>
                'Jumlah uang yang diterima harus minimal sebesar total pembayaran.',
        ]);

        $totalBayar = (float) $transaction->total_bayar;
        $jumlahDiterima = (float) $validated['jumlah'];

        $kembalian = $jumlahDiterima - $totalBayar;

        /*
        |--------------------------------------------------------------------------
        | Simpan pembayaran
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use (
            $transaction,
            $payment
        ) {

            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */
            $payment->update([
                'metode' => 'cash',
                'jumlah' => $transaction->total_bayar,
                'status' => 'success',
                'paid_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Transaction
            |--------------------------------------------------------------------------
            */
            $transaction->update([
                'status_pembayaran' => 'dibayar',

                /*
                | Admin/kasir yang mengonfirmasi pembayaran
                | dicatat sebagai cashier_id.
                */
                'cashier_id' => auth()->id(),
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Setelah berhasil → DETAIL TRANSAKSI
        |--------------------------------------------------------------------------
        |
        | Jangan redirect kembali ke /payment/cash.
        |
        */
        return redirect()
            ->route(
                'admin.transactions.show',
                $transaction
            )
            ->with(
                'success',
                'Pembayaran cash berhasil dikonfirmasi. ' .
                'Uang diterima Rp ' .
                number_format($jumlahDiterima, 0, ',', '.') .
                '. Kembalian Rp ' .
                number_format($kembalian, 0, ',', '.') .
                '.'
            );
    }
}
