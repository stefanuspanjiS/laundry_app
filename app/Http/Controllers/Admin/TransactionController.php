<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Models\LaundryStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\ValidationException;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * Daftar transaksi
     */
    public function index(Request $request)
    {
        $query = Transaction::with([
            'customer',
            'cashier',
            'details.package',
            'payment',
        ]);

        // Search invoice / pelanggan
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
        if ($request->filled('status_laundry')) {
            $query->where(
                'status_laundry',
                $request->status_laundry
            );
        }

        // Filter status pembayaran
        if ($request->filled('status_pembayaran')) {
            $query->where(
                'status_pembayaran',
                $request->status_pembayaran
            );
        }

        $transactions = $query
            ->latest('tanggal_masuk')
            ->latest('id')
            ->get();

        return view(
            'admin.transactions.index',
            compact('transactions')
        );
    }

    /**
     * Form tambah transaksi
     */
    public function create()
    {
        $customers = User::where(
            'role',
            User::ROLE_PELANGGAN
        )
            ->orderBy('name')
            ->get();

        $cashiers = User::where(
            'role',
            User::ROLE_KASIR
        )
            ->orderBy('name')
            ->get();

        // HANYA paket aktif
        $packages = Package::where('status', true)
            ->orderBy('nama_paket')
            ->get();

        return view(
            'admin.transactions.create',
            compact(
                'customers',
                'cashiers',
                'packages'
            )
        );
    }

    /**
     * Simpan transaksi baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'customer_id' => [
                    'required',
                    Rule::exists('users', 'id')
                        ->where(function ($query) {
                            $query->where(
                                'role',
                                User::ROLE_PELANGGAN
                            );
                        }),
                ],

                'cashier_id' => [
                    'required',
                    Rule::exists('users', 'id')
                        ->where(function ($query) {
                            $query->where(
                                'role',
                                User::ROLE_KASIR
                            );
                        }),
                ],

                'tanggal_masuk' => [
                    'required',
                    'date',
                ],

                'tanggal_selesai' => [
                    'nullable',
                    'date',
                    'after_or_equal:tanggal_masuk',
                ],

                'diskon' => [
                    'nullable',
                    'numeric',
                    'min:0',
                ],

                'status_pembayaran' => [
                    'required',
                    Rule::in([
                        'belum_bayar',
                        'dibayar',
                    ]),
                ],

                'metode_pembayaran' => [
                    'nullable',
                    Rule::in([
                        'cash',
                        'midtrans',
                    ]),
                ],

                'details' => [
                    'required',
                    'array',
                    'min:1',
                ],

                'details.*.package_id' => [
                    'required',

                    // HANYA paket aktif
                    Rule::exists('packages', 'id')
                        ->where(function ($query) {
                            $query->where('status', true);
                        }),
                ],

                'details.*.berat' => [
                    'required',
                    'numeric',
                    'min:0.1',
                ],
            ],
            [
                'customer_id.required' =>
                    'Pelanggan wajib dipilih.',

                'customer_id.exists' =>
                    'Pelanggan tidak valid.',

                'cashier_id.required' =>
                    'Kasir wajib dipilih.',

                'cashier_id.exists' =>
                    'Kasir tidak valid.',

                'tanggal_masuk.required' =>
                    'Tanggal masuk wajib diisi.',

                'tanggal_selesai.after_or_equal' =>
                    'Tanggal selesai tidak boleh sebelum tanggal masuk.',

                'details.required' =>
                    'Minimal harus ada satu paket.',

                'details.min' =>
                    'Minimal harus ada satu paket.',

                'details.*.package_id.required' =>
                    'Paket wajib dipilih.',

                'details.*.package_id.exists' =>
                    'Paket yang dipilih tidak tersedia atau sudah tidak aktif.',

                'details.*.berat.required' =>
                    'Berat laundry wajib diisi.',

                'details.*.berat.numeric' =>
                    'Berat harus berupa angka.',

                'details.*.berat.min' =>
                    'Berat minimal 0.1 kg.',
            ]
        );

        return DB::transaction(function () use ($validated) {

            $subtotal = 0;
            $totalBerat = 0;

            /*
             * Ambil semua package dari database.
             * Jangan percaya harga dari browser.
             */
            $packageIds = collect($validated['details'])
                ->pluck('package_id')
                ->unique();

            $packages = Package::whereIn('id', $packageIds)
                ->where('status', true)
                ->get()
                ->keyBy('id');

            /*
             * Pastikan semua package masih aktif.
             */
            if ($packages->count() !== $packageIds->count()) {
                throw ValidationException::withMessages([
                    'details' =>
                        'Salah satu paket sudah tidak aktif. Silakan muat ulang halaman.',
                ]);
            }

            foreach ($validated['details'] as $detail) {

                $package = $packages->get(
                    $detail['package_id']
                );

                $berat = (float) $detail['berat'];
                $harga = (float) $package->harga_per_kg;

                $detailSubtotal = $berat * $harga;

                $subtotal += $detailSubtotal;
                $totalBerat += $berat;
            }

            $diskon = (float) (
                $validated['diskon'] ?? 0
            );

            // Diskon tidak boleh lebih besar dari subtotal
            if ($diskon > $subtotal) {
                throw ValidationException::withMessages([
                    'diskon' =>
                        'Diskon tidak boleh lebih besar dari subtotal.',
                ]);
            }

            $totalBayar = $subtotal - $diskon;

            /*
             * Generate invoice
             */
            $invoice = $this->generateInvoice();

            $transaction = Transaction::create([
                'invoice' => $invoice,
                'customer_id' => $validated['customer_id'],
                'cashier_id' => $validated['cashier_id'],
                'total_berat' => $totalBerat,
                'subtotal' => $subtotal,
                'diskon' => $diskon,
                'total_bayar' => $totalBayar,
                'status_pembayaran' =>
                    $validated['status_pembayaran'],

                // Status awal transaksi
                'status_laundry' => 'menunggu',

                'tanggal_masuk' =>
                    $validated['tanggal_masuk'],

                'tanggal_selesai' =>
                    $validated['tanggal_selesai'] ?? null,
            ]);

            /*
             * Simpan history status awal.
             */
            LaundryStatus::create([
                'transaction_id' => $transaction->id,
                'status' => 'menunggu',
                'keterangan' => 'Transaksi laundry dibuat.',
                'updated_by' => auth()->id(),
            ]);

            /*
             * Simpan detail transaksi
             */
            foreach ($validated['details'] as $detail) {

                $package = $packages->get(
                    $detail['package_id']
                );

                $berat = (float) $detail['berat'];
                $harga = (float) $package->harga_per_kg;

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'package_id' => $package->id,
                    'berat' => $berat,
                    'harga' => $harga,
                    'subtotal' => $berat * $harga,
                ]);
            }

            /*
             * Buat payment jika transaksi langsung dibayar
             */
            Payment::create([
                'transaction_id' => $transaction->id,
                'metode' => $validated['metode_pembayaran'] ?? 'cash',
                'jumlah' => $totalBayar,
                'status' => $validated['status_pembayaran'] === 'dibayar'
                    ? 'success'
                    : 'pending',
                'paid_at' => $validated['status_pembayaran'] === 'dibayar'
                    ? now()
                    : null,
            ]);

            return redirect()
                ->route(
                    'admin.transactions.show',
                    $transaction
                )
                ->with(
                    'success',
                    'Transaksi berhasil dibuat.'
                );
        });
    }

    /**
     * Detail transaksi
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
            'admin.transactions.show',
            compact('transaction')
        );
    }

    /**
     * Form edit transaksi
     *
     * Status laundry TIDAK diedit di sini.
     * Gunakan halaman Update Status.
     */
    public function edit(Transaction $transaction)
    {
        $transaction->load([
            'details.package',
            'payment',
        ]);

        $customers = User::where(
            'role',
            User::ROLE_PELANGGAN
        )
            ->orderBy('name')
            ->get();

        $cashiers = User::where(
            'role',
            User::ROLE_KASIR
        )
            ->orderBy('name')
            ->get();

        /*
         * Paket aktif + paket yang sudah digunakan
         * dalam transaksi ini.
         *
         * Jadi histori tetap bisa diedit.
         */
        $usedPackageIds = $transaction->details
            ->pluck('package_id');

        $packages = Package::where(function ($query) use (
            $usedPackageIds
        ) {
            $query->where('status', true)
                ->orWhereIn('id', $usedPackageIds);
        })
            ->orderBy('nama_paket')
            ->get();

        return view(
            'admin.transactions.edit',
            compact(
                'transaction',
                'customers',
                'cashiers',
                'packages'
            )
        );
    }

    /**
     * Update transaksi
     *
     * Status laundry tidak diubah di sini.
     * Perubahan status dilakukan melalui
     * LaundryStatusController agar masuk history.
     */
    public function update(
        Request $request,
        Transaction $transaction
    ) {
        $validated = $request->validate(
            [
                'customer_id' => [
                    'required',
                    Rule::exists('users', 'id')
                        ->where(function ($query) {
                            $query->where(
                                'role',
                                User::ROLE_PELANGGAN
                            );
                        }),
                ],

                'cashier_id' => [
                    'required',
                    Rule::exists('users', 'id')
                        ->where(function ($query) {
                            $query->where(
                                'role',
                                User::ROLE_KASIR
                            );
                        }),
                ],

                'tanggal_masuk' => [
                    'required',
                    'date',
                ],

                'tanggal_selesai' => [
                    'nullable',
                    'date',
                    'after_or_equal:tanggal_masuk',
                ],

                'diskon' => [
                    'nullable',
                    'numeric',
                    'min:0',
                ],

                'details' => [
                    'required',
                    'array',
                    'min:1',
                ],

                'details.*.package_id' => [
                    'required',
                    'exists:packages,id',
                ],

                'details.*.berat' => [
                    'required',
                    'numeric',
                    'min:0.1',
                ],
            ],
            [
                'customer_id.required' =>
                    'Pelanggan wajib dipilih.',

                'cashier_id.required' =>
                    'Kasir wajib dipilih.',

                'details.required' =>
                    'Minimal harus ada satu paket.',

                'details.min' =>
                    'Minimal harus ada satu paket.',

                'details.*.package_id.required' =>
                    'Paket wajib dipilih.',

                'details.*.package_id.exists' =>
                    'Paket tidak ditemukan.',

                'details.*.berat.required' =>
                    'Berat laundry wajib diisi.',

                'details.*.berat.min' =>
                    'Berat minimal 0.1 kg.',
            ]
        );

        return DB::transaction(function () use (
            $validated,
            $transaction
        ) {

            $subtotal = 0;
            $totalBerat = 0;

            $packageIds = collect($validated['details'])
                ->pluck('package_id')
                ->unique();

            $packages = Package::whereIn('id', $packageIds)
                ->get()
                ->keyBy('id');

            foreach ($validated['details'] as $detail) {

                $package = $packages->get(
                    $detail['package_id']
                );

                /*
                 * Paket baru harus aktif.
                 *
                 * Paket tidak aktif hanya boleh tetap
                 * digunakan apabila memang sudah ada
                 * pada transaksi lama.
                 */
                $existingPackageIds = $transaction
                    ->details
                    ->pluck('package_id');

                if (
                    !$package->status &&
                    !$existingPackageIds->contains(
                        $package->id
                    )
                ) {
                    throw ValidationException::withMessages([
                        'details' =>
                            'Paket yang dipilih sudah tidak aktif.',
                    ]);
                }

                $berat = (float) $detail['berat'];
                $harga = (float) $package->harga_per_kg;

                $subtotal += $berat * $harga;
                $totalBerat += $berat;
            }

            $diskon = (float) (
                $validated['diskon'] ?? 0
            );

            if ($diskon > $subtotal) {
                throw ValidationException::withMessages([
                    'diskon' =>
                        'Diskon tidak boleh lebih besar dari subtotal.',
                ]);
            }

            $totalBayar = $subtotal - $diskon;

            /*
             * Update data transaksi.
             *
             * PERHATIKAN:
             * status_laundry TIDAK diubah di sini.
             */
            $transaction->update([
                'customer_id' =>
                    $validated['customer_id'],

                'cashier_id' =>
                    $validated['cashier_id'],

                'total_berat' =>
                    $totalBerat,

                'subtotal' =>
                    $subtotal,

                'diskon' =>
                    $diskon,

                'total_bayar' =>
                    $totalBayar,

                'tanggal_masuk' =>
                    $validated['tanggal_masuk'],

                'tanggal_selesai' =>
                    $validated['tanggal_selesai'] ?? null,
            ]);

            /*
             * Hapus detail lama lalu buat ulang.
             */
            $transaction->details()->delete();

            foreach ($validated['details'] as $detail) {

                $package = $packages->get(
                    $detail['package_id']
                );

                $berat = (float) $detail['berat'];
                $harga = (float) $package->harga_per_kg;

                TransactionDetail::create([
                    'transaction_id' =>
                        $transaction->id,

                    'package_id' =>
                        $package->id,

                    'berat' =>
                        $berat,

                    'harga' =>
                        $harga,

                    'subtotal' =>
                        $berat * $harga,
                ]);
            }

            /*
             * Jika payment sudah success,
             * update jumlahnya mengikuti total transaksi.
             */
            if (
                $transaction->status_pembayaran
                === 'dibayar'
            ) {
                $payment = $transaction->payment;

                if ($payment) {
                    $payment->update([
                        'jumlah' => $totalBayar,
                    ]);
                }
            }

            return redirect()
                ->route(
                    'admin.transactions.show',
                    $transaction
                )
                ->with(
                    'success',
                    'Transaksi berhasil diperbarui.'
                );
        });
    }

    /**
     * Hapus transaksi
     */
    public function destroy(Transaction $transaction)
    {
        /*
         * Transaksi yang sudah dibayar jangan
         * dihapus sembarangan karena berkaitan
         * dengan data keuangan.
         */
        if (
            $transaction->status_pembayaran
            === 'dibayar'
        ) {
            return back()->with(
                'error',
                'Transaksi yang sudah dibayar tidak dapat dihapus.'
            );
        }

        DB::transaction(function () use (
            $transaction
        ) {
            $transaction->details()->delete();
            $transaction->payment()->delete();
            $transaction->laundryStatuses()->delete();

            $transaction->delete();
        });

        return redirect()
            ->route('admin.transactions.index')
            ->with(
                'success',
                'Transaksi berhasil dihapus.'
            );
    }

    /**
     * Generate nomor invoice
     */
    private function generateInvoice(): string
    {
        do {
            $invoice =
                'INV-' .
                now()->format('Ymd') .
                '-' .
                strtoupper(
                    substr(
                        uniqid(),
                        -6
                    )
                );
        } while (
            Transaction::where(
                'invoice',
                $invoice
            )->exists()
        );

        return $invoice;
    }
}
