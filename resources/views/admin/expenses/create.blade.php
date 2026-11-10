@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>

        <h1 class="text-xl font-bold text-gray-800 sm:text-2xl">
            Tambah Pengeluaran
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Catat pengeluaran operasional laundry.
        </p>

    </div>


    {{-- Validation Error --}}
    @if($errors->any())

        <div class="rounded-lg border border-red-200 bg-red-50 p-4">

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

                    <ul class="mt-1 list-disc pl-5 text-sm text-red-700">

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


    {{-- Form --}}
    <div class="rounded-xl border border-gray-100 bg-white shadow-sm">

        <form
            action="{{ route('admin.expenses.store') }}"
            method="POST"
            class="space-y-5 p-4 sm:space-y-6 sm:p-6"
        >

            @csrf


            {{-- Tanggal --}}
            <div>

                <label
                    for="tanggal"
                    class="block text-sm font-medium text-gray-700"
                >
                    Tanggal
                </label>

                <input
                    type="date"
                    name="tanggal"
                    id="tanggal"
                    value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                    required
                    class="mt-2 block w-full rounded-lg border border-gray-300 px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >

            </div>


            {{-- Kategori --}}
            <div>

                <label
                    for="kategori"
                    class="block text-sm font-medium text-gray-700"
                >
                    Kategori
                </label>

                <select
                    name="kategori"
                    id="kategori"
                    required
                    class="mt-2 block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >

                    <option value="">
                        -- Pilih Kategori --
                    </option>

                    <option value="Detergen" @selected(old('kategori') === 'Detergen')>
                        Detergen
                    </option>

                    <option value="Parfum" @selected(old('kategori') === 'Parfum')>
                        Parfum
                    </option>

                    <option value="Plastik" @selected(old('kategori') === 'Plastik')>
                        Plastik
                    </option>

                    <option value="Pewangi" @selected(old('kategori') === 'Pewangi')>
                        Pewangi
                    </option>

                    <option value="Listrik" @selected(old('kategori') === 'Listrik')>
                        Listrik
                    </option>

                    <option value="Air" @selected(old('kategori') === 'Air')>
                        Air
                    </option>

                    <option value="Perawatan Mesin" @selected(old('kategori') === 'Perawatan Mesin')>
                        Perawatan Mesin
                    </option>

                    <option value="Transportasi" @selected(old('kategori') === 'Transportasi')>
                        Transportasi
                    </option>

                    <option value="Lainnya" @selected(old('kategori') === 'Lainnya')>
                        Lainnya
                    </option>

                </select>

            </div>


            {{-- Keterangan --}}
            <div>

                <label
                    for="keterangan"
                    class="block text-sm font-medium text-gray-700"
                >
                    Keterangan
                </label>

                <textarea
                    name="keterangan"
                    id="keterangan"
                    rows="4"
                    placeholder="Contoh: Membeli detergen 5 kg"
                    class="mt-2 block w-full resize-none rounded-lg border border-gray-300 px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >{{ old('keterangan') }}</textarea>

                <p class="mt-2 text-xs text-gray-500">
                    Keterangan bersifat opsional.
                </p>

            </div>


            {{-- Jumlah --}}
            <div>

                <label
                    for="jumlah"
                    class="block text-sm font-medium text-gray-700"
                >
                    Jumlah Pengeluaran
                </label>

                <div class="relative mt-2">

                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-400">
                        Rp
                    </span>

                    <input
                        type="number"
                        name="jumlah"
                        id="jumlah"
                        value="{{ old('jumlah') }}"
                        min="0"
                        step="0.01"
                        required
                        placeholder="150000"
                        class="block w-full rounded-lg border border-gray-300 px-4 py-3 pl-12 text-sm text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>

            </div>


            {{-- Button --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('admin.expenses.index') }}"
                    class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 sm:w-auto"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700 sm:w-auto"
                >
                    Simpan Pengeluaran
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
