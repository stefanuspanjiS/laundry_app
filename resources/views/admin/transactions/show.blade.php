@extends('layouts.admin')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">

        <div class="min-w-0">
            <p class="text-sm text-gray-500 mb-1">
                Detail Transaksi
            </p>

            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 break-all">
                {{ $transaction->invoice }}
            </h2>
        </div>

        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">

            <a href="{{ route('admin.transactions.status.edit', $transaction) }}"
                class="w-full sm:w-auto px-4 py-2.5 rounded-xl
                bg-gray-900 text-white
                text-sm font-medium text-center
                hover:bg-gray-800">
                Update Status
            </a>

            {{-- Bayar Sekarang --}}
            @if($transaction->status_pembayaran === 'belum_bayar')

                <a
                    href="{{ route('admin.transactions.payment.cash', $transaction) }}"
                    class="w-full sm:w-auto px-4 py-2.5 rounded-xl
                        bg-green-600 text-white
                        text-sm font-medium text-center
                        hover:bg-green-700"
                >
                    Bayar Cash
                </a>

            @endif

            <a
                href="{{ route(
                    'admin.transactions.edit',
                    $transaction
                ) }}"
                class="w-full sm:w-auto px-4 py-2.5 rounded-xl
                    bg-gray-900 text-white
                    text-sm font-medium text-center"
            >
                Edit
            </a>

            <a
                href="{{ route(
                    'admin.transactions.index'
                ) }}"
                class="w-full sm:w-auto px-4 py-2.5 rounded-xl
                    border border-gray-200
                    text-sm text-center"
            >
                Kembali
            </a>

        </div>

    </div>


    {{-- Success --}}
    @if(session('success'))

        <div class="mb-6 rounded-xl
                    border border-green-200
                    bg-green-50 px-4 py-3">

            <p class="text-sm
                      font-medium
                      text-green-700">
                {{ session('success') }}
            </p>

        </div>

    @endif


    {{-- Error --}}
    @if(session('error'))

        <div class="mb-6 rounded-xl
                    border border-red-200
                    bg-red-50 px-4 py-3">

            <p class="text-sm
                      font-medium
                      text-red-700">
                {{ session('error') }}
            </p>

        </div>

    @endif


    <div class="grid grid-cols-1 lg:grid-cols-3
                gap-5 sm:gap-6">

        {{-- Main --}}
        <div class="lg:col-span-2 space-y-5 sm:space-y-6">

            {{-- Customer --}}
            <div class="bg-white rounded-2xl
                        border border-gray-200
                        shadow-sm p-4 sm:p-6">

                <h3 class="font-semibold
                           text-gray-900 mb-5">
                    Informasi Transaksi
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <div>
                        <p class="text-xs
                                  text-gray-500">
                            Pelanggan
                        </p>

                        <p class="font-medium
                                  text-gray-900 mt-1
                                  break-words">
                            {{ $transaction
                                ->customer
                                ->name }}
                        </p>
                    </div>


                    <div>
                        <p class="text-xs
                                  text-gray-500">
                            Kasir
                        </p>

                        <p class="font-medium
                                  text-gray-900 mt-1
                                  break-words">
                            {{ $transaction->cashier?->name ?? 'Belum ditangani kasir' }}
                        </p>
                    </div>


                    <div>
                        <p class="text-xs
                                  text-gray-500">
                            Tanggal Masuk
                        </p>

                        <p class="font-medium
                                  text-gray-900 mt-1">
                            {{ $transaction
                                ->tanggal_masuk
                                ->format('d M Y') }}
                        </p>
                    </div>


                    <div>
                        <p class="text-xs
                                  text-gray-500">
                            Tanggal Selesai
                        </p>

                        <p class="font-medium
                                  text-gray-900 mt-1">

                            @if($transaction->tanggal_selesai)

                                {{ $transaction
                                    ->tanggal_selesai
                                    ->format('d M Y') }}

                            @else

                                -

                            @endif

                        </p>
                    </div>

                </div>

            </div>


            {{-- Details --}}
            <div class="bg-white rounded-2xl
                        border border-gray-200
                        shadow-sm overflow-hidden">

                <div class="p-4 sm:p-6 border-b
                            border-gray-100">

                    <h3 class="font-semibold
                               text-gray-900">
                        Detail Laundry
                    </h3>

                </div>


                <div class="divide-y
                            divide-gray-100">

                    @foreach(
                        $transaction->details
                        as $detail
                    )

                        <div class="p-4 sm:p-5
                                    flex items-start
                                    justify-between
                                    gap-4">

                            <div class="min-w-0">

                                <p class="font-medium
                                          text-gray-900
                                          break-words">
                                    {{ $detail
                                        ->package
                                        ->nama_paket }}
                                </p>

                                <p class="text-sm
                                          text-gray-500 mt-1">
                                    {{ $detail->berat }} kg
                                    ×
                                    Rp {{ number_format(
                                        $detail->harga,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </p>

                            </div>


                            <p class="font-semibold
                                      text-gray-900
                                      whitespace-nowrap">

                                Rp {{ number_format(
                                    $detail->subtotal,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </p>

                        </div>

                    @endforeach

                </div>

            </div>


            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 sm:p-6">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">

                    <div>
                        <h3 class="font-semibold text-gray-900">
                            Riwayat Status Laundry
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Perjalanan laundry dari awal hingga selesai.
                        </p>
                    </div>

                    <a
                        href="{{ route(
                            'admin.transactions.status.edit',
                            $transaction
                        ) }}"
                        class="text-sm font-medium
                            text-gray-700
                            hover:text-gray-900
                            shrink-0"
                    >
                        Update Status →
                    </a>

                </div>


                <div class="space-y-6">

                    @forelse(
                        $transaction->laundryStatuses
                        ->sortByDesc('created_at')
                        as $history
                    )

                        <div class="relative pl-8">

                            <div class="absolute left-0 top-1
                                        w-3 h-3 rounded-full
                                        bg-gray-900
                                        ring-4 ring-gray-100">
                            </div>

                            @if(!$loop->last)

                                <div class="absolute
                                            left-[5px]
                                            top-4
                                            bottom-[-24px]
                                            w-px bg-gray-200">
                                </div>

                            @endif


                            <div class="flex flex-col gap-2 sm:flex-row
                                        sm:items-start
                                        sm:justify-between
                                        sm:gap-4">

                                <div class="min-w-0">

                                    <p class="font-medium
                                              text-gray-900">

                                        {{ ucwords(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $history->status
                                            )
                                        ) }}

                                    </p>

                                    @if($history->keterangan)

                                        <p class="text-sm
                                                  text-gray-500 mt-1
                                                  break-words">

                                            {{ $history->keterangan }}

                                        </p>

                                    @endif

                                    <p class="text-xs
                                              text-gray-400 mt-2">

                                        Oleh
                                        {{ $history->updater->name
                                            ?? 'System' }}

                                    </p>

                                </div>


                                <span class="text-xs
                                            text-gray-400
                                            whitespace-nowrap">

                                    {{ $history->created_at
                                        ->format('d M Y H:i') }}

                                </span>

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


        {{-- Sidebar --}}
        <div class="space-y-5 sm:space-y-6">

            {{-- Status --}}
            <div class="bg-white rounded-2xl
                        border border-gray-200
                        shadow-sm p-4 sm:p-6">

                <h3 class="font-semibold
                           text-gray-900 mb-5">
                    Status
                </h3>


                <div class="space-y-4">

                    <div>

                        <p class="text-xs text-gray-500">
                            Laundry
                        </p>

                        <span class="inline-flex mt-2
                                     px-3 py-1.5
                                     rounded-full
                                     bg-gray-100
                                     text-gray-700
                                     text-xs font-medium
                                     whitespace-nowrap">

                            {{ ucwords(
                                str_replace(
                                    '_',
                                    ' ',
                                    $transaction
                                        ->status_laundry
                                )
                            ) }}

                        </span>

                    </div>


                    <div>

                        <p class="text-xs text-gray-500">
                            Pembayaran
                        </p>

                        <span class="inline-flex mt-2
                                     px-3 py-1.5
                                     rounded-full
                                     text-xs font-medium
                                     whitespace-nowrap
                                     {{ $transaction
                                         ->status_pembayaran
                                         === 'dibayar'
                                         ? 'bg-green-100 text-green-700'
                                         : 'bg-yellow-100 text-yellow-700' }}">

                            {{ $transaction
                                ->status_pembayaran
                                === 'dibayar'
                                ? 'Dibayar'
                                : 'Belum Bayar' }}

                        </span>

                    </div>

                </div>

            </div>


            {{-- Total --}}
            <div class="bg-gray-900
                        text-white
                        rounded-2xl
                        p-4 sm:p-6">

                <h3 class="font-semibold mb-5">
                    Ringkasan Pembayaran
                </h3>


                <div class="space-y-3 text-sm">

                    <div class="flex justify-between gap-4">

                        <span class="text-gray-400">
                            Total Berat
                        </span>

                        <span class="whitespace-nowrap">
                            {{ $transaction->total_berat }}
                            kg
                        </span>

                    </div>


                    <div class="flex justify-between gap-4">

                        <span class="text-gray-400">
                            Subtotal
                        </span>

                        <span class="whitespace-nowrap">
                            Rp {{ number_format(
                                $transaction->subtotal,
                                0,
                                ',',
                                '.'
                            ) }}
                        </span>

                    </div>


                    <div class="flex justify-between gap-4">

                        <span class="text-gray-400">
                            Diskon
                        </span>

                        <span class="whitespace-nowrap">
                            Rp {{ number_format(
                                $transaction->diskon,
                                0,
                                ',',
                                '.'
                            ) }}
                        </span>

                    </div>


                    <div class="border-t
                                border-gray-700
                                pt-4
                                flex justify-between
                                gap-4">

                        <span class="text-gray-400">
                            Total
                        </span>

                        <span class="text-xl font-bold
                                     text-right
                                     break-words">

                            Rp {{ number_format(
                                $transaction->total_bayar,
                                0,
                                ',',
                                '.'
                            ) }}

                        </span>

                    </div>

                </div>

            </div>


            {{-- Delete --}}
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
                    onsubmit="return confirm(
                        'Yakin ingin menghapus transaksi ini?'
                    )"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="w-full px-4 py-3
                               rounded-xl
                               border border-red-200
                               text-red-600
                               text-sm font-medium
                               hover:bg-red-50"
                    >
                        Hapus Transaksi
                    </button>

                </form>

            @endif

        </div>

    </div>

</div>

@endsection
