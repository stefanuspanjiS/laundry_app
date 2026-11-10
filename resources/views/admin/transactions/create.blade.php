@extends('layouts.admin')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">

        <div class="min-w-0">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                Tambah Transaksi
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Buat transaksi laundry baru.
            </p>
        </div>

        <a
            href="{{ route('admin.transactions.index') }}"
            class="w-full sm:w-auto inline-flex items-center justify-center
                   px-4 py-2.5 rounded-xl border border-gray-200
                   text-sm font-medium text-gray-700
                   hover:bg-gray-50 transition"
        >
            Kembali
        </a>

    </div>


    {{-- Errors --}}
    @if ($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

            <ul class="text-sm text-red-600 space-y-1">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('admin.transactions.store') }}"
        method="POST"
        id="transaction-form"
    >

        @csrf


        {{-- Informasi Transaksi --}}
        <div class="bg-white rounded-2xl border border-gray-200
                    shadow-sm mb-6">

            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100">

                <h3 class="font-semibold text-gray-900">
                    Informasi Transaksi
                </h3>

            </div>

            <div class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">

                {{-- Pelanggan --}}
                <div>
                    <label class="block text-sm font-medium
                                  text-gray-700 mb-2">
                        Pelanggan
                    </label>

                    <select
                        name="customer_id"
                        required
                        class="w-full rounded-xl border border-gray-300
                               px-4 py-3 text-sm
                               focus:border-gray-900 focus:ring-gray-900"
                    >

                        <option value="">
                            Pilih Pelanggan
                        </option>

                        @foreach($customers as $customer)

                            <option
                                value="{{ $customer->id }}"
                                {{ old('customer_id') == $customer->id
                                    ? 'selected'
                                    : '' }}
                            >
                                {{ $customer->name }}
                                — {{ $customer->phone }}
                            </option>

                        @endforeach

                    </select>

                    @error('customer_id')
                        <p class="text-sm text-red-500 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Kasir --}}
                <div>
                    <label class="block text-sm font-medium
                                  text-gray-700 mb-2">
                        Kasir
                    </label>

                    <select
                        name="cashier_id"
                        required
                        class="w-full rounded-xl border border-gray-300
                               px-4 py-3 text-sm
                               focus:border-gray-900 focus:ring-gray-900"
                    >

                        <option value="">
                            Pilih Kasir
                        </option>

                        @foreach($cashiers as $cashier)

                            <option
                                value="{{ $cashier->id }}"
                                {{ old('cashier_id') == $cashier->id
                                    ? 'selected'
                                    : '' }}
                            >
                                {{ $cashier->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('cashier_id')
                        <p class="text-sm text-red-500 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Tanggal Masuk --}}
                <div>
                    <label class="block text-sm font-medium
                                  text-gray-700 mb-2">
                        Tanggal Masuk
                    </label>

                    <input
                        type="date"
                        name="tanggal_masuk"
                        value="{{ old(
                            'tanggal_masuk',
                            now()->format('Y-m-d')
                        ) }}"
                        required
                        class="w-full rounded-xl border border-gray-300
                               px-4 py-3 text-sm
                               focus:border-gray-900 focus:ring-gray-900"
                    >
                </div>


                {{-- Tanggal Selesai --}}
                <div>
                    <label class="block text-sm font-medium
                                  text-gray-700 mb-2">
                        Tanggal Selesai
                    </label>

                    <input
                        type="date"
                        name="tanggal_selesai"
                        value="{{ old('tanggal_selesai') }}"
                        class="w-full rounded-xl border border-gray-300
                               px-4 py-3 text-sm
                               focus:border-gray-900 focus:ring-gray-900"
                    >
                </div>

            </div>

        </div>


        {{-- Detail Paket --}}
        <div class="bg-white rounded-2xl border border-gray-200
                    shadow-sm mb-6">

            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100
                        flex flex-col gap-3 sm:flex-row sm:items-center
                        sm:justify-between">

                <div class="min-w-0">
                    <h3 class="font-semibold text-gray-900">
                        Detail Laundry
                    </h3>

                    <p class="text-xs text-gray-500 mt-1">
                        Paket tidak aktif tidak tersedia untuk transaksi baru.
                    </p>
                </div>

                <button
                    type="button"
                    id="add-detail"
                    class="w-full sm:w-auto inline-flex items-center
                           justify-center gap-2
                           px-4 py-2 rounded-xl
                           bg-gray-900 text-white
                           text-sm font-medium
                           hover:bg-gray-800"
                >
                    <span class="text-lg leading-none">+</span>
                    Tambah Paket
                </button>

            </div>


            <div class="p-4 sm:p-6">

                <div
                    id="detail-container"
                    class="space-y-4"
                >

                    {{-- Row pertama dibuat JavaScript --}}

                </div>

            </div>

        </div>


        {{-- Ringkasan --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-6">

            {{-- Status --}}
            <div class="lg:col-span-2
                        bg-white rounded-2xl
                        border border-gray-200 shadow-sm">

                <div class="p-4 sm:p-6 space-y-5 sm:space-y-6">

                    {{-- Status Laundry --}}
                    <div>
                        <label class="block text-sm font-medium
                                      text-gray-700 mb-2">
                            Status Laundry
                        </label>

                        <select
                            name="status_laundry"
                            required
                            class="w-full rounded-xl border border-gray-300
                                   px-4 py-3 text-sm"
                        >

                            @foreach([
                                'menunggu' => 'Menunggu',
                                'dicuci' => 'Dicuci',
                                'dikeringkan' => 'Dikeringkan',
                                'disetrika' => 'Disetrika',
                                'siap_diambil' => 'Siap Diambil',
                                'selesai' => 'Selesai',
                            ] as $value => $label)

                                <option
                                    value="{{ $value }}"
                                    {{ old(
                                        'status_laundry',
                                        'menunggu'
                                    ) === $value
                                        ? 'selected'
                                        : '' }}
                                >
                                    {{ $label }}
                                </option>

                            @endforeach

                        </select>
                    </div>


                    {{-- Status Pembayaran --}}
                    <div>
                        <label class="block text-sm font-medium
                                      text-gray-700 mb-2">
                            Status Pembayaran
                        </label>

                        <select
                            name="status_pembayaran"
                            id="status-pembayaran"
                            required
                            class="w-full rounded-xl border border-gray-300
                                   px-4 py-3 text-sm"
                        >

                            <option
                                value="belum_bayar"
                                {{ old(
                                    'status_pembayaran',
                                    'belum_bayar'
                                ) === 'belum_bayar'
                                    ? 'selected'
                                    : '' }}
                            >
                                Belum Bayar
                            </option>

                            <option
                                value="dibayar"
                                {{ old('status_pembayaran') === 'dibayar'
                                    ? 'selected'
                                    : '' }}
                            >
                                Dibayar
                            </option>

                        </select>
                    </div>


                    {{-- Metode --}}
                    <div id="metode-wrapper">

                        <label class="block text-sm font-medium
                                      text-gray-700 mb-2">
                            Metode Pembayaran
                        </label>

                        <select
                            name="metode_pembayaran"
                            class="w-full rounded-xl border border-gray-300
                                   px-4 py-3 text-sm"
                        >

                            <option value="cash">
                                Cash
                            </option>

                            <option value="midtrans">
                                Midtrans
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- Total --}}
            <div class="bg-gray-900 rounded-2xl
                        text-white shadow-sm">

                <div class="p-4 sm:p-6">

                    <h3 class="font-semibold mb-6">
                        Ringkasan Pembayaran
                    </h3>

                    <div class="space-y-4 text-sm">

                        <div class="flex justify-between gap-4">
                            <span class="text-gray-400">
                                Total Berat
                            </span>

                            <span
                                id="summary-weight"
                                class="font-medium text-right"
                            >
                                0 kg
                            </span>
                        </div>


                        <div class="flex justify-between gap-4">
                            <span class="text-gray-400">
                                Subtotal
                            </span>

                            <span
                                id="summary-subtotal"
                                class="text-right"
                            >
                                Rp 0
                            </span>
                        </div>


                        <div>
                            <label class="block text-gray-400 mb-2">
                                Diskon
                            </label>

                            <input
                                type="number"
                                name="diskon"
                                id="diskon"
                                value="{{ old('diskon', 0) }}"
                                min="0"
                                class="w-full rounded-xl
                                       bg-gray-800
                                       border-gray-700
                                       text-white px-4 py-3"
                            >
                        </div>


                        <div class="border-t border-gray-700 pt-4">

                            <div class="flex justify-between
                                        items-end gap-4">

                                <span class="text-gray-400">
                                    Total Bayar
                                </span>

                                <span
                                    id="summary-total"
                                    class="text-xl sm:text-2xl font-bold
                                           text-right break-words"
                                >
                                    Rp 0
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Button --}}
        <div class="flex flex-col-reverse sm:flex-row sm:justify-end
                    gap-3 mt-6">

            <a
                href="{{ route('admin.transactions.index') }}"
                class="w-full sm:w-auto inline-flex items-center
                       justify-center
                       px-5 py-2.5 rounded-xl
                       border border-gray-200
                       text-sm font-medium text-gray-700
                       hover:bg-gray-50"
            >
                Batal
            </a>

            <button
                type="submit"
                class="w-full sm:w-auto inline-flex items-center
                       justify-center
                       px-5 py-2.5 rounded-xl
                       bg-gray-900 text-white
                       text-sm font-medium
                       hover:bg-gray-800"
            >
                Simpan Transaksi
            </button>

        </div>

    </form>

