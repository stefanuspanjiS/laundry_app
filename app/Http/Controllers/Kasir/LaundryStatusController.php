<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\LaundryStatus;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaundryStatusController extends Controller
{
    public function edit(Transaction $transaction)
    {
        return view(
            'kasir.transactions.status',
            compact('transaction')
        );
    }


    public function update(
        Request $request,
        Transaction $transaction
    ) {

        $validated = $request->validate([

            'status' => [
                'required',
                'in:menunggu,dicuci,dikeringkan,disetrika,siap_diambil,selesai',
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:500',
            ],

        ]);


        DB::transaction(function () use (
            $validated,
            $transaction
        ) {

            /*
            |--------------------------------------------------------------------------
            | UPDATE STATUS TRANSAKSI
            |--------------------------------------------------------------------------
            */

            $transaction->status_laundry =
                $validated['status'];


            if ($validated['status'] === 'selesai') {

                $transaction->tanggal_selesai =
                    now();

            } else {

                $transaction->tanggal_selesai =
                    null;
            }


            $transaction->save();


            /*
            |--------------------------------------------------------------------------
            | SIMPAN HISTORY
            |--------------------------------------------------------------------------
            */

            $status =
                new LaundryStatus();

            $status->transaction_id =
                $transaction->id;

            $status->status =
                $validated['status'];

            $status->keterangan =
                $validated['keterangan'] ?? null;

            $status->updated_by =
                auth()->id();

            $status->save();

        });


        return redirect()
            ->route(
                'kasir.transactions.show',
                $transaction
            )
            ->with(
                'success',
                'Status laundry berhasil diperbarui.'
            );
    }
}
