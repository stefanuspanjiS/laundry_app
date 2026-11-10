@extends('layouts.admin')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">

        <div class="min-w-0">

            <p class="text-sm text-gray-500 mb-1">
                Update Status Laundry
            </p>

            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 break-all">
                {{ $transaction->invoice }}
            </h2>

            <p class="text-sm text-gray-500 mt-1 break-words">
                {{ $transaction->customer->name }}
            </p>

        </div>

        <a
            href="{{ route(
                'admin.transactions.show',
                $transaction
            ) }}"
            class="w-full sm:w-auto
                   px-4 py-2.5 rounded-xl
                   border border-gray-200
                   text-sm font-medium
                   text-gray-700
                   text-center
                   hover:bg-gray-50"
        >
            Kembali
        </a>

    </div>


    {{-- Error --}}
    @if ($errors->any())

        <div class="mb-6 rounded-xl
                    border border-red-200
                    bg-red-50 p-4">

            <ul class="text-sm text-red-600 space-y-1">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Session --}}
    @if(session('error'))

        <div class="mb-6 rounded-xl
                    border border-red-200
                    bg-red-50 px-4 py-3">

            <p class="text-sm
                      font-medium
                      text-red-700">
                {{ session('error') }}
            </p>

        </div>

    @endif


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-6">

        {{-- Form --}}
        <div class="lg:col-span-2">

            <div class="bg-white rounded-2xl
                        border border-gray-200
                        shadow-sm">

                <div class="p-4 sm:p-6
                            border-b border-gray-100">

                    <h3 class="font-semibold
                               text-gray-900">
                        Perbarui Status
                    </h3>

                    <p class="text-sm
                              text-gray-500 mt-1">
                        Status harus diperbarui sesuai urutan proses laundry.
                    </p>

                </div>


                <form
                    action="{{ route(
                        'admin.transactions.status.update',
                        $transaction
                    ) }}"
                    method="POST"
                    class="p-4 sm:p-6 space-y-6"
                >

                    @csrf
                    @method('PUT')


                    {{-- Status --}}
                    <div>

                        <label
                            class="block text-sm
                                   font-medium
                                   text-gray-700 mb-2"
                        >
                            Status Baru
                        </label>

                        <select
                            name="status"
                            required
                            class="w-full rounded-xl
                                   border border-gray-300
                                   px-4 py-3 text-sm
                                   focus:border-gray-900
                                   focus:ring-gray-900"
                        >

                            @foreach(
                                $statuses
                                as $value => $label
                            )

                                <option
                                    value="{{ $value }}"
                                    {{ $transaction->status_laundry === $value
                                        ? 'selected'
                                        : '' }}
                                >
                                    {{ $label }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Keterangan --}}
                    <div>

                        <label
                            class="block text-sm
                                   font-medium
                                   text-gray-700 mb-2"
                        >
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            rows="4"
                            placeholder="Contoh: Laundry sudah selesai dicuci."
                            class="w-full rounded-xl
                                   border border-gray-300
                                   px-4 py-3 text-sm
                                   focus:border-gray-900
                                   focus:ring-gray-900"
                        >{{ old('keterangan') }}</textarea>

                    </div>


                    <div class="flex justify-stretch sm:justify-end">

                        <button
                            type="submit"
                            class="w-full sm:w-auto
                                   px-5 py-2.5
                                   rounded-xl
                                   bg-gray-900
                                   text-white
                                   text-sm font-medium
                                   hover:bg-gray-800"
                        >
                            Update Status
                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- Timeline --}}
        <div>

            <div class="bg-white rounded-2xl
                        border border-gray-200
                        shadow-sm p-4 sm:p-6">

                <h3 class="font-semibold
                           text-gray-900 mb-6">
                    Riwayat Status
                </h3>


                <div class="space-y-6">

                    @forelse(
                        $transaction->laundryStatuses
                        ->sortByDesc('created_at')
                        as $history
                    )

                        <div class="relative pl-7">

                            {{-- Dot --}}
                            <div class="absolute left-0 top-1
                                        w-3 h-3
                                        rounded-full
                                        bg-gray-900
                                        ring-4 ring-gray-100">
                            </div>


                            {{-- Line --}}
                            @if(!$loop->last)

                                <div class="absolute
                                            left-[5px]
                                            top-4
                                            bottom-[-24px]
                                            w-px
                                            bg-gray-200">
                                </div>

                            @endif


                            <p class="text-sm
                                      font-semibold
                                      text-gray-900">

                                {{ ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $history->status
                                    )
                                ) }}

                            </p>


                            @if($history->keterangan)

                                <p class="text-xs
                                          text-gray-500 mt-1
                                          break-words">

                                    {{ $history->keterangan }}

                                </p>

                            @endif


                            <p class="text-xs
                                      text-gray-400 mt-2
                                      break-words">

                                {{ $history->updater->name
                                    ?? 'System' }}

                                ·

                                {{ $history->created_at
                                    ->format('d M Y H:i') }}

                            </p>

                        </div>

                    @empty

                        <p class="text-sm text-gray-500">
                            Belum ada riwayat status.
                        </p>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
