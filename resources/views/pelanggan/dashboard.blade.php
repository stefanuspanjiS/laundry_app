@extends('layouts.pelanggan')

@section('content')

<div class="w-full min-w-0 space-y-6">

    {{-- Header --}}
    <div class="min-w-0">
        <h1 class="text-xl font-bold text-gray-800 sm:text-2xl">
            Selamat Datang, {{ auth()->user()->name }}!
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Kelola dan pantau pesanan laundry kamu dengan mudah.
        </p>
    </div>


    {{-- Statistik --}}
    <div class="grid min-w-0 grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 sm:gap-6">

        {{-- Pesanan Aktif --}}
        <div class="min-w-0 rounded-xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5">
            <p class="text-sm text-gray-500">
                Pesanan Aktif
            </p>

            <p class="mt-2 text-2xl font-bold text-gray-800 sm:text-3xl">
                {{ $pesananAktif }}
            </p>

            <p class="mt-1 text-xs text-gray-400">
                Pesanan belum selesai
            </p>
        </div>


        {{-- Menunggu Pembayaran --}}
        <div class="min-w-0 rounded-xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5">
            <p class="text-sm text-gray-500">
                Menunggu Pembayaran
            </p>

            <p class="mt-2 text-2xl font-bold text-gray-800 sm:text-3xl">
                {{ $menungguPembayaran }}
            </p>

            <p class="mt-1 text-xs text-gray-400">
                Pesanan belum dibayar
            </p>
        </div>


        {{-- Sedang Diproses --}}
        <div class="min-w-0 rounded-xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5">
            <p class="text-sm text-gray-500">
                Sedang Diproses
            </p>

            <p class="mt-2 text-2xl font-bold text-gray-800 sm:text-3xl">
                {{ $sedangDiproses }}
            </p>

            <p class="mt-1 text-xs text-gray-400">
                Sedang dikerjakan
            </p>
        </div>


        {{-- Pesanan Selesai --}}
        <div class="min-w-0 rounded-xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5">
            <p class="text-sm text-gray-500">
                Pesanan Selesai
            </p>

            <p class="mt-2 text-2xl font-bold text-gray-800 sm:text-3xl">
                {{ $pesananSelesai }}
            </p>

            <p class="mt-1 text-xs text-gray-400">
                Sudah selesai
            </p>
        </div>

    </div>


    {{-- Pesanan Terbaru --}}
    <div class="min-w-0 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">

        <div class="flex min-w-0 flex-col gap-3 border-b border-gray-100 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">

            <div class="min-w-0">
                <h2 class="text-lg font-semibold text-gray-800">
                    Pesanan Terbaru
                </h2>

                <p class="text-sm text-gray-500">
                    Pesanan laundry terbaru kamu.
                </p>
            </div>

            <a
                href="{{ route('pelanggan.orders.index') }}"
                class="shrink-0 text-sm font-medium text-blue-600 hover:text-blue-700"
            >
                Lihat Semua
            </a>

        </div>


        @if($pesananTerbaru->count() > 0)

            {{-- =========================================================
                 MOBILE
                 ========================================================= --}}
            <div class="block divide-y divide-gray-100 sm:hidden">

                @foreach($pesananTerbaru as $transaction)

                    <div class="space-y-4 p-4">

                        {{-- Invoice + Status --}}
                        <div class="flex min-w-0 items-start justify-between gap-3">

                            <div class="min-w-0">
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                    Invoice
                                </p>

                                <a
                                    href="{{ route('pelanggan.orders.show', $transaction) }}"
                                    class="mt-1 block break-all text-sm font-semibold text-blue-600 hover:text-blue-700 hover:underline"
                                >
                                    {{ $transaction->invoice }}
                                </a>
                            </div>

                            @php
                                $statusLabel = [
                                    'menunggu' => 'Menunggu',
                                    'dicuci' => 'Dicuci',
                                    'dikeringkan' => 'Dikeringkan',
                                    'disetrika' => 'Disetrika',
                                    'siap_diambil' => 'Siap Diambil',
                                    'selesai' => 'Selesai',
                                ];

                                $statusClass = [
                                    'menunggu' => 'bg-gray-100 text-gray-700',
                                    'dicuci' => 'bg-blue-100 text-blue-700',
                                    'dikeringkan' => 'bg-cyan-100 text-cyan-700',
                                    'disetrika' => 'bg-yellow-100 text-yellow-700',
                                    'siap_diambil' => 'bg-green-100 text-green-700',
                                    'selesai' => 'bg-emerald-100 text-emerald-700',
                                ];
                            @endphp

                            <span class="inline-flex max-w-[45%] shrink-0 whitespace-nowrap rounded-full px-3 py-1 text-xs font-medium {{ $statusClass[$transaction->status_laundry] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $statusLabel[$transaction->status_laundry] ?? $transaction->status_laundry }}
                            </span>

                        </div>


                        {{-- Detail --}}
                        <div class="grid grid-cols-2 gap-3">

                            <div>
                                <p class="text-xs text-gray-400">
                                    Tanggal
                                </p>

                                <p class="mt-1 text-sm text-gray-700">
                                    {{ $transaction->tanggal_masuk?->format('d/m/Y') ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-400">
                                    Berat
                                </p>

                                <p class="mt-1 text-sm text-gray-700">
                                    {{ number_format($transaction->total_berat, 2, ',', '.') }} kg
                                </p>
                            </div>

                            <div class="col-span-2">
                                <p class="text-xs text-gray-400">
                                    Total
                                </p>

                                <p class="mt-1 text-sm font-semibold text-gray-800">
                                    Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}
                                </p>
                            </div>

                        </div>


                        {{-- Detail Button --}}
                        <a
                            href="{{ route('pelanggan.orders.show', $transaction) }}"
                            class="inline-flex w-full items-center justify-center rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Lihat Detail
                        </a>

                    </div>

                @endforeach

            </div>


            {{-- =========================================================
                 TABLET / DESKTOP
                 ========================================================= --}}
            <div class="hidden overflow-x-auto sm:block">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 sm:px-6">
                                Invoice
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 sm:px-6">
                                Tanggal
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 sm:px-6">
                                Berat
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 sm:px-6">
                                Total
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 sm:px-6">
                                Status
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 sm:px-6">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($pesananTerbaru as $transaction)

                            <tr class="hover:bg-gray-50">

                                <td class="whitespace-nowrap px-4 py-3 text-sm font-medium sm:px-6 sm:py-4">
                                    <a
                                        href="{{ route('pelanggan.orders.show', $transaction) }}"
                                        class="text-blue-600 hover:text-blue-700 hover:underline"
                                    >
                                        {{ $transaction->invoice }}
                                    </a>
                                </td>

                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600 sm:px-6 sm:py-4">
                                    {{ $transaction->tanggal_masuk?->format('d/m/Y') ?? '-' }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600 sm:px-6 sm:py-4">
                                    {{ number_format($transaction->total_berat, 2, ',', '.') }} kg
                                </td>

                                <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-800 sm:px-6 sm:py-4">
                                    Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-3 sm:px-6 sm:py-4">

                                    <span class="inline-flex whitespace-nowrap rounded-full px-3 py-1 text-xs font-medium {{ $statusClass[$transaction->status_laundry] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $statusLabel[$transaction->status_laundry] ?? $transaction->status_laundry }}
                                    </span>

                                </td>

                                <td class="whitespace-nowrap px-4 py-3 sm:px-6 sm:py-4">

                                    <a
                                        href="{{ route('pelanggan.orders.show', $transaction) }}"
                                        class="inline-flex items-center rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50"
                                    >
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="p-6 text-center sm:p-8">

                <p class="text-sm text-gray-500">
                    Belum ada pesanan laundry.
                </p>

                <a
                    href="{{ route('pelanggan.orders.create') }}"
                    class="mt-4 inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700"
                >
                    Buat Pesanan
                </a>

            </div>

        @endif

    </div>

</div>

@endsection
