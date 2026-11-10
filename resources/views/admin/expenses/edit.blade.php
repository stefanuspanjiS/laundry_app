
@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">

        <div class="min-w-0">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                Edit Pengeluaran
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Perbarui informasi pengeluaran {{ $expense->kategori }}.
            </p>
        </div>

        <a href="{{ route('admin.expenses.index') }}"
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

        <form action="{{ route('admin.expenses.update', $expense) }}"
              method="POST"
              class="p-4 sm:p-6 space-y-5 sm:space-y-6">

            @csrf
            @method('PUT')


            {{-- Tanggal --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Pengeluaran
                </label>

                <input
                    type="date"
                    name="tanggal"
                    value="{{ old('tanggal', $expense->tanggal->format('Y-m-d')) }}"
                    required
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 text-sm
                           focus:border-gray-900 focus:ring-gray-900"
                >

                @error('tanggal')
                    <p class="text-sm text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Kategori --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori Pengeluaran
                </label>

                <select
                    name="kategori"
                    required
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 text-sm
                           focus:border-gray-900 focus:ring-gray-900"
                >
                    <option value="">Pilih Kategori</option>

                    @foreach ([
                        'Detergen',
                        'Parfum',
                        'Plastik',
                        'Pewangi',
                        'Listrik',
                        'Air',
                        'Perawatan Mesin',
                        'Transportasi',
                        'Lainnya'
                    ] as $item)

                        <option value="{{ $item }}"
                            {{ old('kategori', $expense->kategori) == $item ? 'selected' : '' }}>
                            {{ $item }}
                        </option>

                    @endforeach
                </select>

                @error('kategori')
                    <p class="text-sm text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Keterangan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Keterangan
                </label>

                <textarea
                    name="keterangan"
                    rows="4"
                    placeholder="Tambahkan keterangan pengeluaran..."
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 text-sm
                           focus:border-gray-900 focus:ring-gray-900"
                >{{ old('keterangan', $expense->keterangan) }}</textarea>

                @error('keterangan')
                    <p class="text-sm text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Jumlah --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah Pengeluaran
                </label>

                <div class="relative">

                    <span class="absolute left-4 top-1/2
                                 -translate-y-1/2
                                 text-sm text-gray-500">
                        Rp
                    </span>

                    <input
                        type="number"
                        name="jumlah"
                        value="{{ old('jumlah', $expense->jumlah) }}"
                        min="0"
                        step="0.01"
                        required
                        class="w-full rounded-xl border border-gray-300
                               pl-12 pr-4 py-3 text-sm
                               focus:border-gray-900 focus:ring-gray-900"
                    >

                </div>

                @error('jumlah')
                    <p class="text-sm text-red-500 mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Button --}}
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end
                        gap-3 pt-4 border-t border-gray-100">

                <a href="{{ route('admin.expenses.index') }}"
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
