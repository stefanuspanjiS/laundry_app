@extends('layouts.kasir')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Pembayaran
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Kelola dan proses pembayaran pelanggan.
            </p>
        </div>

    </div>


    {{-- FILTER --}}
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

        <form
            method="GET"
            action="{{ route('kasir.payments.index') }}"
            class="grid grid-cols-1 gap-4 md:grid-cols-4"
        >

            {{-- Search --}}
            <div class="md:col-span-2">

                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Cari
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Invoice atau nama pelanggan..."
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
                >

            </div>


            {{-- Status --}}
            <div>

                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
                >

                    <option value="">
                        Semua Status
                    </option>

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
                        Berhasil
                    </option>

                    <option
                        value="failed"
                        {{ request('status') === 'failed' ? 'selected' : '' }}
                    >
                        Gagal
                    </option>

                    <option
                        value="expire"
                        {{ request('status') === 'expire' ? 'selected' : '' }}
                    >
                        Expired
                    </option>

                </select>

            </div>


            {{-- Metode --}}
            <div>

                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Metode
                </label>

                <select
                    name="metode"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
                >

                    <option value="">
                        Semua Metode
                    </option>

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


            <div class="md:col-span-4 flex gap-2">

                <button
                    type="submit"
                    class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
                >
                    Filter
                </button>

                <a
                    href="{{ route('kasir.payments.index') }}"
                    class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- TABLE --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b border-gray-200 bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 font-semibold text-gray-700">
                            Invoice
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700">
                            Pelanggan
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700">
                            Total
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700">
                            Metode
                        </th>

                        <th class="px-6 py-4 font-semibold text-gray-700">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right font-semibold text-gray-700">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse ($payments as $payment)

                        @php

                            $transaction = $payment->transaction;

                            $statusClass = match ($payment->status) {
                                'success' => 'bg-emerald-100 text-emerald-700',
                                'pending' => 'bg-amber-100 text-amber-700',
                                'failed' => 'bg-red-100 text-red-700',
                                'expire' => 'bg-gray-100 text-gray-700',
                                default => 'bg-gray-100 text-gray-700',
                            };

                            $statusLabel = match ($payment->status) {
                                'success' => 'Berhasil',
                                'pending' => 'Pending',
                                'failed' => 'Gagal',
                                'expire' => 'Expired',
                                default => ucfirst($payment->status),
                            };

                        @endphp

                        <tr class="hover:bg-gray-50">

                            {{-- Invoice --}}
                            <td class="px-6 py-4">

                                <div class="font-semibold text-gray-900">
                                    {{ $transaction->invoice }}
                                </div>

                                <div class="mt-1 text-xs text-gray-500">
                                    {{ optional($transaction->tanggal_masuk)->format('d M Y, H:i') }}
                                </div>

                            </td>


                            {{-- Customer --}}
                            <td class="px-6 py-4">

                                <div class="font-medium text-gray-900">
                                    {{ $transaction->customer->name }}
                                </div>

                                <div class="mt-1 text-xs text-gray-500">
                                    {{ $transaction->customer->phone ?? '-' }}
                                </div>

                            </td>


                            {{-- Total --}}
                            <td class="px-6 py-4">

                                <span class="font-semibold text-gray-900">
                                    Rp {{ number_format($transaction->total_bayar, 0, ',', '.') }}
                                </span>

                            </td>


                            {{-- Metode --}}
                            <td class="px-6 py-4">

                                @if ($payment->metode === 'cash')

                                    <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                        Cash
                                    </span>

                                @elseif ($payment->metode === 'midtrans')

                                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                        Midtrans
                                    </span>

                                @else

                                    <span class="text-gray-400">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- Status --}}
                            <td class="px-6 py-4">

                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>

                            </td>


                            {{-- Action --}}
                            <td class="px-6 py-4 text-right">

                                <a
                                    href="{{ route('kasir.payments.show', $payment) }}"
                                    class="font-semibold text-gray-700 hover:text-gray-900"
                                >
                                    Detail
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-12 text-center"
                            >

                                <div class="text-gray-400">
                                    Belum ada data pembayaran.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if ($payments->hasPages())

            <div class="border-t border-gray-200 px-6 py-4">

                {{ $payments->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
