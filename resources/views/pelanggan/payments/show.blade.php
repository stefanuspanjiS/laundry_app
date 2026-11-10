@extends('layouts.pelanggan')

@section('content')

<div class="mx-auto max-w-3xl space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Pembayaran
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Pilih metode pembayaran untuk pesanan kamu.
        </p>
    </div>


    {{-- Ringkasan --}}
    <div class="rounded-xl border border-gray-100 bg-white shadow-sm">

        <div class="border-b border-gray-100 px-6 py-5">

            <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                Invoice
            </p>

            <p class="mt-1 text-lg font-bold text-gray-800">
                {{ $payment->transaction?->invoice }}
            </p>

        </div>


        <div class="p-6">

            <div class="flex justify-between">

                <span class="text-sm text-gray-500">
                    Total Pembayaran
                </span>

                <span class="text-xl font-bold text-blue-600">
                    Rp {{ number_format($payment->jumlah, 0, ',', '.') }}
                </span>

            </div>


            <div class="mt-4 flex justify-between">

                <span class="text-sm text-gray-500">
                    Status
                </span>

                <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                    Pending
                </span>

            </div>

        </div>

    </div>


    {{-- Pilihan Metode --}}
    @if($payment->status === 'pending')

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

            {{-- Cash --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100">

                    <svg
                        class="h-6 w-6 text-gray-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2m4-6h-6m0 0l2-2m-2 2l2 2"
                        />
                    </svg>

                </div>


                <h2 class="mt-4 text-lg font-semibold text-gray-800">
                    Cash
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Pembayaran dilakukan secara langsung kepada kasir.
                </p>


                <a
                    href="{{ route('pelanggan.payments.cash', $payment) }}"
                    class="mt-5 inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Pilih Cash
                </a>

            </div>


            {{-- Midtrans --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100">

                    <svg
                        class="h-6 w-6 text-gray-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 10h18M7 15h1m3 0h2m-8 4h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                        />
                    </svg>

                </div>


                <h2 class="mt-4 text-lg font-semibold text-gray-800">
                    Midtrans
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Bayar secara online menggunakan metode pembayaran yang tersedia.
                </p>


                <a
                    href="{{ route('pelanggan.payments.midtrans', $payment) }}"
                    class="mt-5 inline-flex w-full items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700"
                >
                    Bayar dengan Midtrans
                </a>

            </div>

        </div>

    @else

        <div class="rounded-xl border border-gray-100 bg-white p-6 text-center shadow-sm">

            <p class="text-sm text-gray-500">
                Pembayaran ini sudah tidak berada dalam status pending.
            </p>

        </div>

    @endif


    <div>

        <a
            href="{{ route('pelanggan.orders.show', $payment->transaction) }}"
            class="text-sm font-medium text-gray-600 hover:text-gray-800"
        >
            ← Kembali ke Detail Pesanan
        </a>

    </div>

</div>

@endsection
