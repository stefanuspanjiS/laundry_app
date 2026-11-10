@extends('layouts.admin')

@section('title', 'Transaksi')
@section('page-title', 'Transaksi Laundry')

@section('content')

<div class="mb-6 sm:mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div class="min-w-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
            Transaksi Laundry
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Kelola seluruh transaksi laundry.
        </p>
    </div>

    <a
        href="{{ route('admin.transactions.create') }}"
        class="w-full sm:w-auto inline-flex items-center justify-center gap-2
               px-4 py-2.5 rounded-xl
               bg-gray-900 text-white
               text-sm font-medium
               hover:bg-gray-800 transition
               shrink-0"
    >
        <span class="text-lg leading-none">+</span>
        Transaksi Baru
    </a>

</div>


<div class="bg-white rounded-xl border border-gray-200">

    {{-- Filter --}}
    <div class="p-4 sm:p-5 border-b border-gray-200">

        <form
            method="GET"
            action="{{ route('admin.transactions.index') }}"
            class="flex flex-col lg:flex-row gap-3"
        >

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari invoice atau pelanggan..."
                class="w-full lg:w-72 px-4 py-2.5 border border-gray-300 rounded-lg
                       text-sm focus:outline-none focus:ring-2 focus:ring-gray-900"
            >

            <select
                name="status_laundry"
                class="w-full lg:w-auto px-4 py-2.5 border border-gray-300
                       rounded-lg text-sm"
                onchange="this.form.submit()"
            >

                <option value="">
                    Semua Status Laundry
                </option>

                <option value="menunggu"
                    {{ request('status_laundry') === 'menunggu' ? 'selected' : '' }}>
                    Menunggu
                </option>

                <option value="dicuci"
                    {{ request('status_laundry') === 'dicuci' ? 'selected' : '' }}>
                    Dicuci
                </option>

                <option value="dikeringkan"
                    {{ request('status_laundry') === 'dikeringkan' ? 'selected' : '' }}>
                    Dikeringkan
                </option>

                <option value="disetrika"
                    {{ request('status_laundry') === 'disetrika' ? 'selected' : '' }}>
                    Disetrika
                </option>

                <option value="siap_diambil"
                    {{ request('status_laundry') === 'siap_diambil' ? 'selected' : '' }}>
                    Siap Diambil
                </option>

                <option value="selesai"
                    {{ request('status_laundry') === 'selesai' ? 'selected' : '' }}>
                    Selesai
                </option>

            </select>

            <div class="flex flex-col sm:flex-row gap-2">

                <button
                    type="submit"
                    class="w-full sm:w-auto px-4 py-2.5
                           bg-gray-900 text-white rounded-lg
                           text-sm text-center"
                >
                    Cari
                </button>

                @if(request('search') || request('status_laundry'))

                    <a
                        href="{{ route('admin.transactions.index') }}"
                        class="w-full sm:w-auto px-4 py-2.5
                               border border-gray-300 rounded-lg
                               text-sm hover:bg-gray-50
                               text-center"
                    >
                        Reset
                    </a>

                @endif

            </div>

        </form>

    </div>


    {{-- Table --}}
    <div class="overflow-x-auto">

        <table class="w-full min-w-[900px] text-sm">

            <thead class="bg-gray-50">

                <tr class="text-left text-gray-500">

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Invoice
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Pelanggan
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Berat
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Total
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Pembayaran
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Laundry
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Aksi
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

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                             bg-green-100 text-green-700 text-xs font-semibold
                                             whitespace-nowrap">
                                    Dibayar
                                </span>

                            @elseif($transaction->status_pembayaran === 'belum_bayar')

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                             bg-amber-100 text-amber-700 text-xs font-semibold
                                             whitespace-nowrap">
                                    Belum Bayar
                                </span>

                            @elseif($transaction->status_pembayaran === 'dibatalkan')

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                             bg-red-100 text-red-700 text-xs font-semibold
                                             whitespace-nowrap">
                                    Dibatalkan
                                </span>

                            @else

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                             bg-gray-100 text-gray-600 text-xs font-semibold
                                             whitespace-nowrap">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->status_pembayaran)) }}
                                </span>

                            @endif

                        </td>


                        {{-- Status Laundry --}}
                        <td class="px-4 sm:px-6 py-3 sm:py-4">

                            @if($transaction->status_laundry === 'menunggu')

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                             bg-gray-100 text-gray-700 text-xs font-semibold
                                             whitespace-nowrap">
                                    Menunggu
                                </span>

                            @elseif($transaction->status_laundry === 'dicuci')

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                             bg-blue-100 text-blue-700 text-xs font-semibold
                                             whitespace-nowrap">
                                    Dicuci
                                </span>

                            @elseif($transaction->status_laundry === 'dikeringkan')

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                             bg-purple-100 text-purple-700 text-xs font-semibold
                                             whitespace-nowrap">
                                    Dikeringkan
                                </span>

                            @elseif($transaction->status_laundry === 'disetrika')

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                             bg-orange-100 text-orange-700 text-xs font-semibold
                                             whitespace-nowrap">
                                    Disetrika
                                </span>

                            @elseif($transaction->status_laundry === 'siap_diambil')

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                             bg-cyan-100 text-cyan-700 text-xs font-semibold
                                             whitespace-nowrap">
                                    Siap Diambil
                                </span>

                            @elseif($transaction->status_laundry === 'selesai')

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                             bg-green-100 text-green-700 text-xs font-semibold
                                             whitespace-nowrap">
                                    Selesai
                                </span>

                            @else

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                             bg-gray-100 text-gray-600 text-xs font-semibold
                                             whitespace-nowrap">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->status_laundry)) }}
                                </span>

                            @endif

                        </td>


                        {{-- Aksi --}}
                        <td class="px-4 sm:px-6 py-3 sm:py-4">

                            <div class="flex items-center gap-1">

                                <a
                                    href="{{ route('admin.transactions.show', $transaction) }}"
                                    class="inline-flex items-center
                                           justify-center
                                           w-9 h-9 rounded-lg
                                           text-gray-600
                                           hover:bg-gray-100"
                                    title="Detail"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943
                                            7.523 5 12 5c4.478 0
                                            8.268 2.943 9.542 7
                                            -1.274 4.057-5.064 7-9.542 7
                                            -4.477 0-8.268-2.943-9.542-7z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0
                                            3 3 0 016 0z"
                                        />
                                    </svg>
                                </a>

                                <a
                                    href="{{ route(
                                        'admin.transactions.edit',
                                        $transaction
                                    ) }}"
                                    class="inline-flex items-center
                                           justify-center
                                           w-9 h-9 rounded-lg
                                           text-gray-600
                                           hover:bg-gray-100"
                                    title="Edit"
                                >
                                    ✎
                                </a>

                                @if(
                                    $transaction->status_pembayaran
                                    !== 'dibayar'
                                )

                                    <form
                                        action="{{ route(
                                            'admin.transactions.destroy',
                                            $transaction
                                        ) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm(
                                            'Yakin ingin menghapus transaksi ini?'
                                        )"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center
                                                   justify-center
                                                   w-9 h-9 rounded-lg
                                                   text-red-500
                                                   hover:bg-red-50"
                                            title="Hapus"
                                        >
                                            ×
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="px-4 sm:px-6 py-8 text-center text-gray-500"
                        >
                            Belum ada data transaksi.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
