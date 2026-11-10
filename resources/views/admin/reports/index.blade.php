@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('content')

<div class="mb-6 sm:mb-8">

    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
        Laporan Laundry
    </h1>

    <p class="mt-1 text-sm text-gray-500">
        Lihat ringkasan transaksi dan pendapatan laundry.
    </p>

</div>

{{-- Filter Laporan --}}

<div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-6 mb-6">

    <form
        method="GET"
        action="{{ route('admin.reports.index') }}"
    >

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            {{-- Dari Tanggal --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Dari Tanggal
                </label>

                <input
                    type="date"
                    name="dari_tanggal"
                    value="{{ $dariTanggal }}"
                    class="w-full border border-gray-300 rounded-lg
                           px-4 py-2.5 focus:outline-none
                           focus:ring-2 focus:ring-gray-900"
                >

            </div>


            {{-- Sampai Tanggal --}}
            <div>

                <label class="block text-sm font-medium mb-2">
                    Sampai Tanggal
                </label>

                <input
                    type="date"
                    name="sampai_tanggal"
                    value="{{ $sampaiTanggal }}"
                    class="w-full border border-gray-300 rounded-lg
                           px-4 py-2.5 focus:outline-none
                           focus:ring-2 focus:ring-gray-900"
                >

            </div>


            {{-- Tampilkan --}}
            <div class="flex items-end">

                <button
                    type="submit"
                    class="w-full bg-gray-900 text-white rounded-lg
                           py-2.5 hover:bg-gray-800"
                >
                    Tampilkan
                </button>

            </div>


            {{-- Reset --}}
            <div class="flex items-end">

                <a
                    href="{{ route('admin.reports.index') }}"
                    class="w-full border border-gray-300 rounded-lg
                           py-2.5 text-center hover:bg-gray-50"
                >
                    Reset
                </a>

            </div>

        </div>

    </form>

</div>

{{-- Statistik --}}

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 mb-6">

    {{-- Total Transaksi --}}
    <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-6">

        <p class="text-sm text-gray-500">
            Total Transaksi
        </p>

        <h2 class="text-2xl sm:text-3xl font-bold mt-2 break-words">
            {{ $totalTransaksi }}
        </h2>

    </div>


    {{-- Total Berat --}}
    <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-6">

        <p class="text-sm text-gray-500">
            Total Berat Laundry
        </p>

        <h2 class="text-2xl sm:text-3xl font-bold mt-2 break-words">
            {{ number_format($totalBerat, 2, ',', '.') }} Kg
        </h2>

    </div>


    {{-- Total Pendapatan --}}
    <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-6">

        <p class="text-sm text-gray-500">
            Total Pendapatan
        </p>

        <h2 class="text-2xl sm:text-3xl font-bold mt-2 break-words">
            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </h2>

    </div>


</div>

{{-- Ringkasan Transaksi --}}

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

    <div class="p-4 sm:p-6 border-b border-gray-200">

        <h2 class="font-semibold">
            Ringkasan Transaksi
        </h2>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full min-w-[800px] text-sm">

            <thead class="bg-gray-50">

                <tr class="text-left text-gray-500">

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Invoice
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Pelanggan
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Tanggal
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Berat
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Total
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Status Pembayaran
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-100">

                @forelse($transactions as $transaction)

                    <tr>

                        {{-- Invoice --}}
                        <td class="px-4 sm:px-6 py-3 sm:py-4 font-medium text-gray-900">

                            <span class="break-all">
                                {{ $transaction->invoice }}
                            </span>

                        </td>


                        {{-- Pelanggan --}}
                        <td class="px-4 sm:px-6 py-3 sm:py-4">

                            <span class="break-words">
                                {{ $transaction->customer->name ?? '-' }}
                            </span>

                        </td>


                        {{-- Tanggal --}}
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">

                            {{ $transaction->tanggal_masuk->format('d-m-Y') }}

                        </td>


                        {{-- Berat --}}
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">

                            {{ number_format($transaction->total_berat, 2, ',', '.') }}
                            Kg

                        </td>


                        {{-- Total --}}
                        <td class="px-4 sm:px-6 py-3 sm:py-4 whitespace-nowrap">

                            Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}

                        </td>


                        {{-- Status Pembayaran --}}
                        <td class="px-4 sm:px-6 py-3 sm:py-4">

                            @if($transaction->status_pembayaran === 'dibayar')

                                <span class="inline-flex px-2.5 py-1 rounded-full
                                             bg-gray-900 text-white text-xs
                                             whitespace-nowrap">
                                    Dibayar
                                </span>

                            @elseif($transaction->status_pembayaran === 'belum_bayar')

                                <span class="inline-flex px-2.5 py-1 rounded-full
                                             bg-gray-100 text-gray-700 text-xs
                                             whitespace-nowrap">
                                    Belum Bayar
                                </span>

                            @else

                                <span class="inline-flex px-2.5 py-1 rounded-full
                                             bg-gray-100 text-gray-500 text-xs
                                             whitespace-nowrap">
                                    Dibatalkan
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="px-4 sm:px-6 py-8 text-center text-gray-500"
                        >
                            Tidak ada transaksi pada periode tersebut.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


</div>

@endsection
