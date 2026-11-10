@extends('layouts.kasir')

@section('title', 'Update Status')

@section('content')

<div class="mx-auto max-w-2xl space-y-6">

    <div>

        <a
            href="{{ route('kasir.transactions.show', $transaction) }}"
            class="text-sm font-medium text-gray-500 hover:text-gray-900"
        >
            ← Kembali ke Detail
        </a>

        <h1 class="mt-3 text-2xl font-bold text-gray-900">
            Update Status Laundry
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            {{ $transaction->invoice }}
        </p>

    </div>


    <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">

        <form
            method="POST"
            action="{{ route('kasir.transactions.status.update', $transaction) }}"
            class="space-y-5"
        >

            @csrf
            @method('PUT')


            {{-- STATUS --}}
            <div>

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Status Laundry
                </label>

                <select
                    name="status"
                    required
                    class="w-full rounded-lg border border-gray-300
                           px-3 py-2.5 text-sm
                           focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                >

                    <option value="menunggu"
                        @selected($transaction->status_laundry === 'menunggu')
                    >
                        Menunggu
                    </option>

                    <option value="dicuci"
                        @selected($transaction->status_laundry === 'dicuci')
                    >
                        Dicuci
                    </option>

                    <option value="dikeringkan"
                        @selected($transaction->status_laundry === 'dikeringkan')
                    >
                        Dikeringkan
                    </option>

                    <option value="disetrika"
                        @selected($transaction->status_laundry === 'disetrika')
                    >
                        Disetrika
                    </option>

                    <option value="siap_diambil"
                        @selected($transaction->status_laundry === 'siap_diambil')
                    >
                        Siap Diambil
                    </option>

                    <option value="selesai"
                        @selected($transaction->status_laundry === 'selesai')
                    >
                        Selesai
                    </option>

                </select>

            </div>


            {{-- KETERANGAN --}}
            <div>

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Keterangan
                </label>

                <textarea
                    name="keterangan"
                    rows="4"
                    maxlength="500"
                    placeholder="Contoh: Laundry sudah selesai dan siap diambil pelanggan."
                    class="w-full rounded-lg border border-gray-300
                           px-3 py-2.5 text-sm
                           focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                >{{ old('keterangan') }}</textarea>

                <p class="mt-1 text-xs text-gray-400">
                    Maksimal 500 karakter.
                </p>

            </div>


            {{-- WARNING --}}
            <div class="rounded-lg bg-gray-50 p-4">

                <p class="text-sm font-medium text-gray-700">
                    Status saat ini:
                    <span class="font-bold">
                        {{ ucfirst(str_replace('_', ' ', $transaction->status_laundry)) }}
                    </span>
                </p>

                <p class="mt-1 text-xs text-gray-500">
                    Setiap perubahan status akan disimpan sebagai riwayat laundry.
                </p>

            </div>


            {{-- BUTTON --}}
            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('kasir.transactions.show', $transaction) }}"
                    class="rounded-lg border border-gray-300 bg-white
                           px-5 py-2.5 text-sm font-semibold text-gray-700
                           hover:bg-gray-50"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-gray-900 px-5 py-2.5
                           text-sm font-semibold text-white
                           hover:bg-gray-800"
                >
                    Simpan Status
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
