@extends('layouts.admin')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="min-w-0">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
                Detail Pembayaran
            </h1>

            <p class="text-sm text-gray-500 mt-1 break-all">
                {{ $payment->transaction->invoice }}
            </p>
        </div>

        <a
            href="{{ route('admin.payments.index') }}"
            class="w-full sm:w-auto inline-flex items-center justify-center
                   px-4 py-2.5 rounded-xl border border-gray-300
                   text-sm font-medium text-gray-700
                   hover:bg-gray-50"
        >
            Kembali
        </a>

    </div>


    {{-- Success --}}
    @if(session('success'))

        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3">
            <p class="text-sm text-green-700">
                {{ session('success') }}
            </p>
        </div>

    @endif


    {{-- Detail --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

        {{-- Pembayaran --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6">

            <h2 class="font-semibold text-gray-900 mb-5">
                Informasi Pembayaran
            </h2>

            <div class="space-y-5">

                <div>
                    <p class="text-xs text-gray-500">
                        Invoice
                    </p>

                    <p class="font-medium text-gray-900 mt-1 break-all">
                        {{ $payment->transaction->invoice }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">
                        Metode
                    </p>

                    <p class="font-medium text-gray-900 mt-1 capitalize">
                        {{ $payment->metode }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">
                        Jumlah
                    </p>

                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1 break-words">
                        Rp {{ number_format($payment->jumlah, 0, ',', '.') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">
                        Status
                    </p>

                    @if($payment->status === 'success')

                        <span class="inline-flex mt-1 px-3 py-1 rounded-full
                                     bg-green-100 text-green-700
                                     text-xs font-medium">
                            Berhasil
                        </span>

                    @elseif($payment->status === 'pending')

                        <span class="inline-flex mt-1 px-3 py-1 rounded-full
                                     bg-yellow-100 text-yellow-700
                                     text-xs font-medium">
                            Pending
                        </span>

                    @elseif($payment->status === 'failed')

                        <span class="inline-flex mt-1 px-3 py-1 rounded-full
                                     bg-red-100 text-red-700
                                     text-xs font-medium">
                            Gagal
                        </span>

                    @else

                        <span class="inline-flex mt-1 px-3 py-1 rounded-full
                                     bg-gray-100 text-gray-700
                                     text-xs font-medium">
                            Expired
                        </span>

                    @endif
                </div>

                <div>
                    <p class="text-xs text-gray-500">
                        Dibayar Pada
                    </p>

                    <p class="font-medium text-gray-900 mt-1">
                        {{ $payment->paid_at?->format('d M Y H:i') ?? '-' }}
                    </p>
                </div>

            </div>

        </div>


        {{-- Transaksi --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-4 sm:p-6">

            <h2 class="font-semibold text-gray-900 mb-5">
                Informasi Transaksi
            </h2>

            <div class="space-y-5">

                <div>
                    <p class="text-xs text-gray-500">
                        Pelanggan
                    </p>

                    <p class="font-medium text-gray-900 mt-1 break-words">
                        {{ $payment->transaction->customer->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">
                        Total Berat
                    </p>

                    <p class="font-medium text-gray-900 mt-1">
                        {{ $payment->transaction->total_berat }} kg
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">
                        Subtotal
                    </p>

                    <p class="font-medium text-gray-900 mt-1 break-words">
                        Rp {{ number_format($payment->transaction->subtotal, 0, ',', '.') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">
                        Diskon
                    </p>

                    <p class="font-medium text-gray-900 mt-1 break-words">
                        Rp {{ number_format($payment->transaction->diskon, 0, ',', '.') }}
                    </p>
                </div>

                <div class="border-t border-gray-100 pt-4">

                    <p class="text-xs text-gray-500">
                        Total Bayar
                    </p>

                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-1 break-words">
                        Rp {{ number_format($payment->transaction->total_bayar, 0, ',', '.') }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Action --}}
    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

        {{-- Tombol Bayar Sekarang --}}
        @if(
            $payment->transaction?->status_pembayaran === 'belum_bayar'
            && $payment->status !== 'success'
        )

            <a
                href="{{ route(
                    'admin.payments.cash.create',
                    $payment->transaction
                ) }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                    px-4 py-2.5 rounded-xl
                    bg-green-600 text-white
                    text-sm font-medium
                    hover:bg-green-700
                    transition"
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
                        d="M12 8c-2.21 0-4 1.343-4 3s1.79 3 4 3 4 1.343 4 3-1.79 3-4 3m0-12V6m0 12v-2"
                    />
                </svg>

                Bayar Sekarang

            </a>

        @endif


        {{-- Tombol transaksi --}}
        <a
            href="{{ route('admin.transactions.show', $payment->transaction) }}"
            class="w-full sm:w-auto inline-flex items-center justify-center
                   px-4 py-2.5 rounded-xl bg-gray-900 text-white
                   text-sm font-medium hover:bg-gray-800"
        >
            Lihat Detail Transaksi
        </a>

    </div>

</div>

@endsection
