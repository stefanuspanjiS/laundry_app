@extends('layouts.kasir')

@section('title', 'Buat Pesanan')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>

        <a
            href="{{ route('kasir.transactions.index') }}"
            class="text-sm font-medium text-gray-500 hover:text-gray-900"
        >
            ← Kembali ke Pesanan
        </a>

        <h1 class="mt-3 text-2xl font-bold text-gray-900">
            Buat Pesanan
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Masukkan data pelanggan dan layanan laundry.
        </p>

    </div>


    <form
        method="POST"
        action="{{ route('kasir.transactions.store') }}"
        id="transactionForm"
        class="space-y-6"
    >

        @csrf


        {{-- DATA PELANGGAN --}}
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">

            <h2 class="font-semibold text-gray-900">
                Data Pelanggan
            </h2>

            <div class="mt-5">

                <label class="mb-1.5 block text-sm font-medium text-gray-700">
                    Pelanggan
                </label>

                <select
                    name="customer_id"
                    required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5
                           text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                >

                    <option value="">
                        -- Pilih Pelanggan --
                    </option>

                    @foreach ($customers as $customer)

                        <option
                            value="{{ $customer->id }}"
                            @selected(old('customer_id') == $customer->id)
                        >
                            {{ $customer->name }}
                            @if($customer->phone)
                                - {{ $customer->phone }}
                            @endif
                        </option>

                    @endforeach

                </select>

            </div>

        </div>


        {{-- DETAIL PAKET --}}
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="font-semibold text-gray-900">
                        Detail Laundry
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Tambahkan paket dan berat laundry.
                    </p>

                </div>


                <button
                    type="button"
                    id="addPackage"
                    class="rounded-lg border border-gray-300 px-3 py-2
                           text-sm font-semibold text-gray-700
                           hover:bg-gray-50"
                >
                    + Tambah Paket
                </button>

            </div>


            <div
                id="packageContainer"
                class="mt-5 space-y-4"
            >

                {{-- ROW --}}
                <div
                    class="package-row rounded-lg border border-gray-200 p-4"
                >

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-12">

                        {{-- Paket --}}
                        <div class="md:col-span-6">

                            <label class="mb-1.5 block text-sm font-medium text-gray-700">
                                Paket Laundry
                            </label>

                            <select
                                name="packages[0][package_id]"
                                class="package-select w-full rounded-lg border border-gray-300
                                       px-3 py-2.5 text-sm
                                       focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                                required
                            >

                                <option value="">
                                    -- Pilih Paket --
                                </option>

                                @foreach ($packages as $package)

                                    <option
                                        value="{{ $package->id }}"
                                        data-price="{{ $package->harga_per_kg }}"
                                    >
                                        {{ $package->nama_paket }}
                                        — Rp {{ number_format($package->harga_per_kg, 0, ',', '.') }}/kg
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Berat --}}
                        <div class="md:col-span-3">

                            <label class="mb-1.5 block text-sm font-medium text-gray-700">
                                Berat (kg)
                            </label>

                            <input
                                type="number"
                                name="packages[0][berat]"
                                class="weight-input w-full rounded-lg border border-gray-300
                                       px-3 py-2.5 text-sm
                                       focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                                min="0.1"
                                step="0.1"
                                placeholder="0"
                                required
                            >

                        </div>


                        {{-- Subtotal --}}
                        <div class="md:col-span-2">

                            <label class="mb-1.5 block text-sm font-medium text-gray-700">
                                Subtotal
                            </label>

                            <div
                                class="subtotal-display rounded-lg bg-gray-50
                                       px-3 py-2.5 text-sm font-semibold text-gray-800"
                            >
                                Rp 0
                            </div>

                        </div>


                        {{-- Remove --}}
                        <div class="flex items-end md:col-span-1">

                            <button
                                type="button"
                                class="remove-package hidden w-full rounded-lg
                                       border border-red-200 bg-red-50
                                       px-3 py-2.5 text-red-600
                                       hover:bg-red-100"
                            >
                                ×
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- RINGKASAN --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- DISKON --}}
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 lg:col-span-2">

                <h2 class="font-semibold text-gray-900">
                    Diskon
                </h2>

                <div class="mt-5">

                    <label class="mb-1.5 block text-sm font-medium text-gray-700">
                        Nominal Diskon
                    </label>

                    <input
                        type="number"
                        name="diskon"
                        id="diskon"
                        value="{{ old('diskon', 0) }}"
                        min="0"
                        step="1000"
                        class="w-full rounded-lg border border-gray-300
                               px-3 py-2.5 text-sm
                               focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                    >

                </div>

            </div>


            {{-- TOTAL --}}
            <div class="rounded-xl bg-gray-900 p-6 text-white">

                <p class="text-sm text-gray-300">
                    Total Berat
                </p>

                <p
                    id="totalWeight"
                    class="mt-1 text-xl font-bold"
                >
                    0 kg
                </p>


                <div class="my-5 border-t border-gray-700"></div>


                <p class="text-sm text-gray-300">
                    Subtotal
                </p>

                <p
                    id="subtotal"
                    class="mt-1 text-lg font-semibold"
                >
                    Rp 0
                </p>


                <p class="mt-4 text-sm text-gray-300">
                    Diskon
                </p>

                <p
                    id="discountDisplay"
                    class="mt-1 text-lg font-semibold"
                >
                    Rp 0
                </p>


                <div class="my-5 border-t border-gray-700"></div>


                <p class="text-sm text-gray-300">
                    Total Bayar
                </p>

                <p
                    id="totalBayar"
                    class="mt-1 text-2xl font-bold"
                >
                    Rp 0
                </p>

            </div>

        </div>


        {{-- BUTTON --}}
        <div class="flex justify-end gap-3">

            <a
                href="{{ route('kasir.transactions.index') }}"
                class="rounded-lg border border-gray-300 bg-white
                       px-5 py-2.5 text-sm font-semibold text-gray-700
                       hover:bg-gray-50"
            >
                Batal
            </a>

            <button
                type="submit"
                class="rounded-lg bg-gray-900 px-5 py-2.5
                       text-sm font-semibold text-white
                       hover:bg-gray-800"
            >
                Simpan Pesanan
            </button>

        </div>

    </form>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const container =
        document.getElementById('packageContainer');

    const addButton =
        document.getElementById('addPackage');

    const discountInput =
        document.getElementById('diskon');


    let rowIndex = 1;


    function formatRupiah(number) {

        return new Intl.NumberFormat(
            'id-ID'
        ).format(number);

    }


    function calculate() {

        let subtotal = 0;

        let totalWeight = 0;


        document
            .querySelectorAll('.package-row')
            .forEach(function (row) {

                const select =
                    row.querySelector('.package-select');

                const weightInput =
                    row.querySelector('.weight-input');

                const subtotalDisplay =
                    row.querySelector('.subtotal-display');


                const selectedOption =
                    select.options[select.selectedIndex];


                const price =
                    parseFloat(
                        selectedOption?.dataset.price || 0
                    );


                const weight =
                    parseFloat(
                        weightInput.value || 0
                    );


                const rowSubtotal =
                    price * weight;


                subtotal += rowSubtotal;

                totalWeight += weight;


                subtotalDisplay.textContent =
                    'Rp ' + formatRupiah(rowSubtotal);

            });


        let discount =
            parseFloat(
                discountInput.value || 0
            );


        if (discount > subtotal) {
            discount = subtotal;
        }


        const total =
            subtotal - discount;


        document.getElementById('totalWeight')
            .textContent =
            totalWeight.toFixed(1) + ' kg';


        document.getElementById('subtotal')
            .textContent =
            'Rp ' + formatRupiah(subtotal);


        document.getElementById('discountDisplay')
            .textContent =
            'Rp ' + formatRupiah(discount);


        document.getElementById('totalBayar')
            .textContent =
            'Rp ' + formatRupiah(total);

    }


    function attachRowEvents(row) {

        row.querySelector('.package-select')
            .addEventListener('change', calculate);

        row.querySelector('.weight-input')
            .addEventListener('input', calculate);


        row.querySelector('.remove-package')
            .addEventListener('click', function () {

                row.remove();

                calculate();

            });

    }


    attachRowEvents(
        document.querySelector('.package-row')
    );


    addButton.addEventListener('click', function () {

        const row =
            document
                .querySelector('.package-row')
                .cloneNode(true);


        row.querySelector('.package-select').name =
            `packages[${rowIndex}][package_id]`;

        row.querySelector('.weight-input').name =
            `packages[${rowIndex}][berat]`;


        row.querySelector('.package-select').value =
            '';

        row.querySelector('.weight-input').value =
            '';


        row.querySelector('.subtotal-display')
            .textContent =
            'Rp 0';


        const removeButton =
            row.querySelector('.remove-package');

        removeButton.classList.remove('hidden');


        container.appendChild(row);


        attachRowEvents(row);


        rowIndex++;

    });


    discountInput.addEventListener(
        'input',
        calculate
    );


    calculate();

});

</script>

@endsection
