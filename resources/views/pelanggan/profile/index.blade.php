@extends('layouts.pelanggan')

@section('content')

<div class="space-y-5 sm:space-y-6">

    <div>
        <h1 class="text-xl font-bold text-gray-800 sm:text-2xl">
            Profil
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Kelola informasi akun pelanggan kamu.
        </p>
    </div>

    <div class="rounded-xl border border-gray-100 bg-white shadow-sm">

        <div class="p-4 sm:p-6">

            <div class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2">

                <div class="min-w-0">
                    <label class="text-sm font-medium text-gray-600">
                        Nama
                    </label>

                    <div class="mt-2 break-words rounded-lg bg-gray-50 px-4 py-3 text-gray-800">
                        {{ auth()->user()->name }}
                    </div>
                </div>

                <div class="min-w-0">
                    <label class="text-sm font-medium text-gray-600">
                        Email
                    </label>

                    <div class="mt-2 break-words rounded-lg bg-gray-50 px-4 py-3 text-gray-800">
                        {{ auth()->user()->email }}
                    </div>
                </div>

                <div class="min-w-0">
                    <label class="text-sm font-medium text-gray-600">
                        Nomor Telepon
                    </label>

                    <div class="mt-2 break-words rounded-lg bg-gray-50 px-4 py-3 text-gray-800">
                        {{ auth()->user()->phone ?? '-' }}
                    </div>
                </div>

                <div class="min-w-0">
                    <label class="text-sm font-medium text-gray-600">
                        Role
                    </label>

                    <div class="mt-2 rounded-lg bg-gray-50 px-4 py-3 text-gray-800">
                        Pelanggan
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection
