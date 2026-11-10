@extends('layouts.pelanggan')

@section('content')

<div class="w-full min-w-0 space-y-6">

    {{-- Header --}}
    <div class="min-w-0">
        <h1 class="text-xl font-bold text-gray-800 sm:text-2xl">
            Buat Pesanan
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Pilih paket laundry dan masukkan berat pakaian kamu.
        </p>
    </div>


    {{-- Error --}}
    @if($errors->any())

        <div class="w-full min-w-0 rounded-lg border border-red-200 bg-red-50 p-4">

            <div class="flex items-start">

                <svg
                    class="h-5 w-5 shrink-0 text-red-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M10.29 3.86l-7.36 12.75A2 2 0 004.66 19h14.68a2 2 0 001.73-2.39L13.71 3.86a2 2 0 00-3.42 0z"
                    />
                </svg>

                <div class="ml-3 min-w-0">

                    <h3 class="text-sm font-semibold text-red-800">
                        Terdapat kesalahan
                    </h3>

                    <ul class="mt-1 list-disc break-words pl-5 text-sm text-red-700">

                        @foreach($errors->all() as $error)

                            <li class="break-words">
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- Success --}}
    @if(session('success'))

        <div class="w-full min-w-0 rounded-lg border border-green-200 bg-green-50 p-4">

            <p class="break-words text-sm font-medium text-green-700">
                {{ session('success') }}
            </p>

        </div>

    @endif


    {{-- Form --}}
    <div class="w-full min-w-0 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">

        <form
            action="{{ route('pelanggan.orders.store') }}"
            method="POST"
            class="w-full min-w-0 space-y-5 p-4 sm:space-y-6 sm:p-6"
        >

            @csrf


            {{-- Pilih Paket --}}
            <div class="min-w-0">

                <label
                    for="package_id"
                    class="block text-sm font-medium text-gray-700"
                >
                    Paket Laundry
                </label>

                <select
                    name="package_id"
                    id="package_id"
                    required
                    class="mt-2 block w-full min-w-0 rounded-lg border border-gray-300 bg-white px-3 py-3 text-sm text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:px-4"
                >

                    <option value="">
                        -- Pilih Paket Laundry --
                    </option>

                    @foreach($packages as $package)

                        <option
                            value="{{ $package->id }}"
                            data-price="{{ $package->harga_per_kg }}"
                            @selected(old('package_id') == $package->id)
                        >
                            {{ $package->nama_paket }}
                            - Rp {{ number_format($package->harga_per_kg, 0, ',', '.') }}/kg
                        </option>

                    @endforeach

                </select>

                @if($packages->count() === 0)

                    <p class="mt-2 break-words text-sm text-red-600">
                        Belum ada paket laundry yang tersedia.
                    </p>

                @endif

            </div>


            {{-- Berat --}}
            <div class="min-w-0">

                <label
                    for="berat"
                    class="block text-sm font-medium text-gray-700"
                >
                    Berat Laundry
                </label>

                <div class="relative mt-2">

                    <input
                        type="number"
                        name="berat"
                        id="berat"
                        value="{{ old('berat') }}"
                        min="0.1"
                        step="0.1"
                        required
                        placeholder="Contoh: 3.5"
                        class="block w-full min-w-0 rounded-lg border border-gray-300 px-3 py-3 pr-12 text-sm text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:px-4 sm:pr-14"
                    >

                    <span
                        class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 sm:right-4"
                    >
                        kg
                    </span>

                </div>

                <p class="mt-2 text-xs text-gray-500">
                    Masukkan berat laundry dalam kilogram.
                </p>

            </div>


            {{-- Estimasi Harga --}}
            <div class="w-full min-w-0 rounded-lg bg-gray-50 p-4 sm:p-5">

                <div class="flex items-center justify-between gap-4">

                    <span class="shrink-0 text-sm text-gray-600">
                        Harga per kg
                    </span>

                    <span
                        id="harga_per_kg"
                        class="min-w-0 break-words text-right text-sm font-medium text-gray-800"
                    >
                        Rp 0
                    </span>

                </div>


                <div class="mt-3 flex items-center justify-between gap-4">

                    <span class="shrink-0 text-sm text-gray-600">
                        Berat
                    </span>

                    <span
                        id="display_berat"
                        class="min-w-0 break-words text-right text-sm font-medium text-gray-800"
                    >
                        0 kg
                    </span>

                </div>


                <div class="my-4 border-t border-gray-200"></div>


                <div class="flex items-start justify-between gap-4">

                    <span class="min-w-0 font-semibold text-gray-800">
                        Estimasi Total
                    </span>

                    <span
                        id="total_harga"
                        class="shrink-0 text-right text-lg font-bold text-blue-600 sm:text-xl"
                    >
                        Rp 0
                    </span>

                </div>

                <p class="mt-2 break-words text-xs text-gray-400">
                    Estimasi ini hanya untuk membantu perhitungan.
                    Total pembayaran akan dihitung kembali oleh sistem.
                </p>

            </div>


            {{-- Button --}}
            <div class="flex w-full flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('pelanggan.orders.index') }}"
                    class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 sm:w-auto"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700 sm:w-auto"
                >
                    Buat Pesanan
                </button>

            </div>

        </form>

    </div>

</div>


{{-- JavaScript hanya untuk preview harga --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const packageSelect = document.getElementById('package_id');
        const beratInput = document.getElementById('berat');

        const hargaPerKg = document.getElementById('harga_per_kg');
        const displayBerat = document.getElementById('display_berat');
        const totalHarga = document.getElementById('total_harga');


        function formatRupiah(number) {

            return new Intl.NumberFormat('id-ID', {
                maximumFractionDigits: 0
            }).format(number);

        }


        function updateEstimate() {

            const selectedOption =
                packageSelect.options[packageSelect.selectedIndex];

            const price =
                parseFloat(selectedOption?.dataset.price || 0);

            const berat =
                parseFloat(beratInput.value || 0);

            const total =
                price * berat;


            hargaPerKg.textContent =
                'Rp ' + formatRupiah(price);

            displayBerat.textContent =
                berat + ' kg';

            totalHarga.textContent =
                'Rp ' + formatRupiah(total);

        }


        packageSelect.addEventListener('change', updateEstimate);

        beratInput.addEventListener('input', updateEstimate);

        updateEstimate();

    });
</script>

@endsection