</div>


{{-- Template opsi paket --}}
<template id="package-options">

    <option value="">
        Pilih Paket
    </option>

    @foreach($packages as $package)

        <option
            value="{{ $package->id }}"
            data-harga="{{ $package->harga_per_kg }}"
        >
            {{ $package->nama_paket }}
            — Rp {{ number_format(
                $package->harga_per_kg,
                0,
                ',',
                '.'
            ) }}/kg
        </option>

    @endforeach

</template>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const container =
        document.getElementById('detail-container');

    const addButton =
        document.getElementById('add-detail');

    const diskonInput =
        document.getElementById('diskon');

    const statusPembayaran =
        document.getElementById('status-pembayaran');

    const metodeWrapper =
        document.getElementById('metode-wrapper');

    let rowIndex = 0;


    function formatRupiah(number) {

        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(number);

    }


    function updateSummary() {

        let totalBerat = 0;
        let subtotal = 0;

        document
            .querySelectorAll('.detail-row')
            .forEach(row => {

                const berat =
                    parseFloat(
                        row.querySelector('.berat-input').value
                    ) || 0;

                const select =
                    row.querySelector('.package-select');

                const option =
                    select.options[select.selectedIndex];

                const harga =
                    parseFloat(
                        option?.dataset.harga
                    ) || 0;

                const rowSubtotal =
                    berat * harga;

                totalBerat += berat;
                subtotal += rowSubtotal;

                row.querySelector('.row-subtotal')
                    .textContent =
                    formatRupiah(rowSubtotal);

            });


        const diskon =
            parseFloat(diskonInput.value) || 0;

        const total =
            Math.max(subtotal - diskon, 0);


        document.getElementById('summary-weight')
            .textContent =
            totalBerat.toFixed(2) + ' kg';

        document.getElementById('summary-subtotal')
            .textContent =
            formatRupiah(subtotal);

        document.getElementById('summary-total')
            .textContent =
            formatRupiah(total);

    }


    function addRow() {

        const index = rowIndex++;

        const row =
            document.createElement('div');

        row.className =
            'detail-row grid grid-cols-1 md:grid-cols-12 gap-3 ' +
            'p-4 rounded-xl border border-gray-200 bg-gray-50';

        row.innerHTML = `

            <div class="md:col-span-6">

                <label class="block text-xs font-medium
                              text-gray-500 mb-1">
                    Paket
                </label>

                <select
                    name="details[${index}][package_id]"
                    class="package-select w-full rounded-xl
                           border border-gray-300
                           bg-white px-4 py-3 text-sm"
                    required
                >
                    ${document.getElementById('package-options').innerHTML}
                </select>

            </div>


            <div class="md:col-span-3">

                <label class="block text-xs font-medium
                              text-gray-500 mb-1">
                    Berat (Kg)
                </label>

                <input
                    type="number"
                    name="details[${index}][berat]"
                    class="berat-input w-full rounded-xl
                           border border-gray-300
                           bg-white px-4 py-3 text-sm"
                    min="0.1"
                    step="0.1"
                    placeholder="0.0"
                    required
                >

            </div>


            <div class="md:col-span-2">

                <label class="block text-xs font-medium
                              text-gray-500 mb-1">
                    Subtotal
                </label>

                <div class="row-subtotal
                            w-full px-2 py-3
                            text-sm font-semibold
                            text-gray-900
                            break-words">
                    Rp 0
                </div>

            </div>


            <div class="md:col-span-1 flex items-end">

                <button
                    type="button"
                    class="remove-row w-full h-11
                           rounded-xl border border-red-200
                           text-red-500 hover:bg-red-50"
                    title="Hapus"
                >
                    ×
                </button>

            </div>

        `;


        container.appendChild(row);


        row.querySelector('.package-select')
            .addEventListener(
                'change',
                updateSummary
            );


        row.querySelector('.berat-input')
            .addEventListener(
                'input',
                updateSummary
            );


        row.querySelector('.remove-row')
            .addEventListener(
                'click',
                function () {

                    row.remove();

                    updateSummary();

                }
            );

    }


    addButton.addEventListener(
        'click',
        addRow
    );


    diskonInput.addEventListener(
        'input',
        updateSummary
    );


    statusPembayaran.addEventListener(
        'change',
        function () {

            if (
                this.value === 'dibayar'
            ) {
                metodeWrapper.classList.remove(
                    'hidden'
                );
            } else {
                metodeWrapper.classList.add(
                    'hidden'
                );
            }

        }
    );


    // Baris pertama
    addRow();

    updateSummary();

});

</script>

@endsection
