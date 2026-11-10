<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaundryStatus;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LaundryStatusController extends Controller
{
    /**
     * Menampilkan form update status.
     */
    public function edit(Transaction $transaction)
    {
        $transaction->load([
            'customer',
            'laundryStatuses.updater',
        ]);

        $statuses = [
            'menunggu' => 'Menunggu',
            'dicuci' => 'Dicuci',
            'dikeringkan' => 'Dikeringkan',
            'disetrika' => 'Disetrika',
            'siap_diambil' => 'Siap Diambil',
            'selesai' => 'Selesai',
        ];

        return view(
            'admin.transactions.status',
            compact(
                'transaction',
                'statuses'
            )
        );
    }

    /**
     * Menyimpan perubahan status.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'menunggu',
                    'dicuci',
                    'dikeringkan',
                    'disetrika',
                    'siap_diambil',
                    'selesai',
                ]),
            ],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ], [
            'status.required' => 'Status laundry wajib dipilih.',
            'status.in' => 'Status laundry tidak valid.',
            'keterangan.max' => 'Keterangan maksimal 1000 karakter.',
        ]);

        return DB::transaction(function () use ($validated, $transaction) {

            $statusBaru = $validated['status'];
            $statusLama = $transaction->status_laundry;

            if ($statusBaru === $statusLama) {
                return back()->with(
                    'error',
                    'Status laundry belum berubah.'
                );
            }

            $transaction->update([
                'status_laundry' => $statusBaru,
                'tanggal_selesai' => $statusBaru === 'selesai'
                    ? now()->toDateString()
                    : $transaction->tanggal_selesai,
            ]);

            LaundryStatus::create([
                'transaction_id' => $transaction->id,
                'status' => $statusBaru,
                'keterangan' => $validated['keterangan'] ?? null,
                'updated_by' => auth()->id(),
            ]);

            return redirect()
                ->route('admin.transactions.show', $transaction)
                ->with(
                    'success',
                    'Status laundry berhasil diperbarui.'
                );
        });
    }
}
