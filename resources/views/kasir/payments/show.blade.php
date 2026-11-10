@extends('layouts.kasir')

@section('content')

@php

    $transaction = $payment->transaction;

    $statusClass = match ($payment->status) {
        'success' => 'bg-emerald-100 text-emerald-700',
        'pending' => 'bg-amber-100 text-amber-700',
        'failed' => 'bg-red-100 text-red-700',
        'expire' => 'bg-gray-100 text-gray-700',
        default => 'bg-gray-100 text-gray-700',
    };

    $statusLabel = match ($payment->status) {
        'success' => 'Berhasil',
        'pending' => 'Pending',
        'failed' => 'Gagal',
        'expire' => 'Expired',
        default => ucfirst($payment->status),
    };

@endphp


<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>

            <a
                href="{{ route('kasir.payments.index') }}"
                class="text-sm font-medium text-gray-500 hover:text-gray-900"
            >
                ← Kembali ke Pembayaran
            </a>

            <h1 class="mt-3 text-2xl font-bold text-gray-900">
                Detail Pembayaran
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                {{ $transaction->invoice }}
            </p>

        </div>


        <span class="inline-flex rounded-full px-4 py-2 text-sm font-semibold {{ $statusClass }}">
            {{ $statusLabel }}
        </span>

    </div>


    {{-- SUCCESS --}}
    @if (session('success'))

        <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- ERROR --}}
    @if ($errors->any())

        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

            <ul class="list-inside list-disc">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


        {{-- INFORMASI PEMBAYARAN --}}
        <div class="lg:col-span-2 rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 px-6 py-4">

                <h2 class="font-semibold text-gray-900">
                    Informasi Pembayaran
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

                <div>

                    <p class="text-sm text-gray-500">
                        Invoice
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $transaction->invoice }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Pelanggan
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $transaction->customer->name }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Total Tagihan
                    </p>

                    <p class="mt-1 text-lg font-bold text-gray-900">
                        Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Metode Pembayaran
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">

                        @if ($payment->metode)
                            {{ strtoupper($payment->metode) }}
                        @else
                            Belum dipilih
                        @endif

                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Status
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">
                        {{ $statusLabel }}
                    </p>

                </div>


                <div>

                    <p class="text-sm text-gray-500">
                        Waktu Pembayaran
                    </p>

                    <p class="mt-1 font-semibold text-gray-900">

                        @if ($payment->paid_at)
                            {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, H:i') }}
                        @else
                            -
                        @endif

                    </p>

                </div>

            </div>

        </div>


        {{-- AKSI --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

            <h2 class="font-semibold text-gray-900">
                Aksi
            </h2>


            <div class="mt-5 space-y-3">

                @if ($payment->status !== 'success')

                    <a
                        href="{{ route('kasir.payments.cash', $payment) }}"
                        class="block w-full rounded-lg bg-gray-900 px-4 py-3 text-center text-sm font-semibold text-white hover:bg-gray-800"
                    >
                        Bayar Cash
                    </a>

                @else

                    <div class="rounded-lg bg-emerald-50 px-4 py-3 text-center text-sm font-semibold text-emerald-700">
                        Pembayaran sudah berhasil
                    </div>

                @endif


                <a
                    href="{{ route('kasir.transactions.show', $transaction) }}"
                    class="block w-full rounded-lg border border-gray-300 px-4 py-3 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50"
                >
                    Lihat Pesanan
                </a>

            </div>

        </div>

    </div>


    {{-- DETAIL PESANAN --}}
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 px-6 py-4">

            <h2 class="font-semibold text-gray-900">
                Detail Pesanan
            </h2>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 font-semibold text-gray-700">
                            Paket
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700">
                            Berat
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700">
                            Harga / Kg
                        </th>

                        <th class="px-6 py-4 text-right font-semibold text-gray-700">
                            Subtotal
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @foreach ($transaction->details as $detail)

                        <tr>

                            <td class="px-6 py-4">
                                {{ $detail->package->nama_paket }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $detail->berat }} kg
                            </td>

                            <td class="px-6 py-4">
                                Rp {{ number_format($detail->harga, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-right font-semibold">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        <div class="border-t border-gray-200 p-6">

            <div class="ml-auto max-w-sm space-y-3">

                <div class="flex justify-between text-sm">

                    <span class="text-gray-500">
                        Subtotal
                    </span>

                    <span class="font-medium">
                        Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}
                    </span>

                </div>


                <div class="flex justify-between text-sm">

                    <span class="text-gray-500">
                        Diskon
                    </span>

                    <span class="font-medium">
                        Rp {{ number_format($transaction->diskon, 0, ',', '.') }}
                    </span>

                </div>


                <div class="flex justify-between border-t border-gray-200 pt-3">

                    <span class="font-semibold">
                        Total Bayar
                    </span>

                    <span class="text-lg font-bold">
                        Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
