@extends('layouts.kasir')

@section('title', 'Pesanan')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Pesanan
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Kelola seluruh pesanan laundry pelanggan.
            </p>
        </div>


        <a
            href="{{ route('kasir.transactions.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg
                   bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white
                   transition hover:bg-gray-800"
        >
            <svg
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 5v14M5 12h14"
                />
            </svg>

            Buat Pesanan
        </a>

    </div>


    {{-- FILTER --}}
    <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

        <form
            method="GET"
            action="{{ route('kasir.transactions.index') }}"
            class="grid grid-cols-1 gap-4 md:grid-cols-4"
        >

            {{-- Search --}}
            <div class="md:col-span-2">

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Cari Pesanan
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Invoice atau nama pelanggan..."
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5
                           text-sm outline-none transition
                           focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                >

            </div>


            {{-- Pembayaran --}}
            <div>

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Pembayaran
                </label>

                <select
                    name="status_pembayaran"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5
                           text-sm outline-none
                           focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                >

                    <option value="">
                        Semua
                    </option>

                    <option
                        value="belum_bayar"
                        @selected(request('status_pembayaran') === 'belum_bayar')
                    >
                        Belum Bayar
                    </option>

                    <option
                        value="dibayar"
                        @selected(request('status_pembayaran') === 'dibayar')
                    >
                        Dibayar
                    </option>

                    <option
                        value="dibatalkan"
                        @selected(request('status_pembayaran') === 'dibatalkan')
                    >
                        Dibatalkan
                    </option>

                </select>

            </div>


            {{-- Laundry --}}
            <div>

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Status Laundry
                </label>

                <select
                    name="status_laundry"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5
                           text-sm outline-none
                           focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                >

                    <option value="">
                        Semua
                    </option>

                    <option value="menunggu" @selected(request('status_laundry') === 'menunggu')>
                        Menunggu
                    </option>

                    <option value="dicuci" @selected(request('status_laundry') === 'dicuci')>
                        Dicuci
                    </option>

                    <option value="dikeringkan" @selected(request('status_laundry') === 'dikeringkan')>
                        Dikeringkan
                    </option>

                    <option value="disetrika" @selected(request('status_laundry') === 'disetrika')>
                        Disetrika
                    </option>

                    <option value="siap_diambil" @selected(request('status_laundry') === 'siap_diambil')>
                        Siap Diambil
                    </option>

                    <option value="selesai" @selected(request('status_laundry') === 'selesai')>
                        Selesai
                    </option>

                </select>

            </div>


            <div class="md:col-span-4 flex gap-2">

                <button
                    type="submit"
                    class="rounded-lg bg-gray-900 px-4 py-2.5
                           text-sm font-semibold text-white
                           hover:bg-gray-800"
                >
                    Terapkan Filter
                </button>

                <a
                    href="{{ route('kasir.transactions.index') }}"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2.5
                           text-sm font-semibold text-gray-700
                           hover:bg-gray-50"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- TABLE --}}
    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="border-b border-gray-200 bg-gray-50">

                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Invoice
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Pelanggan
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Berat
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Total
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Pembayaran
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Laundry
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse ($transactions as $transaction)

                        @php

                            $paymentClass = match ($transaction->status_pembayaran) {

                                'dibayar' =>
                                    'bg-emerald-100 text-emerald-700',

                                'belum_bayar' =>
                                    'bg-amber-100 text-amber-700',

                                'dibatalkan' =>
                                    'bg-red-100 text-red-700',

                                default =>
                                    'bg-gray-100 text-gray-700',
                            };


                            $paymentLabel = match ($transaction->status_pembayaran) {

                                'dibayar' => 'Dibayar',

                                'belum_bayar' => 'Belum Bayar',

                                'dibatalkan' => 'Dibatalkan',

                                default =>
                                    ucfirst($transaction->status_pembayaran),
                            };


                            $laundryClass = match ($transaction->status_laundry) {

                                'menunggu' =>
                                    'bg-gray-100 text-gray-700',

                                'dicuci' =>
                                    'bg-blue-100 text-blue-700',

                                'dikeringkan' =>
                                    'bg-purple-100 text-purple-700',

                                'disetrika' =>
                                    'bg-orange-100 text-orange-700',

                                'siap_diambil' =>
                                    'bg-cyan-100 text-cyan-700',

                                'selesai' =>
                                    'bg-emerald-100 text-emerald-700',

                                default =>
                                    'bg-gray-100 text-gray-700',
                            };


                            $laundryLabel = match ($transaction->status_laundry) {

                                'menunggu' => 'Menunggu',

                                'dicuci' => 'Dicuci',

                                'dikeringkan' => 'Dikeringkan',

                                'disetrika' => 'Disetrika',

                                'siap_diambil' => 'Siap Diambil',

                                'selesai' => 'Selesai',

                                default =>
                                    ucfirst($transaction->status_laundry),
                            };

                        @endphp


                        <tr class="transition hover:bg-gray-50">

                            <td class="whitespace-nowrap px-6 py-4">

                                <a
                                    href="{{ route('kasir.transactions.show', $transaction) }}"
                                    class="font-semibold text-gray-900 hover:underline"
                                >
                                    {{ $transaction->invoice }}
                                </a>

                                <p class="mt-1 text-xs text-gray-400">
                                    {{ $transaction->tanggal_masuk?->format('d M Y, H:i') }}
                                </p>

                            </td>


                            <td class="whitespace-nowrap px-6 py-4">

                                <p class="font-medium text-gray-800">
                                    {{ $transaction->customer->name ?? '-' }}
                                </p>

                                <p class="text-xs text-gray-400">
                                    {{ $transaction->customer->phone ?? '-' }}
                                </p>

                            </td>


                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">

                                {{ number_format($transaction->total_berat, 1, ',', '.') }}
                                kg

                            </td>


                            <td class="whitespace-nowrap px-6 py-4 font-semibold text-gray-800">

                                Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}

                            </td>


                            <td class="whitespace-nowrap px-6 py-4">

                                <span
                                    class="inline-flex rounded-full px-2.5 py-1
                                           text-xs font-semibold {{ $paymentClass }}"
                                >
                                    {{ $paymentLabel }}
                                </span>

                            </td>


                            <td class="whitespace-nowrap px-6 py-4">

                                <span
                                    class="inline-flex rounded-full px-2.5 py-1
                                           text-xs font-semibold {{ $laundryClass }}"
                                >
                                    {{ $laundryLabel }}
                                </span>

                            </td>


                            <td class="whitespace-nowrap px-6 py-4 text-right">

                                <a
                                    href="{{ route('kasir.transactions.show', $transaction) }}"
                                    class="text-sm font-semibold text-gray-700 hover:text-gray-900"
                                >
                                    Detail
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-12 text-center"
                            >

                                <div class="mx-auto max-w-sm">

                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">

                                        <svg
                                            class="h-6 w-6 text-gray-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293L18 8.414A1 1 0 0118.414 9V19a2 2 0 01-2 2z"
                                            />
                                        </svg>

                                    </div>

                                    <p class="mt-3 font-semibold text-gray-800">
                                        Belum ada pesanan
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Pesanan yang dibuat akan muncul di sini.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if ($transactions->hasPages())

            <div class="border-t border-gray-200 px-6 py-4">

                {{ $transactions->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
