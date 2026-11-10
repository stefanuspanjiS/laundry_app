@extends('layouts.admin')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">

        <div class="min-w-0">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                Edit Transaksi
            </h2>

            <p class="text-sm text-gray-500 mt-1 break-all">
                {{ $transaction->invoice }}
            </p>
        </div>

        <a
            href="{{ route(
                'admin.transactions.show',
                $transaction
            ) }}"
            class="w-full sm:w-auto inline-flex items-center justify-center
                   px-4 py-2.5 rounded-xl
                   border border-gray-200
                   text-sm font-medium
                   text-gray-700
                   hover:bg-gray-50"
        >
            Kembali
        </a>

    </div>


    @if ($errors->any())

        <div class="mb-6 rounded-xl
                    border border-red-200
                    bg-red-50 p-4">

            <ul class="text-sm text-red-600 space-y-1">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route(
            'admin.transactions.update',
            $transaction
        ) }}"
        method="POST"
    >

        @csrf
        @method('PUT')


        {{-- Informasi --}}
        <div class="bg-white rounded-2xl
                    border border-gray-200
                    shadow-sm mb-6">

            <div class="p-4 sm:p-6 grid
                        grid-cols-1 md:grid-cols-2
                        gap-5 sm:gap-6">

                <div>

                    <label class="block text-sm
                                  font-medium
                                  text-gray-700 mb-2">
                        Pelanggan
                    </label>

                    <select
                        name="customer_id"
                        required
                        class="w-full rounded-xl
                               border border-gray-300
                               px-4 py-3 text-sm"
                    >

                        @foreach($customers as $customer)

                            <option
                                value="{{ $customer->id }}"
                                {{ old(
                                    'customer_id',
                                    $transaction->customer_id
                                ) == $customer->id
                                    ? 'selected'
                                    : '' }}
                            >
                                {{ $customer->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div>

                    <label class="block text-sm
                                  font-medium
                                  text-gray-700 mb-2">
                        Kasir
                    </label>

                    <select
                        name="cashier_id"
                        required
                        class="w-full rounded-xl
                               border border-gray-300
                               px-4 py-3 text-sm"
                    >

                        @foreach($cashiers as $cashier)

                            <option
                                value="{{ $cashier->id }}"
                                {{ old(
                                    'cashier_id',
                                    $transaction->cashier_id
                                ) == $cashier->id
                                    ? 'selected'
                                    : '' }}
                            >
                                {{ $cashier->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div>

                    <label class="block text-sm
                                  font-medium
                                  text-gray-700 mb-2">
                        Tanggal Masuk
                    </label>

                    <input
                        type="date"
                        name="tanggal_masuk"
                        value="{{ old(
                            'tanggal_masuk',
                            $transaction
                                ->tanggal_masuk
                                ->format('Y-m-d')
                        ) }}"
                        required
                        class="w-full rounded-xl
                               border border-gray-300
                               px-4 py-3 text-sm"
                    >

                </div>


                <div>

                    <label class="block text-sm
                                  font-medium
                                  text-gray-700 mb-2">
                        Tanggal Selesai
                    </label>

                    <input
                        type="date"
                        name="tanggal_selesai"
                        value="{{ old(
                            'tanggal_selesai',
                            optional(
                                $transaction->tanggal_selesai
                            )->format('Y-m-d')
                        ) }}"
                        class="w-full rounded-xl
                               border border-gray-300
                               px-4 py-3 text-sm"
                    >

                </div>

            </div>

        </div>


        {{-- Details --}}
        <div class="bg-white rounded-2xl
                    border border-gray-200
                    shadow-sm mb-6">

            <div class="px-4 sm:px-6 py-4 sm:py-5
                        border-b border-gray-100
                        flex flex-col gap-3
                        sm:flex-row sm:justify-between
                        sm:items-center">

                <div class="min-w-0">

                    <h3 class="font-semibold text-gray-900">
                        Detail Laundry
                    </h3>

                    <p class="text-xs text-gray-500 mt-1">
                        Paket yang sudah tidak aktif tetap
                        dapat digunakan untuk histori transaksi.
                    </p>

                </div>

                <button
                    type="button"
                    id="add-detail"
                    class="w-full sm:w-auto inline-flex items-center
                           justify-center
                           px-4 py-2 rounded-xl
                           bg-gray-900 text-white
                           text-sm
                           hover:bg-gray-800"
                >
                    + Tambah Paket
                </button>

            </div>


            <div class="p-4 sm:p-6">

                <div
                    id="detail-container"
                    class="space-y-4"
                ></div>

            </div>

        </div>


        {{-- Bottom --}}
        <div class="grid grid-cols-1 lg:grid-cols-2
                    gap-5 sm:gap-6">

            {{-- Status --}}
            <div class="bg-white rounded-2xl
                        border border-gray-200
                        shadow-sm p-4 sm:p-6 space-y-5">

                <div>

                    <label class="block text-sm
                                  font-medium
                                  text-gray-700 mb-2">
                        Diskon
                    </label>

                    <input
                        type="number"
                        name="diskon"
                        id="diskon"
                        value="{{ old(
                            'diskon',
                            $transaction->diskon
                        ) }}"
                        min="0"
                        class="w-full rounded-xl
                               border border-gray-300
                               px-4 py-3 text-sm"
                    >

                </div>

            </div>


            {{-- Summary --}}
            <div class="bg-gray-900 text-white
                        rounded-2xl p-4 sm:p-6">

                <h3 class="font-semibold mb-6">
                    Ringkasan
                </h3>

                <div class="space-y-4">

                    <div class="flex justify-between gap-4">

                        <span class="text-gray-400">
                            Total Berat
                        </span>

                        <span
                            id="summary-weight"
                            class="text-right"
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


                    <div class="flex justify-between gap-4
                                border-t border-gray-700
                                pt-4">

                        <span class="text-gray-400">
                            Total Bayar
                        </span>

                        <span
                            id="summary-total"
                            class="text-xl sm:text-2xl
                                   font-bold text-right
                                   break-words"
                        >
                            Rp 0
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <div class="flex flex-col-reverse sm:flex-row
                    sm:justify-end gap-3 mt-6">

            <a
                href="{{ route(
                    'admin.transactions.show',
                    $transaction
                ) }}"
                class="w-full sm:w-auto inline-flex
                       items-center justify-center
                       px-5 py-2.5 rounded-xl
                       border border-gray-200
                       text-sm
                       hover:bg-gray-50"
            >
                Batal
            </a>

            <button
                type="submit"
                class="w-full sm:w-auto inline-flex
                       items-center justify-center
                       px-5 py-2.5 rounded-xl
                       bg-gray-900 text-white
                       text-sm font-medium
                       hover:bg-gray-800"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>


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
            @if(!$package->status)
                — Tidak Aktif
            @endif
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

    const options =
        document.getElementById(
            'package-options'
        ).innerHTML;

    const diskon =
        document.getElementById('diskon');

    let index = 0;


    function rupiah(value) {

        return new Intl.NumberFormat(
            'id-ID',
            {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }
        ).format(value);

    }


    function updateSummary() {

        let beratTotal = 0;
        let subtotal = 0;

        document
            .querySelectorAll('.detail-row')
            .forEach(row => {

                const berat =
                    parseFloat(
                        row.querySelector(
                            '.berat-input'
                        ).value
                    ) || 0;

                const select =
                    row.querySelector(
                        '.package-select'
                    );

                const option =
                    select.options[
                        select.selectedIndex
                    ];

                const harga =
                    parseFloat(
                        option?.dataset.harga
                    ) || 0;

                const rowSubtotal =
                    berat * harga;

                beratTotal += berat;
                subtotal += rowSubtotal;

                row.querySelector(
                    '.row-subtotal'
                ).textContent =
                    rupiah(rowSubtotal);

            });


        const potongan =
            parseFloat(diskon.value) || 0;

        const total =
            Math.max(
                subtotal - potongan,
                0
            );


        document.getElementById(
            'summary-weight'
        ).textContent =
            beratTotal.toFixed(2) + ' kg';

        document.getElementById(
            'summary-subtotal'
        ).textContent =
            rupiah(subtotal);

        document.getElementById(
            'summary-total'
        ).textContent =
            rupiah(total);

    }


    function addRow(
        packageId = '',
        berat = ''
    ) {

        const row =
            document.createElement('div');

        row.className =
            'detail-row grid grid-cols-1 md:grid-cols-12 ' +
            'gap-3 p-4 rounded-xl border ' +
            'border-gray-200 bg-gray-50';

        row.innerHTML = `

            <div class="md:col-span-6">

                <label class="block text-xs
                              font-medium
                              text-gray-500 mb-1">
                    Paket
                </label>

                <select
                    name="details[${index}][package_id]"
                    class="package-select w-full
                           rounded-xl border
                           border-gray-300
                           bg-white px-4 py-3 text-sm"
                    required
                >
                    ${options}
                </select>

            </div>


            <div class="md:col-span-3">

                <label class="block text-xs
                              font-medium
                              text-gray-500 mb-1">
                    Berat (Kg)
                </label>

                <input
                    type="number"
                    name="details[${index}][berat]"
                    value="${berat}"
                    min="0.1"
                    step="0.1"
                    required
                    class="berat-input w-full
                           rounded-xl border
                           border-gray-300
                           bg-white px-4 py-3 text-sm"
                >

            </div>


            <div class="md:col-span-2">

                <label class="block text-xs
                              font-medium
                              text-gray-500 mb-1">
                    Subtotal
                </label>

                <div
                    class="row-subtotal px-2 py-3
                           text-sm font-semibold
                           break-words"
                >
                    Rp 0
                </div>

            </div>


            <div class="md:col-span-1
                        flex items-end">

                <button
                    type="button"
                    class="remove-row w-full h-11
                           rounded-xl
                           border border-red-200
                           text-red-500
                           hover:bg-red-50"
                >
                    ×
                </button>

            </div>

        `;


        container.appendChild(row);


        const select =
            row.querySelector(
                '.package-select'
            );

        select.value = packageId;


        select.addEventListener(
            'change',
            updateSummary
        );


        row.querySelector(
            '.berat-input'
        ).addEventListener(
            'input',
            updateSummary
        );


        row.querySelector(
            '.remove-row'
        ).addEventListener(
            'click',
            function () {

                row.remove();

                updateSummary();

            }
        );


        index++;

        updateSummary();

    }


    @foreach($transaction->details as $detail)

        addRow(
            {{ $detail->package_id }},
            {{ $detail->berat }}
        );

    @endforeach


    document.getElementById(
        'add-detail'
    ).addEventListener(
        'click',
        () => addRow()
    );


    diskon.addEventListener(
        'input',
        updateSummary
    );


    updateSummary();

});

</script>

@endsection
