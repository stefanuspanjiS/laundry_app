@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">

        <div class="min-w-0">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                Edit Paket
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Perbarui informasi paket {{ $package->nama_paket }}.
            </p>
        </div>

        <a href="{{ route('admin.packages.index') }}"
           class="w-full sm:w-auto inline-flex items-center justify-center
                  px-4 py-2.5 rounded-xl border border-gray-200
                  text-sm font-medium text-gray-700
                  hover:bg-gray-50 transition">
            Kembali
        </a>

    </div>


    {{-- Error --}}
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

            <ul class="text-sm text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    {{-- Form --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">

        <form action="{{ route('admin.packages.update', $package) }}"
              method="POST"
              class="p-4 sm:p-6 space-y-5 sm:space-y-6">

            @csrf
            @method('PUT')


            {{-- Nama Paket --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Paket
                </label>

                <input
                    type="text"
                    name="nama_paket"
                    value="{{ old('nama_paket', $package->nama_paket) }}"
                    required
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 text-sm
                           focus:border-gray-900 focus:ring-gray-900"
                >

                @error('nama_paket')
                    <p class="text-sm text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Harga --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Harga per Kg
                </label>

                <div class="relative">

                    <span class="absolute left-4 top-1/2
                                 -translate-y-1/2
                                 text-sm text-gray-500">
                        Rp
                    </span>

                    <input
                        type="number"
                        name="harga_per_kg"
                        value="{{ old('harga_per_kg', $package->harga_per_kg) }}"
                        min="0"
                        required
                        class="w-full rounded-xl border border-gray-300
                               pl-12 pr-4 py-3 text-sm
                               focus:border-gray-900 focus:ring-gray-900"
                    >

                </div>

                @error('harga_per_kg')
                    <p class="text-sm text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Estimasi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Estimasi Pengerjaan
                </label>

                <div class="relative">

                    <input
                        type="number"
                        name="estimasi_hari"
                        value="{{ old('estimasi_hari', $package->estimasi_hari) }}"
                        min="1"
                        required
                        class="w-full rounded-xl border border-gray-300
                               px-4 py-3 pr-16 text-sm
                               focus:border-gray-900 focus:ring-gray-900"
                    >

                    <span class="absolute right-4 top-1/2
                                 -translate-y-1/2
                                 text-sm text-gray-500">
                        hari
                    </span>

                </div>

                @error('estimasi_hari')
                    <p class="text-sm text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    rows="4"
                    placeholder="Jelaskan layanan yang diberikan..."
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 text-sm
                           focus:border-gray-900 focus:ring-gray-900"
                >{{ old('deskripsi', $package->deskripsi) }}</textarea>

                @error('deskripsi')
                    <p class="text-sm text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                </label>

                <select
                    name="status"
                    required
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 text-sm
                           focus:border-gray-900 focus:ring-gray-900"
                >
                    <option value="1"
                        {{ old('status', $package->status) == 1 ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="0"
                        {{ old('status', $package->status) == 0 ? 'selected' : '' }}>
                        Tidak Aktif
                    </option>
                </select>

                @error('status')
                    <p class="text-sm text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Button --}}
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end
                        gap-3 pt-4 border-t border-gray-100">

                <a href="{{ route('admin.packages.index') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center
                          px-5 py-2.5 rounded-xl border border-gray-200
                          text-sm font-medium text-gray-700
                          hover:bg-gray-50">
                    Batal
                </a>

                <button
                    type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center
                           px-5 py-2.5 rounded-xl bg-gray-900
                           text-white text-sm font-medium
                           hover:bg-gray-800 transition">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
