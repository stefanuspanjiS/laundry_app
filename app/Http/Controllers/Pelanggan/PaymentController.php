<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Daftar pembayaran milik pelanggan.
     */
    public function index()
    {
        $pembayaran = Payment::with([
                'transaction'
            ])
            ->whereHas('transaction', function ($query) {
                $query->where('customer_id', auth()->id());
            })
            ->latest()
            ->get();

        return view('pelanggan.payments.index', compact('pembayaran'));
    }


    /**
     * Menampilkan halaman pembayaran.
     */
    public function show(Payment $payment)
    {
        /*
        |--------------------------------------------------------------------------
        | Pastikan payment milik pelanggan yang login
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $payment->transaction?->customer_id === auth()->id(),
            403
        );


        $payment->load([
            'transaction.customer',
            'transaction.details.package',
        ]);


        return view(
            'pelanggan.payments.show',
            compact('payment')
        );
    }

    public function cash(Payment $payment)
    {
        /*
        |--------------------------------------------------------------------------
        | Pastikan payment milik pelanggan login
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $payment->transaction?->customer_id === auth()->id(),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Hanya payment pending yang boleh memilih metode
        |--------------------------------------------------------------------------
        */

        if ($payment->status !== 'pending') {
            return redirect()
                ->route('pelanggan.payments.show', $payment)
                ->with('error', 'Pembayaran ini sudah diproses.');
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan metode cash
        |--------------------------------------------------------------------------
        |
        | Status tetap pending.
        |
        */

        $payment->update([
            'metode' => 'cash',
            'status' => 'pending',
        ]);


        return redirect()
            ->route('pelanggan.payments.show', $payment)
            ->with(
                'success',
                'Metode pembayaran Cash dipilih. Silakan lakukan pembayaran kepada kasir.'
            );
    }

    public function midtrans(Payment $payment)
    {
        abort_unless(
            $payment->transaction?->customer_id === auth()->id(),
            403
        );


        if ($payment->status !== 'pending') {
            return redirect()
                ->route('pelanggan.payments.show', $payment)
                ->with('error', 'Pembayaran ini sudah diproses.');
        }


        /*
        |--------------------------------------------------------------------------
        | Integrasi Midtrans akan dibuat di tahap berikutnya.
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('pelanggan.payments.show', $payment)
            ->with(
                'error',
                'Pembayaran Midtrans belum dikonfigurasi.'
            );
    }
}
