@extends('layouts.admin')

@section('title', 'User')
@section('page-title', 'Manajemen User')
@section('content')

@if(session('success'))
    <div class="mb-6 rounded-xl border border-green-200
                bg-green-50 px-4 py-3">

        <p class="text-sm font-medium text-green-700">
            {{ session('success') }}
        </p>

    </div>
@endif

@if(session('error'))
    <div class="mb-6 rounded-xl border border-red-200
                bg-red-50 px-4 py-3">

        <p class="text-sm font-medium text-red-700">
            {{ session('error') }}
        </p>

    </div>
@endif

<div class="mb-6 sm:mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div class="min-w-0">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
            Manajemen User
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Kelola data admin, kasir, dan pelanggan.
        </p>
    </div>

    <a href="{{ route('admin.users.create') }}"
        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5
        rounded-xl bg-gray-900 text-white
        text-sm font-medium hover:bg-gray-800 transition">

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

        Tambah User
    </a>

</div>


<div class="bg-white rounded-xl border border-gray-200">

    <div class="p-4 sm:p-5 border-b border-gray-200">

        <form
            method="GET"
            action="{{ route('admin.users.index') }}"
            class="flex flex-col sm:flex-row sm:items-center gap-3"
        >

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama, email, atau no HP..."
                class="w-full sm:flex-1 lg:w-80 lg:flex-none
                    px-4 py-2.5 border border-gray-300 rounded-lg
                    text-sm focus:outline-none focus:ring-2 focus:ring-gray-900"
            >

            <select
                name="role"
                onchange="this.form.submit()"
                class="w-full sm:w-auto
                       px-4 py-2.5 border border-gray-300
                       rounded-lg text-sm"
            >

                <option value="">
                    Semua Role
                </option>

                <option value="admin"
                    {{ request('role') === 'admin' ? 'selected' : '' }}>
                    Admin
                </option>

                <option value="kasir"
                    {{ request('role') === 'kasir' ? 'selected' : '' }}>
                    Kasir
                </option>

                <option value="pelanggan"
                    {{ request('role') === 'pelanggan' ? 'selected' : '' }}>
                    Pelanggan
                </option>

            </select>

            <button
                type="submit"
                class="w-full sm:w-auto
                       px-4 py-2.5
                       bg-gray-900 text-white
                       rounded-lg text-sm"
            >
                Cari
            </button>

            @if(request('search') || request('role'))

                <a
                    href="{{ route('admin.users.index') }}"
                    class="w-full sm:w-auto
                        px-4 py-2.5
                        border border-gray-300
                        rounded-lg
                        text-sm text-center
                        hover:bg-gray-50"
                >
                    Reset
                </a>

            @endif

        </form>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full min-w-[800px] text-sm">

            <thead class="bg-gray-50">

                <tr class="text-left text-gray-500">

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        No
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Nama
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Email
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        No. HP
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4">
                        Role
                    </th>

                    <th class="px-4 sm:px-6 py-3 sm:py-4 text-center">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-100">

                @forelse($users as $user)

                    <tr>

                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 sm:px-6 py-3 sm:py-4
                                   font-medium text-gray-900
                                   break-words">
                            {{ $user->name }}
                        </td>

                        <td class="px-4 sm:px-6 py-3 sm:py-4
                                   text-gray-600
                                   break-words">
                            {{ $user->email }}
                        </td>

                        <td class="px-4 sm:px-6 py-3 sm:py-4
                                   text-gray-600
                                   whitespace-nowrap">
                            {{ $user->phone ?? '-' }}
                        </td>

                        <td class="px-4 sm:px-6 py-3 sm:py-4">

                            @if($user->role === 'admin')

                                <span class="inline-flex px-2.5 py-1 rounded-full
                                             bg-gray-900 text-white text-xs
                                             whitespace-nowrap">
                                    Admin
                                </span>

                            @elseif($user->role === 'kasir')

                                <span class="inline-flex px-2.5 py-1 rounded-full
                                             bg-gray-100 text-gray-700 text-xs
                                             whitespace-nowrap">
                                    Kasir
                                </span>

                            @else

                                <span class="inline-flex px-2.5 py-1 rounded-full
                                             bg-gray-100 text-gray-700 text-xs
                                             whitespace-nowrap">
                                    Pelanggan
                                </span>

                            @endif

                        </td>

                        <td class="px-4 sm:px-6 py-3 sm:py-4 text-center">

                            <div class="flex items-center justify-center gap-1">

                                {{-- Edit --}}
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="inline-flex items-center justify-center
                                    w-9 h-9 rounded-lg
                                    text-gray-600 hover:bg-gray-100
                                    hover:text-gray-900 transition
                                    shrink-0"
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

                                {{-- Delete --}}
                                <form action="{{ route('admin.users.destroy', $user) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center
                                            w-9 h-9 rounded-lg
                                            text-red-500 hover:bg-red-50
                                            hover:text-red-600 transition
                                            shrink-0"
                                        title="Hapus">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-4 h-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                                    M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3
                                                    M4 7h16"/>
                                        </svg>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="px-4 sm:px-6 py-8 text-center text-gray-500"
                        >
                            Belum ada data user.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
