@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-2">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
            Pembayaran
        </h1>

        <p class="text-sm text-gray-500">
            Kelola dan pantau pembayaran transaksi laundry.
        </p>
    </div>


    {{-- Flash Message --}}
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3">
            <p class="text-sm text-green-700">
                {{ session('success') }}
            </p>
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3">
            <p class="text-sm text-red-700">
                {{ session('error') }}
            </p>
        </div>
    @endif


    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5">

        <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-5">
            <p class="text-sm text-gray-500">
                Pembayaran Berhasil
            </p>

            <p class="text-2xl font-bold text-gray-900 mt-2">
                {{ $pembayaranBerhasil }}
            </p>
        </div>


        <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-5">
            <p class="text-sm text-gray-500">
                Menunggu Pembayaran
            </p>

            <p class="text-2xl font-bold text-gray-900 mt-2">
                {{ $menungguPembayaran }}
            </p>
        </div>


        <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-5">
            <p class="text-sm text-gray-500">
                Pembayaran Gagal
            </p>

            <p class="text-2xl font-bold text-gray-900 mt-2">
                {{ $pembayaranGagal }}
            </p>
        </div>


        <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-5">
            <p class="text-sm text-gray-500">
                Total Pendapatan
            </p>

            <p class="text-2xl font-bold text-gray-900 mt-2 break-words">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </p>
        </div>

    </div>


    {{-- Filter --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-5">

        <form
            action="{{ route('admin.payments.index') }}"
            method="GET"
            class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4"
        >

            <div class="xl:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Cari
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Invoice / nama pelanggan"
                    class="w-full rounded-xl border-gray-300
                           focus:border-gray-500 focus:ring-gray-500"
                >
            </div>


            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full rounded-xl border-gray-300
                           focus:border-gray-500 focus:ring-gray-500"
                >
                    <option value="">Semua</option>

                    <option
                        value="pending"
                        {{ request('status') === 'pending' ? 'selected' : '' }}
                    >
                        Pending
                    </option>

                    <option
                        value="success"
                        {{ request('status') === 'success' ? 'selected' : '' }}
                    >
                        Success
                    </option>

                    <option
                        value="failed"
                        {{ request('status') === 'failed' ? 'selected' : '' }}
                    >
                        Failed
                    </option>

                    <option
                        value="expire"
                        {{ request('status') === 'expire' ? 'selected' : '' }}
                    >
                        Expired
                    </option>
                </select>
            </div>


            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Metode
                </label>

                <select
                    name="metode"
                    class="w-full rounded-xl border-gray-300
                           focus:border-gray-500 focus:ring-gray-500"
                >
                    <option value="">Semua</option>

                    <option
                        value="cash"
                        {{ request('metode') === 'cash' ? 'selected' : '' }}
                    >
                        Cash
                    </option>

                    <option
                        value="midtrans"
                        {{ request('metode') === 'midtrans' ? 'selected' : '' }}
                    >
                        Midtrans
                    </option>
                </select>
            </div>


            <div class="flex flex-col sm:flex-row md:items-end gap-2">

                <button
                    type="submit"
                    class="w-full sm:w-auto flex-1
                           px-4 py-2.5 rounded-xl bg-gray-900
                           text-white text-sm font-medium
                           hover:bg-gray-800"
                >
                    Cari
                </button>

                <a
                    href="{{ route('admin.payments.index') }}"
                    class="w-full sm:w-auto flex-1
                           text-center px-4 py-2.5 rounded-xl
                           border border-gray-300
                           text-sm font-medium text-gray-700
                           hover:bg-gray-50"
                >
                    Reset
                </a>

            </div>


            <div class="md:col-span-2 xl:col-span-5
                        grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Dari Tanggal
                    </label>

                    <input
                        type="date"
                        name="dari_tanggal"
                        value="{{ request('dari_tanggal') }}"
                        class="w-full rounded-xl border-gray-300
                               focus:border-gray-500 focus:ring-gray-500"
                    >
                </div>


                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Sampai Tanggal
                    </label>

                    <input
                        type="date"
                        name="sampai_tanggal"
                        value="{{ request('sampai_tanggal') }}"
                        class="w-full rounded-xl border-gray-300
                               focus:border-gray-500 focus:ring-gray-500"
                    >
                </div>

            </div>

        </form>

    </div>


    {{-- Tabel --}}
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">

        <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-200">
            <h2 class="font-semibold text-gray-900">
                Riwayat Pembayaran
            </h2>
        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[850px] text-sm">

                <thead class="bg-gray-50 border-b border-gray-200">

                    <tr>

                        <th class="text-left px-4 sm:px-6 py-3 sm:py-4 font-semibold text-gray-600">
                            Invoice
                        </th>

                        <th class="text-left px-4 sm:px-6 py-3 sm:py-4 font-semibold text-gray-600">
                            Pelanggan
                        </th>

                        <th class="text-left px-4 sm:px-6 py-3 sm:py-4 font-semibold text-gray-600">
                            Tanggal
                        </th>

                        <th class="text-left px-4 sm:px-6 py-3 sm:py-4 font-semibold text-gray-600">
                            Metode
                        </th>

                        <th class="text-right px-4 sm:px-6 py-3 sm:py-4 font-semibold text-gray-600">
                            Jumlah
                        </th>

                        <th class="text-center px-4 sm:px-6 py-3 sm:py-4 font-semibold text-gray-600">
                            Status
                        </th>

                        <th class="text-center px-4 sm:px-6 py-3 sm:py-4 font-semibold text-gray-600">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($payments as $payment)

                        <tr class="hover:bg-gray-50">

                            <td class="px-4 sm:px-6 py-3 sm:py-4 font-medium text-gray-900">
                                {{ $payment->transaction->invoice }}
                            </td>

                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-gray-700">
                                {{ $payment->transaction->customer->name }}
                            </td>

                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-gray-600 whitespace-nowrap">
                                {{ $payment->created_at->format('d M Y') }}
                            </td>

                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-gray-600 capitalize">
                                {{ $payment->metode }}
                            </td>

                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-right font-medium text-gray-900 whitespace-nowrap">
                                Rp {{ number_format($payment->jumlah, 0, ',', '.') }}
                            </td>

                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">

                                @if($payment->status === 'success')

                                    <span class="inline-flex px-3 py-1 rounded-full
                                                 bg-green-100 text-green-700
                                                 text-xs font-medium whitespace-nowrap">
                                        Berhasil
                                    </span>

                                @elseif($payment->status === 'pending')

                                    <span class="inline-flex px-3 py-1 rounded-full
                                                 bg-yellow-100 text-yellow-700
                                                 text-xs font-medium whitespace-nowrap">
                                        Pending
                                    </span>

                                @elseif($payment->status === 'failed')

                                    <span class="inline-flex px-3 py-1 rounded-full
                                                 bg-red-100 text-red-700
                                                 text-xs font-medium whitespace-nowrap">
                                        Gagal
                                    </span>

                                @else

                                    <span class="inline-flex px-3 py-1 rounded-full
                                                 bg-gray-100 text-gray-700
                                                 text-xs font-medium whitespace-nowrap">
                                        Expired
                                    </span>

                                @endif

                            </td>


                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">

                                <a
                                    href="{{ route('admin.payments.show', $payment) }}"
                                    class="inline-flex items-center justify-center
                                           px-3 py-1.5 rounded-lg
                                           text-sm font-medium text-gray-700
                                           hover:bg-gray-100 hover:text-gray-900
                                           transition"
                                >
                                    Detail
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                Belum ada data pembayaran.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if ($payments->hasPages())
            <div class="border-t border-gray-200 px-4 sm:px-6 py-4">
                {{ $payments->links() }}
            </div>
        @endif

    </div>

</div>

@endsection
