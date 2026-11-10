<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\LaundryStatus;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan pelanggan.
     */
    public function index()
    {
        $pesanan = Transaction::with([
                'details.package',
                'payment',
            ])
            ->where('customer_id', auth()->id())
            ->latest('tanggal_masuk')
            ->latest('id')
            ->paginate(5);

        return view('pelanggan.orders.index', compact('pesanan'));
    }


    /**
     * Menampilkan form buat pesanan.
     */
    public function create()
    {
        $packages = Package::where('status', true)
            ->orderBy('id')
            ->get();

        return view('pelanggan.orders.create', compact('packages'));
    }


    /**
     * Menyimpan pesanan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => [
                'required',
                'exists:packages,id',
            ],

            'berat' => [
                'required',
                'numeric',
                'min:0.1',
            ],
        ], [
            'package_id.required' => 'Silakan pilih paket laundry.',
            'package_id.exists' => 'Paket laundry tidak ditemukan.',
            'berat.required' => 'Berat laundry wajib diisi.',
            'berat.numeric' => 'Berat laundry harus berupa angka.',
            'berat.min' => 'Berat laundry minimal 0,1 kg.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Ambil paket aktif
        |--------------------------------------------------------------------------
        */

        $package = Package::where('status', true)
            ->findOrFail($validated['package_id']);


        /*
        |--------------------------------------------------------------------------
        | Hitung harga
        |--------------------------------------------------------------------------
        */

        $berat = (float) $validated['berat'];

        $harga = (float) $package->harga_per_kg;

        $subtotal = $berat * $harga;

        $diskon = 0;

        $totalBayar = $subtotal - $diskon;


        /*
        |--------------------------------------------------------------------------
        | Simpan transaksi
        |--------------------------------------------------------------------------
        */

        $transaction = DB::transaction(function () use (
            $berat,
            $harga,
            $subtotal,
            $diskon,
            $totalBayar,
            $package
        ) {

            /*
            |--------------------------------------------------------------------------
            | Invoice
            |--------------------------------------------------------------------------
            */

            $invoice = 'INV-' . now()->format('Ymd') . '-' . strtoupper(
                Str::random(6)
            );


            /*
            |--------------------------------------------------------------------------
            | Transaction
            |--------------------------------------------------------------------------
            */

            $transaction = Transaction::create([
                'invoice' => $invoice,

                'customer_id' => auth()->id(),

                // Pesanan dari pelanggan belum memiliki kasir
                'cashier_id' => null,

                'total_berat' => $berat,

                'subtotal' => $subtotal,

                'diskon' => $diskon,

                'total_bayar' => $totalBayar,

                // Belum benar-benar dibayar
                'status_pembayaran' => 'belum_bayar',

                // Status laundry awal
                'status_laundry' => 'menunggu',

                'tanggal_masuk' => now(),

                'tanggal_selesai' => null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Transaction Detail
            |--------------------------------------------------------------------------
            */

            TransactionDetail::create([
                'transaction_id' => $transaction->id,

                'package_id' => $package->id,

                'berat' => $berat,

                'harga' => $harga,

                'subtotal' => $subtotal,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            |
            | Setiap transaksi baru langsung memiliki record payment.
            |
            */

            Payment::create([
                'transaction_id' => $transaction->id,

                // Metode belum dipilih
                'metode' => null,

                // Status awal pembayaran
                'status' => 'pending',

                'jumlah' => $totalBayar,

                'midtrans_order_id' => null,

                'midtrans_transaction_id' => null,

                'paid_at' => null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Laundry Status History
            |--------------------------------------------------------------------------
            */

            LaundryStatus::create([
                'transaction_id' => $transaction->id,

                'status' => 'menunggu',

                'keterangan' => 'Pesanan dibuat oleh pelanggan.',

                'updated_by' => auth()->id(),
            ]);


            return $transaction;
        });


        /*
        |--------------------------------------------------------------------------
        | Redirect ke halaman konfirmasi pesanan
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('pelanggan.orders.show', $transaction)
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    public function show(Transaction $transaction)
    {
        /*
        |--------------------------------------------------------------------------
        | Pastikan transaksi milik pelanggan yang sedang login
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $transaction->customer_id === auth()->id(),
            403
        );


        $transaction->load([
            'customer',
            'details.package',
            'payment',
            'laundryStatuses',
            'laundryStatuses.updater',
        ]);


        return view(
            'pelanggan.orders.show',
            compact('transaction')
        );
    }
}
