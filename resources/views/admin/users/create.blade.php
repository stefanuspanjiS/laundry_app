@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">

        <div class="min-w-0">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                Tambah User
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Tambahkan akun admin, kasir, atau pelanggan baru.
            </p>
        </div>

        <a href="{{ route('admin.users.index') }}"
           class="w-full sm:w-auto
                  px-4 py-2.5 rounded-xl border border-gray-200
                  text-sm font-medium text-gray-700
                  text-center
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

        <form action="{{ route('admin.users.store') }}"
              method="POST"
              class="p-4 sm:p-6 space-y-6">

            @csrf

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap"
                    required
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 text-sm
                           focus:border-gray-900 focus:ring-gray-900"
                >

                @error('name')
                    <p class="text-sm text-red-500 mt-1 break-words">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@email.com"
                    required
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 text-sm
                           focus:border-gray-900 focus:ring-gray-900"
                >

                @error('email')
                    <p class="text-sm text-red-500 mt-1 break-words">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Phone --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor HP
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="08xxxxxxxxxx"
                    required
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 text-sm
                           focus:border-gray-900 focus:ring-gray-900"
                >

                @error('phone')
                    <p class="text-sm text-red-500 mt-1 break-words">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Role --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Role
                </label>

                <select
                    name="role"
                    required
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 text-sm
                           focus:border-gray-900 focus:ring-gray-900"
                >
                    <option value="">Pilih Role</option>

                    <option value="admin"
                        {{ old('role') === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="kasir"
                        {{ old('role') === 'kasir' ? 'selected' : '' }}>
                        Kasir
                    </option>

                    <option value="pelanggan"
                        {{ old('role') === 'pelanggan' ? 'selected' : '' }}>
                        Pelanggan
                    </option>
                </select>

                @error('role')
                    <p class="text-sm text-red-500 mt-1 break-words">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    required
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 text-sm
                           focus:border-gray-900 focus:ring-gray-900"
                >

                @error('password')
                    <p class="text-sm text-red-500 mt-1 break-words">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Confirm Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    required
                    class="w-full rounded-xl border border-gray-300
                           px-4 py-3 text-sm
                           focus:border-gray-900 focus:ring-gray-900"
                >
            </div>


            {{-- Button --}}
            <div class="flex flex-col-reverse sm:flex-row
                        justify-stretch sm:justify-end
                        gap-3 pt-4 border-t border-gray-100">

                <a href="{{ route('admin.users.index') }}"
                   class="w-full sm:w-auto
                          px-5 py-2.5 rounded-xl border border-gray-200
                          text-sm font-medium text-gray-700
                          text-center
                          hover:bg-gray-50">
                    Batal
                </a>

                <button
                    type="submit"
                    class="w-full sm:w-auto
                           px-5 py-2.5 rounded-xl bg-gray-900
                           text-white text-sm font-medium
                           hover:bg-gray-800 transition">
                    Simpan User
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
