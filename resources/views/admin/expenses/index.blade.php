@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="min-w-0">

            <h1 class="text-xl font-bold text-gray-800 sm:text-2xl">
                Pengeluaran
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Kelola dan catat pengeluaran operasional laundry.
            </p>

        </div>

        <a
            href="{{ route('admin.expenses.create') }}"
            class="inline-flex w-full items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700 sm:w-auto"
        >
            + Tambah Pengeluaran
        </a>

    </div>


    {{-- Alert Success --}}
    @if(session('success'))

        <div class="rounded-lg border border-green-200 bg-green-50 p-4">

            <p class="text-sm font-medium text-green-700">
                {{ session('success') }}
            </p>

        </div>

    @endif


    {{-- Total --}}
    <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">

        <p class="text-sm text-gray-500">
            Total Pengeluaran
        </p>

        <p class="mt-2 text-2xl font-bold text-gray-800">
            Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
        </p>

        <p class="mt-1 text-xs text-gray-400">
            Berdasarkan data yang ditampilkan sesuai filter.
        </p>

    </div>


    {{-- Search & Filter --}}
    <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm sm:p-5">

        <form
            action="{{ route('admin.expenses.index') }}"
            method="GET"
            class="grid grid-cols-1 gap-3 md:grid-cols-[1fr_auto_auto]"
        >

            {{-- Search --}}
            <div>

                <label
                    for="search"
                    class="sr-only"
                >
                    Cari pengeluaran
                </label>

                <input
                    type="search"
                    name="search"
                    id="search"
                    value="{{ request('search') }}"
                    placeholder="Cari kategori atau keterangan..."
                    class="block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >

            </div>


            {{-- Kategori --}}
            <div>

                <label
                    for="kategori"
                    class="sr-only"
                >
                    Filter kategori
                </label>

                <select
                    name="kategori"
                    id="kategori"
                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-800 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >

                    <option value="">
                        Semua Kategori
                    </option>

                    @foreach($kategori as $item)

                        <option
                            value="{{ $item }}"
                            @selected(request('kategori') === $item)
                        >
                            {{ $item }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Button --}}
            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-gray-900"
            >
                Cari
            </button>

        </form>

        @if(request()->filled('search') || request()->filled('kategori'))

            <div class="mt-3">

                <a
                    href="{{ route('admin.expenses.index') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-700"
                >
                    Reset Filter
                </a>

            </div>

        @endif

    </div>


    {{-- Data --}}
    <div class="rounded-xl border border-gray-100 bg-white shadow-sm">

        @if($pengeluaran->count() > 0)

            {{-- ================= DESKTOP ================= --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="min-w-full">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Tanggal
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Kategori
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Keterangan
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Jumlah
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($pengeluaran as $expense)

                            <tr class="transition hover:bg-gray-50">

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                    {{ $expense->tanggal?->format('d/m/Y') ?? '-' }}
                                </td>

                                <td class="px-6 py-4">

                                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                                        {{ $expense->kategori }}
                                    </span>

                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $expense->keterangan ?: '-' }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-semibold text-gray-800">
                                    Rp {{ number_format($expense->jumlah, 0, ',', '.') }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-right">

                                    <div class="inline-flex items-center gap-2">

                                        <a
                                            href="{{ route('admin.expenses.edit', $expense) }}"
                                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.expenses.destroy', $expense) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pengeluaran ini?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center rounded-lg bg-red-600 px-3 py-2 text-xs font-medium text-white transition hover:bg-red-700"
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- ================= MOBILE ================= --}}
            <div class="divide-y divide-gray-100 md:hidden">

                @foreach($pengeluaran as $expense)

                    <div class="p-4 sm:p-5">

                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">

                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $expense->kategori }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $expense->tanggal?->format('d/m/Y') ?? '-' }}
                                </p>

                            </div>

                            <span class="shrink-0 rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-700">
                                Pengeluaran
                            </span>

                        </div>


                        <div class="mt-4">

                            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                                Keterangan
                            </p>

                            <p class="mt-1 break-words text-sm text-gray-600">
                                {{ $expense->keterangan ?: '-' }}
                            </p>

                        </div>


                        <div class="mt-4 rounded-lg bg-gray-50 p-3">

                            <p class="text-xs text-gray-500">
                                Jumlah
                            </p>

                            <p class="mt-1 text-lg font-bold text-gray-800">
                                Rp {{ number_format($expense->jumlah, 0, ',', '.') }}
                            </p>

                        </div>


                        <div class="mt-4 flex gap-2">

                            <a
                                href="{{ route('admin.expenses.edit', $expense) }}"
                                class="inline-flex flex-1 items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('admin.expenses.destroy', $expense) }}"
                                method="POST"
                                class="flex-1"
                                onsubmit="return confirm('Yakin ingin menghapus pengeluaran ini?')"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-lg bg-red-600 px-3 py-2.5 text-xs font-medium text-white transition hover:bg-red-700"
                                >
                                    Hapus
                                </button>

                            </form>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- Pagination --}}
            <div class="border-t border-gray-100 px-4 py-4 sm:px-6">

                {{ $pengeluaran->links() }}

            </div>

        @else

            <div class="p-8 text-center sm:p-10">

                <h2 class="text-lg font-semibold text-gray-800">
                    Belum Ada Pengeluaran
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Belum ada data pengeluaran yang tercatat.
                </p>

                <a
                    href="{{ route('admin.expenses.create') }}"
                    class="mt-5 inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700"
                >
                    Tambah Pengeluaran
                </a>

            </div>

        @endif

    </div>

</div>

@endsection
