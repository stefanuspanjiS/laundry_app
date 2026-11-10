@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto space-y-6">

    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
            Pembayaran Cash
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Konfirmasi pembayaran cash secara manual.
        </p>
    </div>


    @if($errors->any())

        <div class="rounded-xl border border-red-200 bg-red-50 p-4">

            <ul class="text-sm text-red-600 space-y-1">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6 space-y-6">

        {{-- Informasi transaksi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">

            <div class="min-w-0">
                <p class="text-xs text-gray-500">
                    Invoice
                </p>

                <p class="font-semibold text-gray-900 mt-1 break-all">
                    {{ $transaction->invoice }}
                </p>
            </div>

            <div class="min-w-0">
                <p class="text-xs text-gray-500">
                    Pelanggan
                </p>

                <p class="font-semibold text-gray-900 mt-1 break-words">
                    {{ $transaction->customer->name }}
                </p>
            </div>

        </div>


        {{-- Total --}}
        <div class="border-t border-gray-100 pt-5">

            <p class="text-sm text-gray-500">
                Total yang harus dibayar
            </p>

            <p class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1 break-words">
                Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}
            </p>

        </div>


        {{-- Form --}}
        <form
            action="{{ route('admin.transactions.payment.cash.store', $transaction) }}"
            method="POST"
            class="space-y-5"
        >

            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Uang Diterima
                </label>

                <input
                    type="number"
                    name="jumlah"
                    value="{{ old('jumlah') }}"
                    min="{{ $transaction->total_bayar }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-3"
                    placeholder="Masukkan nominal uang"
                >

                @error('jumlah')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Tombol --}}
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-3">

                <a
                    href="{{ route('admin.transactions.show', $transaction) }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center
                           px-4 py-2.5 rounded-xl border border-gray-300
                           text-sm font-medium text-gray-700
                           hover:bg-gray-50"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="w-full sm:w-auto rounded-lg bg-green-600 px-5 py-3
                           font-semibold text-white hover:bg-green-700
                           text-center"
                >
                    Konfirmasi Pembayaran
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
