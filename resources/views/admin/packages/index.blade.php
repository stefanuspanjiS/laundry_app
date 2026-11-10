@extends('layouts.admin')

@section('title', 'Paket Laundry')
@section('page-title', 'Paket Laundry')

@section('content')

@if(session('success'))
    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3">
        <p class="text-sm font-medium text-green-700">
            {{ session('success') }}
        </p>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
        <p class="text-sm font-medium text-red-700">
            {{ session('error') }}
        </p>
    </div>
@endif

<div class="mb-6 sm:mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
            Paket Laundry
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Kelola jenis layanan dan harga laundry.
        </p>
    </div>

    <form method="GET"
        action="{{ route('admin.packages.index') }}"
        class="w-full lg:w-auto flex flex-col sm:flex-row gap-3">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama paket..."
            class="w-full sm:w-auto lg:w-64 rounded-xl border border-gray-900
                    px-4 py-2.5 text-sm bg-white
                    focus:border-gray-900 focus:ring-gray-900"
        >

        <select
            name="status"
            onchange="this.form.submit()"
            class="w-full sm:w-auto rounded-xl border border-gray-900
                    px-4 py-2.5 text-sm bg-white
                    focus:border-gray-900 focus:ring-gray-900">

            <option value="">Semua Status</option>

            <option value="1"
                {{ request('status') === '1' ? 'selected' : '' }}>
                Aktif
            </option>

            <option value="0"
                {{ request('status') === '0' ? 'selected' : '' }}>
                Tidak Aktif
            </option>

        </select>

        <button
            type="submit"
            class="w-full sm:w-auto px-4 py-2.5 rounded-xl
                bg-gray-900 text-white
                text-sm font-medium
                hover:bg-gray-800">
            Cari
        </button>

        @if(request('search') || request('status'))
            <a href="{{ route('admin.packages.index') }}"
                class="w-full sm:w-auto text-center px-4 py-2.5 rounded-xl bg-white
                    border border-gray-900
                    text-sm font-medium text-gray-900
                    hover:bg-gray-500">
                Reset
            </a>
        @endif

    </form>

    <a href="{{ route('admin.packages.create') }}"
        class="w-full lg:w-auto inline-flex items-center justify-center gap-2
        px-4 py-2.5 rounded-xl
        bg-gray-900 text-white
        text-sm font-medium
        hover:bg-gray-800 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-4 h-4"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 4v16m8-8H4"/>
        </svg>

        Tambah Paket

    </a>

</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6">

@forelse($packages as $package)

    <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-6">

        {{-- Header --}}
        <div class="flex justify-between">

            <div>

                <p class="text-sm text-gray-500">
                    {{ $package->nama_paket }}
                </p>

                <h2 class="text-xl sm:text-2xl font-bold mt-2">
                    Rp {{ number_format($package->harga_per_kg, 0, ',', '.') }}
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    / kg
                </p>

            </div>

            <span class="text-2xl">
                @if($package->nama_paket === 'Cuci Kering')
                    🧺
                @elseif($package->nama_paket === 'Cuci + Setrika')
                    👕
                @elseif($package->nama_paket === 'Setrika')
                    ♨
                @elseif($package->nama_paket === 'Express')
                    ⚡
                @else
                    📦
                @endif
            </span>

        </div>


        {{-- Deskripsi --}}
        @if($package->deskripsi)

            <p class="mt-4 text-sm leading-relaxed text-gray-500">
                {{ $package->deskripsi }}
            </p>

        @endif


        {{-- Estimasi --}}
        <div class="mt-5 flex justify-between text-sm">

            <span class="text-gray-500">
                Estimasi
            </span>

            <span class="font-medium">
                {{ $package->estimasi_hari }} hari
            </span>

        </div>


        {{-- Status --}}
        <div class="mt-4 flex justify-between items-center">

            <span class="text-sm text-gray-500">
                Status
            </span>

            @if($package->status)

                <span class="px-2.5 py-1 rounded-full
                             bg-gray-900 text-white text-xs">
                    Aktif
                </span>

            @else

                <span class="px-2.5 py-1 rounded-full
                             bg-gray-100 text-gray-500 text-xs">
                    Nonaktif
                </span>

            @endif

        </div>


        {{-- Action --}}
        <div class="mt-5 flex gap-2">

            <a href="{{ route('admin.packages.edit', $package) }}"
                class="inline-flex items-center justify-center
                w-9 h-9 rounded-lg
                text-gray-600 hover:bg-gray-100
                hover:text-gray-900 transition"
                title="Edit">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                                M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>

                    </svg>

            </a>

            <form action="{{ route('admin.packages.destroy', $package) }}"
                method="POST"
                class="inline"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket {{ $package->nama_paket }}?')">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="inline-flex items-center justify-center
                        w-9 h-9 rounded-lg
                        text-red-500 hover:bg-red-50
                        hover:text-red-600 transition"
                    title="Hapus">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7
                                m5 4v6m4-6v6
                                M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3
                                M4 7h16"/>

                    </svg>

                </button>

            </form>

        </div>

    </div>

@empty

    <div class="col-span-full bg-white border border-gray-200
                rounded-xl p-8 text-center">

        <p class="text-gray-500">
            Belum ada paket laundry.
        </p>

    </div>

@endforelse

</div>

@endsection
