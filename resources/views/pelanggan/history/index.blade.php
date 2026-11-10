@extends('layouts.pelanggan')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">
            Riwayat
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Lihat riwayat pesanan laundry yang telah selesai.
        </p>
    </div>


    <div class="rounded-xl border border-gray-100 bg-white shadow-sm">

        @if($riwayat->count() > 0)

            <div class="overflow-x-auto">

                <table class="min-w-[750px]">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Invoice
                            </th>

                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Tanggal Masuk
                            </th>

                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Tanggal Selesai
                            </th>

                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Berat
                            </th>

                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Total
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @foreach($riwayat as $transaction)

                            <tr class="hover:bg-gray-50">

                                <td class="whitespace-nowrap px-4 sm:px-6 py-3 sm:py-4 text-sm font-semibold text-gray-800">
                                    {{ $transaction->invoice }}
                                </td>

                                <td class="whitespace-nowrap px-4 sm:px-6 py-3 sm:py-4 text-sm text-gray-600">
                                    {{ $transaction->tanggal_masuk?->format('d/m/Y') ?? '-' }}
                                </td>

                                <td class="whitespace-nowrap px-4 sm:px-6 py-3 sm:py-4 text-sm text-gray-600">
                                    {{ $transaction->tanggal_selesai?->format('d/m/Y') ?? '-' }}
                                </td>

                                <td class="whitespace-nowrap px-4 sm:px-6 py-3 sm:py-4 text-sm text-gray-600">
                                    {{ number_format($transaction->total_berat, 2, ',', '.') }} kg
                                </td>

                                <td class="whitespace-nowrap px-4 sm:px-6 py-3 sm:py-4 text-sm font-medium text-gray-800">
                                    Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="p-6 sm:p-10 text-center">

                <h2 class="text-lg font-semibold text-gray-800">
                    Belum Ada Riwayat
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Pesanan yang sudah selesai akan muncul di sini.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection
