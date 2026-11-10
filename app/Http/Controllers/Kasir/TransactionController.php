<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\LaundryStatus;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Daftar pesanan.
     */
    public function index(Request $request)
    {
        $query = Transaction::with([
            'customer',
            'payment',
        ])->latest('tanggal_masuk');


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('invoice', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customer) use ($search) {
                        $customer->where('name', 'like', "%{$search}%");
                    });

            });
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status_pembayaran')) {

            $query->where(
                'status_pembayaran',
                $request->status_pembayaran
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER LAUNDRY
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status_laundry')) {

            $query->where(
                'status_laundry',
                $request->status_laundry
            );
        }


        $transactions = $query
            ->paginate(10)
            ->withQueryString();


        return view(
            'kasir.transactions.index',
            compact('transactions')
        );
    }


    /**
     * Form membuat pesanan.
     */
    public function create()
    {
        $customers = User::where('role', 'pelanggan')
            ->orderBy('name')
            ->get();

        $packages = Package::where('status', 'aktif')
            ->orderBy('nama_paket')
            ->get();


        return view(
            'kasir.transactions.create',
            compact(
                'customers',
                'packages'
            )
        );
    }


    /**
     * Simpan pesanan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'customer_id' => [
                'required',
                'exists:users,id',
            ],

            'diskon' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'packages' => [
                'required',
                'array',
                'min:1',
            ],

            'packages.*.package_id' => [
                'required',
                'exists:packages,id',
            ],

            'packages.*.berat' => [
                'required',
                'numeric',
                'min:0.1',
            ],

        ], [

            'customer_id.required' =>
                'Pelanggan wajib dipilih.',

            'packages.required' =>
                'Minimal satu paket harus dipilih.',

            'packages.min' =>
                'Minimal satu paket harus dipilih.',

            'packages.*.package_id.required' =>
                'Paket wajib dipilih.',

            'packages.*.berat.required' =>
                'Berat wajib diisi.',

            'packages.*.berat.min' =>
                'Berat harus lebih dari 0.',

        ]);


        $transaction = null;


        DB::transaction(function () use (
            $validated,
            &$transaction
        ) {

            /*
            |--------------------------------------------------------------------------
            | HITUNG DETAIL
            |--------------------------------------------------------------------------
            */

            $subtotal = 0;
            $totalBerat = 0;
            $details = [];


            foreach ($validated['packages'] as $item) {

                $package = Package::findOrFail(
                    $item['package_id']
                );

                $berat = (float) $item['berat'];

                $harga = (float) $package->harga_per_kg;

                $detailSubtotal = $berat * $harga;


                $subtotal += $detailSubtotal;

                $totalBerat += $berat;


                $details[] = [

                    'package_id' =>
                        $package->id,

                    'berat' =>
                        $berat,

                    'harga' =>
                        $harga,

                    'subtotal' =>
                        $detailSubtotal,

                ];
            }


            /*
            |--------------------------------------------------------------------------
            | HITUNG DISKON
            |--------------------------------------------------------------------------
            */

            $diskon = (float) (
                $validated['diskon'] ?? 0
            );


            if ($diskon > $subtotal) {
                $diskon = $subtotal;
            }


            $totalBayar =
                $subtotal - $diskon;


            /*
            |--------------------------------------------------------------------------
            | GENERATE INVOICE
            |--------------------------------------------------------------------------
            */

            $invoice =
                $this->generateInvoice();


            /*
            |--------------------------------------------------------------------------
            | BUAT TRANSAKSI
            |--------------------------------------------------------------------------
            */

            $transaction = new Transaction();

            $transaction->invoice =
                $invoice;

            $transaction->customer_id =
                $validated['customer_id'];

            $transaction->cashier_id =
                auth()->id();

            $transaction->total_berat =
                $totalBerat;

            $transaction->subtotal =
                $subtotal;

            $transaction->diskon =
                $diskon;

            $transaction->total_bayar =
                $totalBayar;

            $transaction->status_pembayaran =
                'belum_bayar';

            $transaction->status_laundry =
                'menunggu';

            $transaction->tanggal_masuk =
                now();

            $transaction->save();


            /*
            |--------------------------------------------------------------------------
            | BUAT PAYMENT
            |--------------------------------------------------------------------------
            |
            | Payment dibuat sejak transaksi dibuat.
            | Metode belum dipilih sehingga NULL.
            |
            */

            $transaction->payment()->create([

                'metode' => null,

                'jumlah' =>
                    $totalBayar,

                'status' =>
                    'pending',

            ]);


            /*
            |--------------------------------------------------------------------------
            | BUAT DETAIL TRANSAKSI
            |--------------------------------------------------------------------------
            */

            foreach ($details as $detail) {

                $transactionDetail =
                    new TransactionDetail();

                $transactionDetail->transaction_id =
                    $transaction->id;

                $transactionDetail->package_id =
                    $detail['package_id'];

                $transactionDetail->berat =
                    $detail['berat'];

                $transactionDetail->harga =
                    $detail['harga'];

                $transactionDetail->subtotal =
                    $detail['subtotal'];

                $transactionDetail->save();
            }


            /*
            |--------------------------------------------------------------------------
            | RIWAYAT STATUS AWAL
            |--------------------------------------------------------------------------
            */

            $laundryStatus =
                new LaundryStatus();

            $laundryStatus->transaction_id =
                $transaction->id;

            $laundryStatus->status =
                'menunggu';

            $laundryStatus->keterangan =
                'Pesanan dibuat oleh kasir.';

            $laundryStatus->updated_by =
                auth()->id();

            $laundryStatus->save();

        });


        return redirect()
            ->route(
                'kasir.transactions.show',
                $transaction
            )
            ->with(
                'success',
                'Pesanan berhasil dibuat.'
            );
    }


    /**
     * Detail pesanan.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load([

            'customer',

            'cashier',

            'details.package',

            'payment',

            'laundryStatuses.updater',

        ]);


        return view(
            'kasir.transactions.show',
            compact('transaction')
        );
    }


    /**
     * Form edit transaksi.
     */
    public function edit(Transaction $transaction)
    {
        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI SUDAH SELESAI
        |--------------------------------------------------------------------------
        */

        if (
            $transaction->status_laundry === 'selesai'
        ) {

            return redirect()
                ->route(
                    'kasir.transactions.show',
                    $transaction
                )
                ->with(
                    'error',
                    'Pesanan yang sudah selesai tidak dapat diedit.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI SUDAH DIBAYAR
        |--------------------------------------------------------------------------
        |
        | Transaksi yang sudah dibayar tidak boleh
        | diubah nominalnya.
        |
        */

        if (
            $transaction->status_pembayaran === 'dibayar'
        ) {

            return redirect()
                ->route(
                    'kasir.transactions.show',
                    $transaction
                )
                ->with(
                    'error',
                    'Pesanan yang sudah dibayar tidak dapat diedit.'
                );
        }


        $customers = User::where('role', 'pelanggan')
            ->orderBy('name')
            ->get();

        $packages = Package::where('status', 'aktif')
            ->orderBy('nama_paket')
            ->get();


        $transaction->load([
            'details.package',
            'payment',
        ]);


        return view(
            'kasir.transactions.edit',
            compact(
                'transaction',
                'customers',
                'packages'
            )
        );
    }


    /**
     * Update transaksi.
     */
    public function update(
        Request $request,
        Transaction $transaction
    ) {

        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI SUDAH SELESAI
        |--------------------------------------------------------------------------
        */

        if (
            $transaction->status_laundry === 'selesai'
        ) {

            return redirect()
                ->route(
                    'kasir.transactions.show',
                    $transaction
                )
                ->with(
                    'error',
                    'Pesanan yang sudah selesai tidak dapat diedit.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI SUDAH DIBAYAR
        |--------------------------------------------------------------------------
        */

        if (
            $transaction->status_pembayaran === 'dibayar'
        ) {

            return redirect()
                ->route(
                    'kasir.transactions.show',
                    $transaction
                )
                ->with(
                    'error',
                    'Pesanan yang sudah dibayar tidak dapat diedit.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'customer_id' => [
                'required',
                'exists:users,id',
            ],

            'diskon' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'packages' => [
                'required',
                'array',
                'min:1',
            ],

            'packages.*.package_id' => [
                'required',
                'exists:packages,id',
            ],

            'packages.*.berat' => [
                'required',
                'numeric',
                'min:0.1',
            ],

        ]);


        DB::transaction(function () use (
            $validated,
            $transaction
        ) {

            /*
            |--------------------------------------------------------------------------
            | HITUNG ULANG DETAIL
            |--------------------------------------------------------------------------
            */

            $subtotal = 0;
            $totalBerat = 0;
            $details = [];


            foreach ($validated['packages'] as $item) {

                $package = Package::findOrFail(
                    $item['package_id']
                );

                $berat = (float) $item['berat'];

                $harga =
                    (float) $package->harga_per_kg;

                $detailSubtotal =
                    $berat * $harga;


                $subtotal +=
                    $detailSubtotal;

                $totalBerat +=
                    $berat;


                $details[] = [

                    'package_id' =>
                        $package->id,

                    'berat' =>
                        $berat,

                    'harga' =>
                        $harga,

                    'subtotal' =>
                        $detailSubtotal,

                ];
            }


            /*
            |--------------------------------------------------------------------------
            | HITUNG DISKON
            |--------------------------------------------------------------------------
            */

            $diskon =
                (float) (
                    $validated['diskon'] ?? 0
                );


            if ($diskon > $subtotal) {
                $diskon = $subtotal;
            }


            $totalBayar =
                $subtotal - $diskon;


            /*
            |--------------------------------------------------------------------------
            | UPDATE TRANSAKSI
            |--------------------------------------------------------------------------
            */

            $transaction->customer_id =
                $validated['customer_id'];

            $transaction->total_berat =
                $totalBerat;

            $transaction->subtotal =
                $subtotal;

            $transaction->diskon =
                $diskon;

            $transaction->total_bayar =
                $totalBayar;

            $transaction->save();


            /*
            |--------------------------------------------------------------------------
            | UPDATE PAYMENT
            |--------------------------------------------------------------------------
            |
            | Karena transaksi belum dibayar,
            | nominal Payment harus mengikuti
            | total transaksi terbaru.
            |
            */

            $payment = $transaction->payment;


            if ($payment) {

                $payment->update([

                    'jumlah' =>
                        $totalBayar,

                    'metode' =>
                        null,

                    'status' =>
                        'pending',

                    'paid_at' =>
                        null,

                ]);

            } else {

                /*
                |--------------------------------------------------------------------------
                | FALLBACK
                |--------------------------------------------------------------------------
                | Jika karena suatu alasan Payment belum ada,
                | buat Payment baru.
                |
                */

                $transaction->payment()->create([

                    'metode' =>
                        null,

                    'jumlah' =>
                        $totalBayar,

                    'status' =>
                        'pending',

                ]);

            }


            /*
            |--------------------------------------------------------------------------
            | HAPUS DETAIL LAMA
            |--------------------------------------------------------------------------
            */

            $transaction->details()->delete();


            /*
            |--------------------------------------------------------------------------
            | BUAT DETAIL BARU
            |--------------------------------------------------------------------------
            */

            foreach ($details as $detail) {

                $transactionDetail =
                    new TransactionDetail();

                $transactionDetail->transaction_id =
                    $transaction->id;

                $transactionDetail->package_id =
                    $detail['package_id'];

                $transactionDetail->berat =
                    $detail['berat'];

                $transactionDetail->harga =
                    $detail['harga'];

                $transactionDetail->subtotal =
                    $detail['subtotal'];

                $transactionDetail->save();
            }

        });


        return redirect()
            ->route(
                'kasir.transactions.show',
                $transaction
            )
            ->with(
                'success',
                'Pesanan berhasil diperbarui.'
            );
    }


    /**
     * Hapus transaksi.
     */
    public function destroy(Transaction $transaction)
    {
        /*
        |--------------------------------------------------------------------------
        | SUDAH DIBAYAR
        |--------------------------------------------------------------------------
        */

        if (
            $transaction->status_pembayaran === 'dibayar'
        ) {

            return redirect()
                ->route(
                    'kasir.transactions.index'
                )
                ->with(
                    'error',
                    'Transaksi yang sudah dibayar tidak dapat dihapus.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SUDAH DIPROSES
        |--------------------------------------------------------------------------
        */

        if (
            $transaction->status_laundry !== 'menunggu'
        ) {

            return redirect()
                ->route(
                    'kasir.transactions.index'
                )
                ->with(
                    'error',
                    'Pesanan yang sudah diproses tidak dapat dihapus.'
                );
        }


        $transaction->delete();


        return redirect()
            ->route(
                'kasir.transactions.index'
            )
            ->with(
                'success',
                'Pesanan berhasil dihapus.'
            );
    }


    /**
     * Generate invoice.
     */
    private function generateInvoice()
    {
        do {

            $invoice =
                'INV-' .
                now()->format('YmdHis') .
                '-' .
                random_int(100, 999);

        } while (
            Transaction::where(
                'invoice',
                $invoice
            )->exists()
        );


        return $invoice;
    }
}
