<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Daftar pembayaran.
     */
    public function index(Request $request)
    {
        $query = Payment::with([
            'transaction.customer',
        ])->latest();

        // Search invoice / nama pelanggan
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('transaction', function ($q) use ($search) {
                $q->where('invoice', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customer) use ($search) {
                        $customer->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter status payment
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter metode
        if ($request->filled('metode')) {
            $query->where('metode', $request->metode);
        }

        $payments = $query
            ->paginate(5)
            ->withQueryString();

        return view('kasir.payments.index', compact('payments'));
    }

    /**
     * Detail pembayaran.
     */
    public function show(Payment $payment)
    {
        $payment->load([
            'transaction.customer',
            'transaction.cashier',
            'transaction.details.package',
            'transaction.laundryStatuses.updater',
        ]);

        return view('kasir.payments.show', compact('payment'));
    }

    /**
     * Form pembayaran cash.
     */
    public function createCash(Payment $payment)
    {
        $payment->load('transaction.customer');

        // Jangan bayar ulang transaksi yang sudah dibayar.
        abort_if(
            $payment->status === 'success',
            403,
            'Pembayaran transaksi ini sudah berhasil.'
        );

        return view('kasir.payments.cash', compact('payment'));
    }

    /**
     * Proses pembayaran cash.
     */
    public function storeCash(Request $request, Payment $payment)
    {
        $payment->load('transaction');

        // Cegah pembayaran ulang.
        abort_if(
            $payment->status === 'success',
            403,
            'Pembayaran transaksi ini sudah berhasil.'
        );

        $request->validate([
            'jumlah_bayar' => [
                'required',
                'numeric',
                'min:' . $payment->transaction->total_bayar,
            ],
        ], [
            'jumlah_bayar.required' => 'Jumlah uang pembayaran wajib diisi.',
            'jumlah_bayar.numeric' => 'Jumlah pembayaran harus berupa angka.',
            'jumlah_bayar.min' => 'Jumlah pembayaran kurang dari total tagihan.',
        ]);

        DB::transaction(function () use ($request, $payment) {

            $transaction = Transaction::lockForUpdate()
                ->findOrFail($payment->transaction_id);

            // Double protection.
            if ($transaction->status_pembayaran === 'dibayar') {
                abort(
                    403,
                    'Transaksi ini sudah dibayar.'
                );
            }

            $jumlahBayar = (float) $request->jumlah_bayar;
            $totalBayar = (float) $transaction->total_bayar;

            $kembalian = $jumlahBayar - $totalBayar;

            // Update payment
            $payment->update([
                'metode' => 'cash',
                'jumlah' => $totalBayar,
                'status' => 'success',
                'paid_at' => now(),
            ]);

            // Update transaction
            $transaction->update([
                'status_pembayaran' => 'dibayar',
                'cashier_id' => auth()->id(),
            ]);

            // Simpan kembalian hanya untuk kebutuhan halaman.
            session()->flash(
                'kembalian',
                $kembalian
            );
        });

        return redirect()
            ->route(
                'kasir.payments.show',
                $payment
            )
            ->with(
                'success',
                'Pembayaran cash berhasil diproses.'
            );
    }
}
