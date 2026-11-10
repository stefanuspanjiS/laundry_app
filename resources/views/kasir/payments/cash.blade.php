@extends('layouts.kasir')

@section('content')

@php
    $transaction = $payment->transaction;
@endphp


<div class="mx-auto max-w-3xl space-y-6">

    {{-- HEADER --}}
    <div>

        <a
            href="{{ route('kasir.payments.show', $payment) }}"
            class="text-sm font-medium text-gray-500 hover:text-gray-900"
        >
            ← Kembali
        </a>

        <h1 class="mt-3 text-2xl font-bold text-gray-900">
            Pembayaran Cash
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Proses pembayaran tunai untuk {{ $transaction->invoice }}.
        </p>

    </div>


    {{-- TAGIHAN --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

        <p class="text-sm text-gray-500">
            Total Tagihan
        </p>

        <p class="mt-2 text-3xl font-bold text-gray-900">
            Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}
        </p>

        <div class="mt-4 grid grid-cols-2 gap-4 border-t border-gray-100 pt-4">

            <div>

                <p class="text-xs text-gray-500">
                    Invoice
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    {{ $transaction->invoice }}
                </p>

            </div>


            <div>

                <p class="text-xs text-gray-500">
                    Pelanggan
                </p>

                <p class="mt-1 font-semibold text-gray-900">
                    {{ $transaction->customer->name }}
                </p>

            </div>

        </div>

    </div>


    {{-- FORM --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

        <form
            method="POST"
            action="{{ route('kasir.payments.cash.store', $payment) }}"
            id="cashPaymentForm"
        >

            @csrf


            <div>

                <label
                    for="jumlah_bayar"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Jumlah Uang Diterima
                </label>

                <div class="relative">

                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                        Rp
                    </span>

                    <input
                        type="number"
                        name="jumlah_bayar"
                        id="jumlah_bayar"
                        min="{{ $transaction->total_bayar }}"
                        step="1000"
                        value="{{ old('jumlah_bayar') }}"
                        placeholder="Masukkan jumlah uang..."
                        class="w-full rounded-lg border border-gray-300 py-3 pl-12 pr-4 text-lg font-semibold focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
                        required
                    >

                </div>

                @error('jumlah_bayar')

                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- KEMBALIAN --}}
            <div class="mt-5 rounded-lg bg-gray-50 p-5">

                <div class="flex items-center justify-between">

                    <span class="text-sm font-medium text-gray-600">
                        Kembalian
                    </span>

                    <span
                        id="kembalian"
                        class="text-xl font-bold text-gray-900"
                    >
                        Rp 0
                    </span>

                </div>

            </div>


            {{-- BUTTON --}}
            <div class="mt-6 flex justify-end gap-3">

                <a
                    href="{{ route('kasir.payments.show', $payment) }}"
                    class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-gray-900 px-6 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
                >
                    Konfirmasi Pembayaran
                </button>

            </div>

        </form>

    </div>

</div>


<script>

    const inputBayar = document.getElementById('jumlah_bayar');
    const outputKembalian = document.getElementById('kembalian');

    const totalTagihan = {{ (float) $transaction->total_bayar }};

    function formatRupiah(number) {

        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(number);

    }

    function updateKembalian() {

        const jumlahBayar = parseFloat(inputBayar.value) || 0;

        const kembalian = jumlahBayar - totalTagihan;

        if (kembalian >= 0) {

            outputKembalian.textContent = formatRupiah(kembalian);

        } else {

            outputKembalian.textContent = 'Rp 0';

        }

    }

    inputBayar.addEventListener('input', updateKembalian);

</script>

@endsection
