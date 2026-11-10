@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Laundry')

@section('content')

<div class="mb-6 sm:mb-8">

    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
        Pengaturan Laundry
    </h1>

    <p class="mt-1 text-sm text-gray-500">
        Kelola informasi utama laundry.
    </p>

</div>

<div class="max-w-4xl">

    {{-- Pesan sukses --}}
    @if(session('success'))

        <div class="mb-6 bg-gray-900 text-white rounded-lg px-4 sm:px-5 py-3 text-sm">
            {{ session('success') }}
        </div>

    @endif

    {{-- Error validasi --}}
    @if($errors->any())

        <div class="mb-6 bg-gray-100 border border-gray-300 rounded-lg px-4 sm:px-5 py-4">

            <p class="font-medium text-gray-900 mb-2">
                Terdapat kesalahan:
            </p>

            <ul class="list-disc list-inside text-sm text-gray-600">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="bg-white border border-gray-200 rounded-xl">

        <div class="p-4 sm:p-6 border-b border-gray-200">

            <h2 class="font-semibold text-gray-900">
                Informasi Laundry
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Informasi ini dapat digunakan pada invoice dan laporan.
            </p>

        </div>


        {{-- Form --}}
        <form
            action="{{ route('admin.settings.update') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')


            <div class="p-4 sm:p-6 space-y-5 sm:space-y-6">

                {{-- Nama Laundry --}}
                <div>

                    <label class="block text-sm font-medium mb-2">
                        Nama Laundry
                    </label>

                    <input
                        type="text"
                        name="nama_laundry"
                        value="{{ old('nama_laundry', $setting?->nama_laundry) }}"
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-2.5 focus:outline-none
                               focus:ring-2 focus:ring-gray-900"
                        required
                    >

                </div>


                {{-- Nama Pemilik --}}
                <div>

                    <label class="block text-sm font-medium mb-2">
                        Nama Pemilik
                    </label>

                    <input
                        type="text"
                        name="owner"
                        value="{{ old('owner', $setting?->owner) }}"
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-2.5 focus:outline-none
                               focus:ring-2 focus:ring-gray-900"
                        required
                    >

                </div>


                {{-- Email & Telepon --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $setting?->email) }}"
                            class="w-full border border-gray-300 rounded-lg
                                   px-4 py-2.5 focus:outline-none
                                   focus:ring-2 focus:ring-gray-900"
                        >

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            No. Telepon
                        </label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone', $setting?->phone) }}"
                            class="w-full border border-gray-300 rounded-lg
                                   px-4 py-2.5 focus:outline-none
                                   focus:ring-2 focus:ring-gray-900"
                        >

                    </div>

                </div>


                {{-- Alamat --}}
                <div>

                    <label class="block text-sm font-medium mb-2">
                        Alamat
                    </label>

                    <textarea
                        name="alamat"
                        rows="4"
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-2.5 focus:outline-none
                               focus:ring-2 focus:ring-gray-900"
                        required
                    >{{ old('alamat', $setting?->alamat) }}</textarea>

                </div>


                {{-- Logo --}}
                <div>

                    <label class="block text-sm font-medium mb-2">
                        Logo Laundry
                    </label>

                    <input
                        type="file"
                        name="logo"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="w-full border border-gray-300 rounded-lg
                               px-4 py-2.5"
                    >

                    <p class="mt-2 text-xs text-gray-500">
                        Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                    </p>


                    {{-- Logo saat ini --}}
                    @if($setting?->logo)

                        <div class="mt-4">

                            <p class="text-sm text-gray-500 mb-2">
                                Logo saat ini:
                            </p>

                            <img
                                src="{{ asset('uploads/logo/' . $setting->logo) }}"
                                alt="Logo Laundry"
                                class="h-20 w-auto max-w-full object-contain border
                                       border-gray-200 rounded-lg p-2"
                            >

                        </div>

                    @endif

                </div>

            </div>


            {{-- Footer --}}
            <div class="p-4 sm:p-6 border-t border-gray-200 flex justify-stretch sm:justify-end">

                <button
                    type="submit"
                    class="w-full sm:w-auto px-5 py-2.5 bg-gray-900 text-white rounded-lg
                           text-sm font-medium hover:bg-gray-800"
                >
                    Simpan Pengaturan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
