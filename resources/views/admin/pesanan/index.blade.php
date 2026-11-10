@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
            Pesanan
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Daftar pesanan laundry yang masih dalam proses.
        </p>
    </div>


    {{-- FILTER --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-5">

        <form
            action="{{ route('admin.pesanan.index') }}"
            method="GET"
            class="grid grid-cols-1 md:grid-cols-3 gap-4"
        >

            {{-- SEARCH --}}
            <div class="min-w-0">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Cari Pesanan
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Invoice atau nama pelanggan..."
                    class="w-full rounded-xl border-gray-300
                           focus:border-gray-900 focus:ring-gray-900"
                >
            </div>


            {{-- STATUS --}}
            <div class="min-w-0">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status Laundry
                </label>

                <select
                    name="status"
                    class="w-full rounded-xl border-gray-300
                           focus:border-gray-900 focus:ring-gray-900"
                >

                    <option value="">
                        Semua Status
                    </option>

                    @foreach($statuses as $value => $label)

                        <option
                            value="{{ $value }}"
                            @selected(request('status') === $value)
                        >
                            {{ $label }}
                        </option>

                    @endforeach

                </select>
            </div>


            {{-- BUTTON --}}
            <div class="flex flex-col sm:flex-row md:items-end gap-2">

                <button
                    type="submit"
                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl
                           bg-gray-900 text-white
                           text-sm font-medium
                           hover:bg-gray-800
                           text-center"
                >
                    Filter
                </button>

                <a
                    href="{{ route('admin.pesanan.index') }}"
                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl
                           border border-gray-200
                           text-sm font-medium
                           text-gray-700
                           hover:bg-gray-50
                           text-center"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- TABLE --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">

        <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200">

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                <div class="min-w-0">
                    <h3 class="font-semibold text-gray-900">
                        Pesanan Laundry
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        {{ $pesanan->count() }} pesanan masih diproses.
                    </p>
                </div>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px] text-sm">

                <thead class="bg-gray-50 border-b border-gray-200">

                    <tr>

                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left font-semibold text-gray-600">
                            Invoice
                        </th>

                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left font-semibold text-gray-600">
                            Pelanggan
                        </th>

                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left font-semibold text-gray-600">
                            Berat
                        </th>

                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left font-semibold text-gray-600">
                            Total
                        </th>

                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left font-semibold text-gray-600">
                            Pembayaran
                        </th>

                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left font-semibold text-gray-600">
                            Status Laundry
                        </th>

                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-center font-semibold text-gray-600">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($pesanan as $item)

                        <tr class="hover:bg-gray-50 transition">

                            {{-- INVOICE --}}
                            <td class="px-4 sm:px-6 py-3 sm:py-4">

                                <div class="font-semibold text-gray-900 break-all">
                                    {{ $item->invoice }}
                                </div>

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $item->tanggal_masuk?->format('d M Y') }}
                                </div>

                            </td>


                            {{-- CUSTOMER --}}
                            <td class="px-4 sm:px-6 py-3 sm:py-4">

                                <div class="font-medium text-gray-900 break-words">
                                    {{ $item->customer?->name ?? '-' }}
                                </div>

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $item->customer?->phone ?? '-' }}
                                </div>

                            </td>


                            {{-- BERAT --}}
                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-gray-700 whitespace-nowrap">

                                {{ number_format($item->total_berat, 2, ',', '.') }}
                                kg

                            </td>


                            {{-- TOTAL --}}
                            <td class="px-4 sm:px-6 py-3 sm:py-4">

                                <span class="font-semibold text-gray-900 whitespace-nowrap">
                                    Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                                </span>

                            </td>


                            {{-- PAYMENT --}}
                            <td class="px-4 sm:px-6 py-3 sm:py-4">

                                @if($item->status_pembayaran === 'dibayar')

                                    <span
                                        class="inline-flex items-center px-2.5 py-1
                                               rounded-full text-xs font-medium
                                               bg-green-100 text-green-700
                                               whitespace-nowrap"
                                    >
                                        Dibayar
                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center px-2.5 py-1
                                               rounded-full text-xs font-medium
                                               bg-yellow-100 text-yellow-700
                                               whitespace-nowrap"
                                    >
                                        Belum Bayar
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS LAUNDRY --}}
                            <td class="px-4 sm:px-6 py-3 sm:py-4">

                                @php
                                    $statusClass = match($item->status_laundry) {
                                        'menunggu' => 'bg-gray-100 text-gray-700',
                                        'dicuci' => 'bg-blue-100 text-blue-700',
                                        'dikeringkan' => 'bg-cyan-100 text-cyan-700',
                                        'disetrika' => 'bg-purple-100 text-purple-700',
                                        'siap_diambil' => 'bg-green-100 text-green-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };

                                    $statusLabel = $statuses[$item->status_laundry]
                                        ?? ucfirst(str_replace('_', ' ', $item->status_laundry));
                                @endphp

                                <span
                                    class="inline-flex items-center px-2.5 py-1
                                           rounded-full text-xs font-medium
                                           {{ $statusClass }}
                                           whitespace-nowrap"
                                >
                                    {{ $statusLabel }}
                                </span>

                            </td>


                            {{-- AKSI --}}
                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">

                                <a
                                    href="{{ route(
                                        'admin.transactions.status.edit',
                                        $item
                                    ) }}"
                                    class="inline-flex items-center justify-center gap-2
                                           px-4 py-2 rounded-xl
                                           bg-gray-900 text-white
                                           text-sm font-medium
                                           hover:bg-gray-800
                                           transition
                                           whitespace-nowrap"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                    </svg>

                                    Update Status

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-4 sm:px-6 py-12 text-center"
                            >

                                <div class="flex flex-col items-center">

                                    <div
                                        class="w-12 h-12 rounded-full
                                               bg-gray-100
                                               flex items-center justify-center
                                               mb-3"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="w-6 h-6 text-gray-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4"
                                            />
                                        </svg>

                                    </div>

                                    <p class="font-medium text-gray-900">
                                        Tidak ada pesanan
                                    </p>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Semua pesanan sudah selesai.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
