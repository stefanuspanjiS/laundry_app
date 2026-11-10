@extends('layouts.pelanggan')

@section('content')

<div class="mx-auto w-full min-w-0 max-w-4xl space-y-5 sm:space-y-6">

    {{-- Header --}}
    <div class="min-w-0">
        <h1 class="text-xl font-bold text-gray-800 sm:text-2xl">
            Pesanan Berhasil Dibuat
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Berikut detail pesanan laundry kamu.
        </p>
    </div>


    {{-- Success --}}
    @if(session('success'))

        <div class="w-full min-w-0 rounded-lg border border-green-200 bg-green-50 p-4">

            <p class="break-words text-sm font-medium text-green-700">
                {{ session('success') }}
            </p>

        </div>

    @endif


    {{-- Detail Pesanan --}}
    <div class="w-full min-w-0 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">

        {{-- Header --}}
        <div class="border-b border-gray-100 px-4 py-4 sm:px-6 sm:py-5">

            <div class="flex min-w-0 flex-col justify-between gap-3 sm:flex-row sm:items-center">

                <div class="min-w-0">

                    <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                        Invoice
                    </p>

                    <h2 class="mt-1 break-all text-lg font-bold text-gray-800 sm:text-xl">
                        {{ $transaction->invoice }}
                    </h2>

                </div>


                {{-- Status Laundry --}}
                <span class="inline-flex w-fit max-w-full shrink-0 whitespace-nowrap rounded-full bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700">
                    {{ str_replace('_', ' ', ucfirst($transaction->status_laundry)) }}
                </span>

            </div>

        </div>


        {{-- Detail --}}
        <div class="w-full min-w-0 p-4 sm:p-6">

            <div class="min-w-0 space-y-4">

                @foreach($transaction->details as $detail)

                    <div class="flex min-w-0 flex-col justify-between gap-3 rounded-lg border border-gray-100 bg-gray-50 p-4 sm:flex-row">

                        <div class="min-w-0">

                            <p class="break-words font-semibold text-gray-800">
                                {{ $detail->package?->nama_paket ?? '-' }}
                            </p>

                            <p class="mt-1 break-words text-sm text-gray-500">
                                {{ number_format($detail->berat, 2, ',', '.') }} kg
                                ×
                                Rp {{ number_format($detail->harga, 0, ',', '.') }}/kg
                            </p>

                        </div>


                        <div class="shrink-0 text-left font-semibold text-gray-800 sm:text-right">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </div>

                    </div>

                @endforeach

            </div>


            {{-- Ringkasan Harga --}}
            <div class="mt-6 border-t border-gray-200 pt-5">

                <div class="flex min-w-0 items-center justify-between gap-4 text-sm">

                    <span class="shrink-0 text-gray-500">
                        Subtotal
                    </span>

                    <span class="min-w-0 break-words text-right font-medium text-gray-800">
                        Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}
                    </span>

                </div>


                <div class="mt-3 flex min-w-0 items-center justify-between gap-4 text-sm">

                    <span class="shrink-0 text-gray-500">
                        Diskon
                    </span>

                    <span class="min-w-0 break-words text-right font-medium text-gray-800">
                        Rp {{ number_format($transaction->diskon, 0, ',', '.') }}
                    </span>

                </div>


                <div class="mt-4 flex min-w-0 items-start justify-between gap-4 border-t border-gray-200 pt-4">

                    <span class="min-w-0 text-base font-semibold text-gray-800 sm:text-lg">
                        Total Pembayaran
                    </span>

                    <span class="min-w-0 break-words text-right text-lg font-bold text-blue-600 sm:text-xl">
                        Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}
                    </span>

                </div>

            </div>

        </div>


        {{-- Payment --}}
        <div class="border-t border-gray-100 bg-gray-50 px-4 py-4 sm:px-6 sm:py-5">

            <div class="flex min-w-0 flex-col justify-between gap-4 sm:flex-row sm:items-center">

                <div class="min-w-0">

                    <p class="text-sm font-medium text-gray-700">
                        Status Pembayaran
                    </p>

                    @if($transaction->payment?->status === 'pending')

                        <span class="mt-1 inline-flex whitespace-nowrap rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                            Menunggu Pembayaran
                        </span>

                    @elseif($transaction->payment?->status === 'success')

                        <span class="mt-1 inline-flex whitespace-nowrap rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                            Pembayaran Berhasil
                        </span>

                    @elseif($transaction->payment?->status === 'failed')

                        <span class="mt-1 inline-flex whitespace-nowrap rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                            Pembayaran Gagal
                        </span>

                    @elseif($transaction->payment?->status === 'expire')

                        <span class="mt-1 inline-flex whitespace-nowrap rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                            Pembayaran Expired
                        </span>

                    @else

                        <span class="mt-1 inline-flex whitespace-nowrap rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                            Belum Ada Pembayaran
                        </span>

                    @endif

                </div>


                {{-- Bayar Sekarang --}}
                @if($transaction->payment?->status === 'pending')

                    <a
                        href="{{ route('pelanggan.payments.show', $transaction->payment) }}"
                        class="inline-flex w-full shrink-0 items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700 sm:w-auto"
                    >
                        Bayar Sekarang
                    </a>

                @endif

            </div>

        </div>


        {{-- Status Pesanan --}}
        <div class="w-full min-w-0 rounded-xl border border-gray-100 bg-white shadow-sm">

            <div class="border-b border-gray-100 px-4 py-4 sm:px-6">

                <h2 class="text-lg font-semibold text-gray-800">
                    Status Pesanan
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Riwayat proses laundry pesanan kamu.
                </p>

            </div>


            <div class="w-full min-w-0 px-4 py-5 sm:px-6 sm:py-6">

                @if($transaction->laundryStatuses->count() > 0)

                    <div class="relative min-w-0">

                        @foreach($transaction->laundryStatuses->sortByDesc('created_at') as $status)

                            @php
                                $statusLabel = [
                                    'menunggu' => 'Menunggu',
                                    'dicuci' => 'Dicuci',
                                    'dikeringkan' => 'Dikeringkan',
                                    'disetrika' => 'Disetrika',
                                    'siap_diambil' => 'Siap Diambil',
                                    'selesai' => 'Selesai',
                                ];

                                $statusDot = [
                                    'menunggu' => 'bg-gray-400',
                                    'dicuci' => 'bg-blue-500',
                                    'dikeringkan' => 'bg-purple-500',
                                    'disetrika' => 'bg-orange-500',
                                    'siap_diambil' => 'bg-cyan-500',
                                    'selesai' => 'bg-emerald-500',
                                ];

                                $label = $statusLabel[$status->status]
                                    ?? ucwords(str_replace('_', ' ', $status->status));

                                $dot = $statusDot[$status->status]
                                    ?? 'bg-gray-400';
                            @endphp


                            <div class="relative flex min-w-0 gap-3 sm:gap-4">

                                {{-- Garis timeline --}}
                                @if(!$loop->last)
                                    <div class="absolute left-[7px] top-4 h-full w-px bg-gray-200"></div>
                                @endif


                                {{-- Titik --}}
                                <div class="relative z-10 flex shrink-0">

                                    <div
                                        class="h-4 w-4 rounded-full border-2 border-white shadow-sm {{ $dot }}"
                                    ></div>

                                </div>


                                {{-- Informasi Status --}}
                                <div class="min-w-0 {{ !$loop->last ? 'pb-7' : '' }}">

                                    <p class="break-words text-sm font-semibold text-gray-800">
                                        @if($loop->last && $status->status === 'menunggu')
                                            Pesanan Dibuat
                                        @else
                                            {{ $label }}
                                        @endif
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $status->created_at?->translatedFormat('d M Y, H:i') ?? '-' }}
                                    </p>

                                    @if($status->keterangan)

                                        <p class="mt-2 break-words text-sm text-gray-600">
                                            {{ $status->keterangan }}
                                        </p>

                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="py-6 text-center">

                        <p class="text-sm text-gray-500">
                            Belum ada riwayat status pesanan.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- Back --}}
    <div>

        <a
            href="{{ route('pelanggan.orders.index') }}"
            class="inline-flex max-w-full text-sm font-medium text-gray-600 hover:text-gray-800"
        >
            ← Kembali ke Pesanan Saya
        </a>

    </div>

</div>

@endsection
