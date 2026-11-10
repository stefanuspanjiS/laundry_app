@extends('layouts.pelanggan')

@section('content')

<div class="w-full min-w-0 space-y-6">

    <div class="flex min-w-0 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="min-w-0">
            <h1 class="text-xl font-bold text-gray-800 sm:text-2xl">
                Pesanan Saya
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Lihat dan pantau semua pesanan laundry kamu.
            </p>
        </div>

        <a
            href="{{ route('pelanggan.orders.create') }}"
            class="inline-flex w-full shrink-0 items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700 sm:w-auto"
        >
            + Buat Pesanan
        </a>

    </div>


    <div class="min-w-0 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">

        @if($pesanan->count() > 0)

            {{-- =========================================================
                 MOBILE
                 ========================================================= --}}
            <div class="block sm:hidden">

                {{-- Pencarian Invoice --}}
                <div class="border-b border-gray-100 p-4">

                    <label
                        for="searchInvoice"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Cari Pesanan
                    </label>

                    <div class="relative mt-2">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">

                            <svg
                                class="h-5 w-5 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                                />
                            </svg>

                        </div>

                        <input
                            type="text"
                            id="searchInvoice"
                            placeholder="Cari berdasarkan invoice..."
                            autocomplete="off"
                            class="block w-full min-w-0 rounded-lg border border-gray-300 bg-white py-3 pl-10 pr-10 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                        <button
                            type="button"
                            id="clearSearch"
                            class="absolute inset-y-0 right-0 hidden items-center pr-3 text-gray-400 hover:text-gray-600"
                            aria-label="Hapus pencarian"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 6l12 12M18 6L6 18"
                                />
                            </svg>
                        </button>

                    </div>

                    <p
                        id="searchResult"
                        class="mt-2 hidden text-xs text-gray-500"
                    ></p>

                </div>


                {{-- Daftar Pesanan Mobile --}}
                <div
                    id="mobileOrderList"
                    class="space-y-3 bg-gray-50 p-3"
                >

                    @foreach($pesanan as $transaction)

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

                        <div
                            class="order-card min-w-0 rounded-xl border border-gray-200 bg-white p-4 shadow-sm"
                            data-invoice="{{ strtolower($transaction->invoice) }}"
                        >

                            {{-- Invoice + Status Laundry --}}
                            <div class="flex min-w-0 items-start justify-between gap-3">

                                <div class="min-w-0">

                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                        Invoice
                                    </p>

                                    <p class="mt-1 break-all text-sm font-semibold text-gray-800">
                                        {{ $transaction->invoice }}
                                    </p>

                                </div>

                                <span class="inline-flex max-w-[48%] shrink-0 whitespace-nowrap rounded-full px-3 py-1 text-xs font-medium {{ $statusClass[$transaction->status_laundry] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $statusLabel[$transaction->status_laundry] ?? $transaction->status_laundry }}
                                </span>

                            </div>


                            {{-- Detail Pesanan --}}
                            <div class="mt-4 grid grid-cols-2 gap-x-4 gap-y-4">

                                {{-- Tanggal --}}
                                <div class="min-w-0">

                                    <p class="text-xs text-gray-400">
                                        Tanggal
                                    </p>

                                    <p class="mt-1 break-words text-sm text-gray-700">
                                        {{ $transaction->tanggal_masuk?->format('d/m/Y H:i') ?? '-' }}
                                    </p>

                                </div>


                                {{-- Berat --}}
                                <div class="min-w-0">

                                    <p class="text-xs text-gray-400">
                                        Berat
                                    </p>

                                    <p class="mt-1 text-sm text-gray-700">
                                        {{ number_format($transaction->total_berat, 2, ',', '.') }} kg
                                    </p>

                                </div>


                                {{-- Total --}}
                                <div class="min-w-0">

                                    <p class="text-xs text-gray-400">
                                        Total
                                    </p>

                                    <p class="mt-1 break-words text-sm font-semibold text-gray-800">
                                        Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}
                                    </p>

                                </div>


                                {{-- Pembayaran --}}
                                <div class="min-w-0">

                                    <p class="text-xs text-gray-400">
                                        Pembayaran
                                    </p>

                                    <div class="mt-1">

                                        @if($transaction->status_pembayaran === 'dibayar')

                                            <span class="inline-flex whitespace-nowrap rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                                Dibayar
                                            </span>

                                        @elseif($transaction->status_pembayaran === 'dibatalkan')

                                            <span class="inline-flex whitespace-nowrap rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                                Dibatalkan
                                            </span>

                                        @else

                                            <span class="inline-flex whitespace-nowrap rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                                                Belum Bayar
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- Aksi --}}
                            <div class="mt-4 flex flex-col gap-2 border-t border-gray-100 pt-3">

                                <a
                                    href="{{ route('pelanggan.orders.show', $transaction) }}"
                                    class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                                >
                                    Detail Pesanan
                                </a>

                                @if($transaction->payment?->status === 'pending')

                                    <a
                                        href="{{ route('pelanggan.payments.show', $transaction->payment) }}"
                                        class="inline-flex w-full items-center justify-center rounded-lg bg-blue-600 px-3 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700"
                                    >
                                        Bayar Sekarang
                                    </a>

                                @endif

                            </div>

                        </div>

                    @endforeach


                    {{-- Tidak ditemukan --}}
                    <div
                        id="noSearchResult"
                        class="hidden rounded-xl border border-gray-200 bg-white px-4 py-8 text-center"
                    >

                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">

                            <svg
                                class="h-6 w-6 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                                />
                            </svg>

                        </div>

                        <h3 class="mt-3 text-sm font-semibold text-gray-800">
                            Pesanan Tidak Ditemukan
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Tidak ada pesanan dengan nomor invoice tersebut.
                        </p>

                    </div>

                </div>

                {{-- Pagination Mobile --}}
                <div class="border-t border-gray-100 bg-white px-4 py-4 sm:hidden">
                    {{ $pesanan->links() }}
                </div>

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
                                Pembayaran
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 sm:px-6">
                                Status Laundry
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 sm:px-6">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @foreach($pesanan as $transaction)

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

                            <tr class="transition hover:bg-gray-50">

                                {{-- Invoice --}}
                                <td class="whitespace-nowrap px-4 py-3 sm:px-6 sm:py-4">

                                    <span class="text-sm font-semibold text-gray-800">
                                        {{ $transaction->invoice }}
                                    </span>

                                </td>


                                {{-- Tanggal --}}
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600 sm:px-6 sm:py-4">

                                    {{ $transaction->tanggal_masuk?->format('d/m/Y H:i') ?? '-' }}

                                </td>


                                {{-- Berat --}}
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600 sm:px-6 sm:py-4">

                                    {{ number_format($transaction->total_berat, 2, ',', '.') }} kg

                                </td>


                                {{-- Total --}}
                                <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-800 sm:px-6 sm:py-4">

                                    Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}

                                </td>


                                {{-- Pembayaran --}}
                                <td class="whitespace-nowrap px-4 py-3 sm:px-6 sm:py-4">

                                    @if($transaction->status_pembayaran === 'dibayar')

                                        <span class="inline-flex whitespace-nowrap rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                            Dibayar
                                        </span>

                                    @elseif($transaction->status_pembayaran === 'dibatalkan')

                                        <span class="inline-flex whitespace-nowrap rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                            Dibatalkan
                                        </span>

                                    @else

                                        <span class="inline-flex whitespace-nowrap rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                                            Belum Bayar
                                        </span>

                                    @endif

                                </td>


                                {{-- Status Laundry --}}
                                <td class="whitespace-nowrap px-4 py-3 sm:px-6 sm:py-4">

                                    <span class="inline-flex whitespace-nowrap rounded-full px-3 py-1 text-xs font-medium {{ $statusClass[$transaction->status_laundry] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $statusLabel[$transaction->status_laundry] ?? $transaction->status_laundry }}
                                    </span>

                                </td>


                                {{-- Aksi --}}
                                <td class="whitespace-nowrap px-4 py-3 sm:px-6 sm:py-4">

                                    <a
                                        href="{{ route('pelanggan.orders.show', $transaction) }}"
                                        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50"
                                    >
                                        Detail
                                    </a>

                                    @if($transaction->payment?->status === 'pending')

                                        <a
                                            href="{{ route('pelanggan.payments.show', $transaction->payment) }}"
                                            class="ml-2 inline-flex items-center rounded-lg bg-blue-600 px-3 py-2 text-xs font-medium text-white transition hover:bg-blue-700"
                                        >
                                            Bayar
                                        </a>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

                <div class="mt-6">
                    {{ $pesanan->links() }}
                </div>

            </div>

        @else

            <div class="p-6 text-center sm:p-10">

                <h2 class="text-lg font-semibold text-gray-800">
                    Belum Ada Pesanan
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Kamu belum memiliki pesanan laundry.
                </p>

                <a
                    href="{{ route('pelanggan.orders.create') }}"
                    class="mt-5 inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700"
                >
                    Buat Pesanan
                </a>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     SEARCH INVOICE - MOBILE ONLY
     ========================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const searchInput = document.getElementById('searchInvoice');
        const clearButton = document.getElementById('clearSearch');
        const resultText = document.getElementById('searchResult');
        const noResult = document.getElementById('noSearchResult');
        const orderCards = document.querySelectorAll('.order-card');


        function searchOrders() {

            const keyword = searchInput.value.trim().toLowerCase();

            let visibleCount = 0;


            orderCards.forEach(function (card) {

                const invoice =
                    card.dataset.invoice.toLowerCase();

                const isMatch =
                    invoice.includes(keyword);


                if (isMatch) {

                    card.classList.remove('hidden');

                    visibleCount++;

                } else {

                    card.classList.add('hidden');

                }

            });


            if (keyword !== '') {

                clearButton.classList.remove('hidden');
                clearButton.classList.add('flex');

                resultText.classList.remove('hidden');

                resultText.textContent =
                    visibleCount + ' pesanan ditemukan.';

            } else {

                clearButton.classList.add('hidden');
                clearButton.classList.remove('flex');

                resultText.classList.add('hidden');
                resultText.textContent = '';

            }


            if (visibleCount === 0) {

                noResult.classList.remove('hidden');

            } else {

                noResult.classList.add('hidden');

            }

        }


        searchInput.addEventListener('input', searchOrders);


        clearButton.addEventListener('click', function () {

            searchInput.value = '';

            searchOrders();

            searchInput.focus();

        });

    });
</script>

@endsection
