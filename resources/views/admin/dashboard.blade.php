@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    {{-- Header --}}
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl font-bold text-gray-900">
            Dashboard
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Selamat datang di halaman administrasi Laundry App.
        </p>
    </div>


    {{-- Statistics --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">

        {{-- Total Pelanggan --}}
        <div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Total Pelanggan
                    </p>

                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalPelanggan }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-xl">
                    👥
                </div>

            </div>

            <p class="text-xs text-gray-500 mt-4">
                Pelanggan terdaftar
            </p>
        </div>


        {{-- Total Transaksi --}}
        <div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Total Transaksi
                    </p>

                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalTransaksi }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-xl">
                    🧾
                </div>

            </div>

            <p class="text-xs text-gray-500 mt-4">
                Semua transaksi laundry
            </p>
        </div>


        {{-- Belum Bayar --}}
        <div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Belum Bayar
                    </p>

                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-2">
                        {{ $belumBayar }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-xl">
                    💳
                </div>

            </div>

            <p class="text-xs text-gray-500 mt-4">
                Menunggu pembayaran
            </p>
        </div>


        {{-- Laundry Diproses --}}
        <div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Laundry Diproses
                    </p>

                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-2">
                        {{ $laundryDiproses }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-xl">
                    🧺
                </div>

            </div>

            <p class="text-xs text-gray-500 mt-4">
                Sedang dikerjakan
            </p>
        </div>

    </div>


    {{-- Content Grid --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 sm:gap-6">

        {{-- Transaksi Terbaru --}}
        <div class="xl:col-span-2 bg-white rounded-xl border border-gray-200">

            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200
            flex flex-col sm:flex-row
            sm:items-center sm:justify-between
            gap-3">

                <div>
                    <h2 class="font-semibold text-gray-900">
                        Transaksi Terbaru
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Daftar transaksi laundry terbaru
                    </p>
                </div>

                <a href="{{ route('admin.transactions.index') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">
                    Lihat semua
                </a>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full min-w-[600px] text-sm">

                    <thead class="bg-gray-50">
                        <tr class="text-left text-gray-500">

                            <th class="px-4 sm:px-6 py-3 sm:py-4 font-medium">
                                Invoice
                            </th>

                            <th class="px-4 sm:px-6 py-3 sm:py-4 font-medium">
                                Pelanggan
                            </th>

                            <th class="px-4 sm:px-6 py-3 sm:py-4 font-medium">
                                Total
                            </th>

                            <th class="px-4 sm:px-6 py-3 sm:py-4 font-medium">
                                Status
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($transaksiTerbaru as $transaksi)

                            <tr>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 font-medium text-gray-900">
                                    {{ $transaksi->invoice }}
                                </td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-gray-600">
                                    {{ $transaksi->customer->name }}
                                </td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4 text-gray-600">
                                    Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                                </td>

                                <td class="px-4 sm:px-6 py-3 sm:py-4">

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
                                            'dikeringkan' => 'bg-purple-100 text-purple-700',
                                            'disetrika' => 'bg-orange-100 text-orange-700',
                                            'siap_diambil' => 'bg-cyan-100 text-cyan-700',
                                            'selesai' => 'bg-emerald-100 text-emerald-700',
                                        ];
                                    @endphp

                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass[$transaksi->status_laundry] ?? 'bg-gray-100 text-gray-700' }}"
                                    >
                                        {{ $statusLabel[$transaksi->status_laundry] ?? '-' }}
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada transaksi.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- Status Laundry --}}
        <div class="bg-white rounded-xl border border-gray-200">

            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200">

                <h2 class="font-semibold text-gray-900">
                    Status Laundry
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Ringkasan status laundry saat ini
                </p>

            </div>

            @php
                $statusLaundryConfig = [
                    'menunggu' => [
                        'label' => 'Menunggu',
                        'dot' => 'bg-gray-400',
                        'badge' => 'bg-gray-100 text-gray-700',
                    ],

                    'dicuci' => [
                        'label' => 'Dicuci',
                        'dot' => 'bg-blue-500',
                        'badge' => 'bg-blue-100 text-blue-700',
                    ],

                    'dikeringkan' => [
                        'label' => 'Dikeringkan',
                        'dot' => 'bg-purple-500',
                        'badge' => 'bg-purple-100 text-purple-700',
                    ],

                    'disetrika' => [
                        'label' => 'Disetrika',
                        'dot' => 'bg-orange-500',
                        'badge' => 'bg-orange-100 text-orange-700',
                    ],

                    'siap_diambil' => [
                        'label' => 'Siap Diambil',
                        'dot' => 'bg-cyan-500',
                        'badge' => 'bg-cyan-100 text-cyan-700',
                    ],

                    'selesai' => [
                        'label' => 'Selesai',
                        'dot' => 'bg-emerald-500',
                        'badge' => 'bg-emerald-100 text-emerald-700',
                    ],
                ];
            @endphp

            <div class="p-4 sm:p-6 space-y-4">

                @foreach($statusLaundryConfig as $status => $config)

                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-3">

                            <div
                                class="w-3 h-3 rounded-full {{ $config['dot'] }}"
                            ></div>

                            <span class="text-sm text-gray-600">
                                {{ $config['label'] }}
                            </span>

                        </div>

                        <span
                            class="inline-flex min-w-8 justify-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $config['badge'] }}"
                        >
                            {{ $statusLaundry[$status] ?? 0 }}
                        </span>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

@endsection

