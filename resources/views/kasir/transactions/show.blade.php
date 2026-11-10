@extends('layouts.kasir')

@section('title', 'Detail Pesanan')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <a
                href="{{ route('kasir.transactions.index') }}"
                class="text-sm font-medium text-gray-500 hover:text-gray-900"
            >
                ← Kembali ke Pesanan
            </a>

            <h1 class="mt-3 text-2xl font-bold text-gray-900">
                {{ $transaction->invoice }}
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                {{ $transaction->tanggal_masuk?->format('d F Y, H:i') }}
            </p>

        </div>


        <div class="flex flex-wrap gap-2">

            @if($transaction->status_laundry !== 'selesai')

                <a
                    href="{{ route('kasir.transactions.edit', $transaction) }}"
                    class="rounded-lg border border-gray-300 bg-white
                           px-4 py-2.5 text-sm font-semibold text-gray-700
                           hover:bg-gray-50"
                >
                    Edit
                </a>

            @endif


            <a
                href="{{ route('kasir.transactions.status.edit', $transaction) }}"
                class="rounded-lg bg-gray-900 px-4 py-2.5
                       text-sm font-semibold text-white
                       hover:bg-gray-800"
            >
                Update Status
            </a>

        </div>

    </div>


    {{-- STATUS --}}
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


    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

            <p class="text-sm text-gray-500">
                Status Pembayaran
            </p>

            <span
                class="mt-2 inline-flex rounded-full px-3 py-1.5
                       text-sm font-semibold {{ $paymentClass }}"
            >
                {{ $paymentLabel }}
            </span>

        </div>


        <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

            <p class="text-sm text-gray-500">
                Status Laundry
            </p>

            <span
                class="mt-2 inline-flex rounded-full px-3 py-1.5
                       text-sm font-semibold {{ $laundryClass }}"
            >
                {{ $laundryLabel }}
            </span>

        </div>

    </div>


    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- DATA --}}
        <div class="space-y-6 lg:col-span-2">

            {{-- PELANGGAN --}}
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">

                <h2 class="font-semibold text-gray-900">
                    Data Pelanggan
                </h2>

                <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">

                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Nama
                        </p>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ $transaction->customer->name ?? '-' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            No. HP
                        </p>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ $transaction->customer->phone ?? '-' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Kasir
                        </p>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ $transaction->cashier->name ?? '-' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Tanggal Masuk
                        </p>

                        <p class="mt-1 font-medium text-gray-800">
                            {{ $transaction->tanggal_masuk?->format('d M Y, H:i') }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- DETAIL --}}
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">

                <div class="border-b border-gray-200 px-6 py-4">

                    <h2 class="font-semibold text-gray-900">
                        Detail Laundry
                    </h2>

                </div>


                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="bg-gray-50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                    Paket
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                    Berat
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                    Harga/kg
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase text-gray-500">
                                    Subtotal
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-100">

                            @foreach($transaction->details as $detail)

                                <tr>

                                    <td class="px-6 py-4 font-medium text-gray-800">
                                        {{ $detail->package->nama_paket ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-gray-600">
                                        {{ number_format($detail->berat, 1, ',', '.') }} kg
                                    </td>

                                    <td class="px-6 py-4 text-gray-600">
                                        Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-4 text-right font-semibold text-gray-800">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- RIWAYAT STATUS --}}
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">

                <h2 class="font-semibold text-gray-900">
                    Riwayat Status Laundry
                </h2>

                <div class="mt-6">

                    @forelse(
                        $transaction->laundryStatuses->sortByDesc('created_at')
                        as $status
                    )

                        @php

                            $dot = match ($status->status) {

                                'menunggu' => 'bg-gray-500',

                                'dicuci' => 'bg-blue-500',

                                'dikeringkan' => 'bg-purple-500',

                                'disetrika' => 'bg-orange-500',

                                'siap_diambil' => 'bg-cyan-500',

                                'selesai' => 'bg-emerald-500',

                                default => 'bg-gray-500',
                            };


                            $label = match ($status->status) {

                                'menunggu' => 'Menunggu',

                                'dicuci' => 'Dicuci',

                                'dikeringkan' => 'Dikeringkan',

                                'disetrika' => 'Disetrika',

                                'siap_diambil' => 'Siap Diambil',

                                'selesai' => 'Selesai',

                                default => ucfirst($status->status),
                            };

                        @endphp


                        <div class="relative flex gap-4">

                            <div class="flex flex-col items-center">

                                <span
                                    class="mt-1 h-3 w-3 shrink-0 rounded-full {{ $dot }}"
                                ></span>

                                @if(!$loop->last)

                                    <span class="mt-2 h-full w-px bg-gray-200"></span>

                                @endif

                            </div>


                            <div class="pb-6">

                                <p class="font-semibold text-gray-800">
                                    {{ $label }}
                                </p>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $status->created_at?->format('d M Y, H:i') }}
                                </p>

                                @if($status->keterangan)

                                    <p class="mt-2 text-sm text-gray-600">
                                        {{ $status->keterangan }}
                                    </p>

                                @endif

                                @if($status->updater)

                                    <p class="mt-1 text-xs text-gray-400">
                                        Oleh: {{ $status->updater->name }}
                                    </p>

                                @endif

                            </div>

                        </div>

                    @empty

                        <p class="text-sm text-gray-500">
                            Belum ada riwayat status.
                        </p>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- RINGKASAN --}}
        <div>

            <div class="sticky top-24 rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">

                <h2 class="font-semibold text-gray-900">
                    Ringkasan Pembayaran
                </h2>


                <div class="mt-5 space-y-4">

                    <div class="flex justify-between text-sm">

                        <span class="text-gray-500">
                            Total Berat
                        </span>

                        <span class="font-medium text-gray-800">
                            {{ number_format($transaction->total_berat, 1, ',', '.') }} kg
                        </span>

                    </div>


                    <div class="flex justify-between text-sm">

                        <span class="text-gray-500">
                            Subtotal
                        </span>

                        <span class="font-medium text-gray-800">
                            Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}
                        </span>

                    </div>


                    <div class="flex justify-between text-sm">

                        <span class="text-gray-500">
                            Diskon
                        </span>

                        <span class="font-medium text-gray-800">
                            Rp {{ number_format($transaction->diskon, 0, ',', '.') }}
                        </span>

                    </div>


                    <div class="border-t border-gray-200 pt-4">

                        <div class="flex justify-between">

                            <span class="font-semibold text-gray-800">
                                Total Bayar
                            </span>

                            <span class="text-xl font-bold text-gray-900">
                                Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}
                            </span>

                        </div>

                    </div>

                </div>


                {{-- PEMBAYARAN --}}
                @if($transaction->status_pembayaran === 'belum_bayar')

                    <div class="mt-6 rounded-lg bg-amber-50 p-4">

                        <p class="text-sm font-semibold text-amber-800">
                            Pesanan belum dibayar
                        </p>

                        <p class="mt-1 text-xs text-amber-700">
                            Fitur pembayaran akan tersedia melalui menu Pembayaran.
                        </p>

                    </div>

                @endif


                {{-- HAPUS --}}
                @if(
                    $transaction->status_pembayaran !== 'dibayar'
                    && $transaction->status_laundry === 'menunggu'
                )

                    <form
                        method="POST"
                        action="{{ route('kasir.transactions.destroy', $transaction) }}"
                        class="mt-6"
                        onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="w-full rounded-lg border border-red-200
                                   bg-red-50 px-4 py-2.5
                                   text-sm font-semibold text-red-600
                                   hover:bg-red-100"
                        >
                            Hapus Pesanan
                        </button>

                    </form>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection
