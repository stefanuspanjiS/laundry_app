@extends('layouts.pelanggan')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Pembayaran
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Lihat pembayaran pesanan laundry kamu.
        </p>
    </div>


    <div class="rounded-xl border border-gray-100 bg-white shadow-sm">

        @if($pembayaran->count() > 0)

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Invoice
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Jumlah
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Metode
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Status
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Tanggal
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @foreach($pembayaran as $payment)

                            <tr class="hover:bg-gray-50">

                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-800">
                                    {{ $payment->transaction?->invoice ?? '-' }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-800">
                                    Rp {{ number_format($payment->jumlah, 0, ',', '.') }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                    {{ strtoupper($payment->metode ?? '-') }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">

                                    @if($payment->status === 'success')

                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                            Berhasil
                                        </span>

                                    @elseif($payment->status === 'pending')

                                        <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">
                                            Menunggu
                                        </span>

                                    @elseif($payment->status === 'failed')

                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">
                                            Gagal
                                        </span>

                                    @elseif($payment->status === 'expire')

                                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                            Expired
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                            {{ ucfirst($payment->status) }}
                                        </span>

                                    @endif

                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                    {{ $payment->created_at?->format('d/m/Y H:i') ?? '-' }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="p-10 text-center">

                <h2 class="text-lg font-semibold text-gray-800">
                    Belum Ada Pembayaran
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Pembayaran pesanan kamu akan muncul di sini.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection
