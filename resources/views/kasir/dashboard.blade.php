@extends('layouts.kasir')

@section('title', 'Dashboard')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Dashboard Kasir
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Selamat datang, {{ auth()->user()->name }}.
            Kelola transaksi dan proses laundry dari sini.
        </p>
    </div>


    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Pelanggan --}}
        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Total Pelanggan
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $totalPelanggan }}
                    </p>
                </div>

                <div class="rounded-lg bg-blue-50 p-3">
                    <svg class="h-6 w-6 text-blue-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m8-5a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>

            </div>
        </div>


        {{-- Total Transaksi --}}
        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Total Transaksi
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $totalTransaksi }}
                    </p>
                </div>

                <div class="rounded-lg bg-purple-50 p-3">
                    <svg class="h-6 w-6 text-purple-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414A1 1 0 0118 8.414V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>

            </div>
        </div>


        {{-- Belum Bayar --}}
        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Belum Bayar
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $belumBayar }}
                    </p>
                </div>

                <div class="rounded-lg bg-amber-50 p-3">
                    <svg class="h-6 w-6 text-amber-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

            </div>
        </div>


        {{-- Laundry Diproses --}}
        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-gray-500">
                        Laundry Diproses
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $laundryDiproses }}
                    </p>
                </div>

                <div class="rounded-lg bg-cyan-50 p-3">
                    <svg class="h-6 w-6 text-cyan-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 12h16M4 12l4-4m-4 4l4 4"/>
                    </svg>
                </div>

            </div>
        </div>

    </div>


    {{-- CONTENT --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- TRANSAKSI TERBARU --}}
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100 lg:col-span-2">

            <div class="border-b border-gray-100 px-6 py-4">
                <div class="flex items-center justify-between">

                    <div>
                        <h2 class="font-semibold text-gray-800">
                            Transaksi Terbaru
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Lima transaksi laundry terbaru.
                        </p>
                    </div>

                    {{-- Nanti diarahkan ke halaman pesanan kasir --}}
                    <span class="text-sm text-gray-400">
                        Kasir
                    </span>

                </div>
            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-6 py-3">
                                Invoice
                            </th>

                            <th class="px-6 py-3">
                                Pelanggan
                            </th>

                            <th class="px-6 py-3">
                                Total
                            </th>

                            <th class="px-6 py-3">
                                Pembayaran
                            </th>

                            <th class="px-6 py-3">
                                Laundry
                            </th>
                        </tr>
                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @forelse ($transaksiTerbaru as $transaksi)

                            @php

                                $paymentClass = match ($transaksi->status_pembayaran) {
                                    'dibayar' => 'bg-emerald-100 text-emerald-700',
                                    'belum_bayar' => 'bg-amber-100 text-amber-700',
                                    'dibatalkan' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };

                                $paymentLabel = match ($transaksi->status_pembayaran) {
                                    'dibayar' => 'Dibayar',
                                    'belum_bayar' => 'Belum Bayar',
                                    'dibatalkan' => 'Dibatalkan',
                                    default => ucfirst($transaksi->status_pembayaran),
                                };


                                $laundryClass = match ($transaksi->status_laundry) {
                                    'menunggu' => 'bg-gray-100 text-gray-700',
                                    'dicuci' => 'bg-blue-100 text-blue-700',
                                    'dikeringkan' => 'bg-purple-100 text-purple-700',
                                    'disetrika' => 'bg-orange-100 text-orange-700',
                                    'siap_diambil' => 'bg-cyan-100 text-cyan-700',
                                    'selesai' => 'bg-emerald-100 text-emerald-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };

                                $laundryLabel = match ($transaksi->status_laundry) {
                                    'menunggu' => 'Menunggu',
                                    'dicuci' => 'Dicuci',
                                    'dikeringkan' => 'Dikeringkan',
                                    'disetrika' => 'Disetrika',
                                    'siap_diambil' => 'Siap Diambil',
                                    'selesai' => 'Selesai',
                                    default => ucfirst($transaksi->status_laundry),
                                };

                            @endphp


                            <tr class="hover:bg-gray-50">

                                <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-800">
                                    {{ $transaksi->invoice }}
                                </td>


                                <td class="whitespace-nowrap px-6 py-4 text-gray-600">
                                    {{ $transaksi->customer->name ?? '-' }}
                                </td>


                                <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-800">
                                    Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                                </td>


                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $paymentClass }}">
                                        {{ $paymentLabel }}
                                    </span>
                                </td>


                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $laundryClass }}">
                                        {{ $laundryLabel }}
                                    </span>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5"
                                    class="px-6 py-10 text-center text-gray-500">
                                    Belum ada transaksi.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- STATUS LAUNDRY --}}
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-100">

            <div class="border-b border-gray-100 px-6 py-4">

                <h2 class="font-semibold text-gray-800">
                    Status Laundry
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Jumlah laundry berdasarkan status.
                </p>

            </div>


            <div class="space-y-4 p-6">

                @php

                    $statusConfig = [
                        'menunggu' => [
                            'label' => 'Menunggu',
                            'dot' => 'bg-gray-500',
                        ],

                        'dicuci' => [
                            'label' => 'Dicuci',
                            'dot' => 'bg-blue-500',
                        ],

                        'dikeringkan' => [
                            'label' => 'Dikeringkan',
                            'dot' => 'bg-purple-500',
                        ],

                        'disetrika' => [
                            'label' => 'Disetrika',
                            'dot' => 'bg-orange-500',
                        ],

                        'siap_diambil' => [
                            'label' => 'Siap Diambil',
                            'dot' => 'bg-cyan-500',
                        ],

                        'selesai' => [
                            'label' => 'Selesai',
                            'dot' => 'bg-emerald-500',
                        ],
                    ];

                @endphp


                @foreach ($statusConfig as $status => $config)

                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-3">

                            <span class="h-3 w-3 rounded-full {{ $config['dot'] }}"></span>

                            <span class="text-sm font-medium text-gray-700">
                                {{ $config['label'] }}
                            </span>

                        </div>

                        <span class="text-sm font-bold text-gray-800">
                            {{ $statusLaundry[$status] ?? 0 }}
                        </span>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

@endsection
