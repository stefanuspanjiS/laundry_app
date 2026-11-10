<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Kasir Dashboard') - Laundry App
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="min-h-screen flex">

        {{-- =========================================================
            SIDEBAR KASIR
        ========================================================== --}}
        <aside class="w-64 bg-white border-r border-gray-200
                fixed inset-y-0 left-0 z-30
                overflow-y-auto">

            {{-- =====================================================
                LOGO & NAMA LAUNDRY
            ====================================================== --}}
            <div class="h-16 flex items-center px-5
                    border-b border-gray-200">

                @php
                    $setting = \App\Models\Setting::first();
                @endphp

                <div class="flex items-center gap-3 min-w-0">

                    {{-- Logo Laundry --}}
                    <div
                        class="w-10 h-10 rounded-full overflow-hidden
                               border border-gray-200 bg-gray-100
                               flex items-center justify-center
                               shrink-0"
                    >

                        @if($setting?->logo)

                            <img
                                src="{{ asset('uploads/logo/' . $setting->logo) }}"
                                alt="Logo {{ $setting->nama_laundry ?? 'Laundry' }}"
                                class="w-full h-full object-cover"
                            >

                        @else

                            <span class="text-sm font-bold text-gray-500">
                                {{ strtoupper(substr($setting?->nama_laundry ?? 'L', 0, 1)) }}
                            </span>

                        @endif

                    </div>


                    {{-- Nama Laundry --}}
                    <div class="min-w-0">

                        <h1 class="text-sm font-bold text-gray-900 truncate">
                            {{ $setting?->nama_laundry ?? "SAM'S LAUNDRY" }}
                        </h1>

                        <p class="text-xs text-gray-500">
                            Kasir Panel
                        </p>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                NAVIGATION
            ====================================================== --}}
            <nav class="p-4 space-y-1">

                {{-- Section: Menu Utama --}}
                <p
                    class="px-3 pt-2 pb-2
                           text-xs font-semibold
                           text-gray-400 uppercase tracking-wide"
                >
                    Menu Utama
                </p>


                {{-- =================================================
                    DASHBOARD
                ================================================== --}}
                <a
                    href="{{ route('kasir.dashboard') }}"
                    class="group flex items-center gap-3
                           w-full px-3 py-2.5 rounded-lg
                           text-sm font-medium
                           transition-all duration-200
                           {{ request()->routeIs('kasir.dashboard')
                                ? 'bg-gray-900 text-white'
                                : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 12l9-9 9 9"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"
                        />
                    </svg>

                    <span>
                        Dashboard
                    </span>

                </a>


                {{-- =================================================
                    PESANAN
                ================================================== --}}
                <a
                    href="{{ route('kasir.transactions.index') }}"
                    class="group flex items-center gap-3
                           w-full px-3 py-2.5 rounded-lg
                           text-sm font-medium
                           transition-all duration-200
                           {{ request()->routeIs('kasir.transactions.*')
                                ? 'bg-gray-900 text-white'
                                : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14 2v6h6"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8 13h8"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8 17h6"
                        />
                    </svg>

                    <span>
                        Pesanan
                    </span>

                </a>


                {{-- =================================================
                    PEMBAYARAN
                ================================================== --}}
                <a
                    href="{{ route('kasir.payments.index') }}"
                    class="group flex items-center gap-3
                           w-full px-3 py-2.5 rounded-lg
                           text-sm font-medium
                           transition-all duration-200
                           {{ request()->routeIs('kasir.payments.*')
                                ? 'bg-gray-900 text-white'
                                : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect
                            x="2"
                            y="5"
                            width="20"
                            height="14"
                            rx="2"
                            ry="2"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2 10h20"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 15h4"
                        />
                    </svg>

                    <span>
                        Pembayaran
                    </span>

                </a>


                {{-- =================================================
                    LOGOUT
                ================================================== --}}
                <div class="pt-4 mt-3 border-t border-gray-100">

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="group flex items-center gap-3
                                   w-full px-3 py-2.5 rounded-lg
                                   text-sm font-medium
                                   text-red-600
                                   hover:bg-red-50 hover:text-red-700
                                   transition-all duration-200"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 shrink-0"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 15l3-3m0 0l-3-3m3 3H3"
                                />
                            </svg>

                            <span>
                                Logout
                            </span>

                        </button>

                    </form>

                </div>

            </nav>

        </aside>


        {{-- =========================================================
            MAIN CONTENT
        ========================================================== --}}
        <div class="ml-64 flex-1 min-h-screen">

            {{-- =====================================================
                TOP NAVBAR
            ====================================================== --}}
            <header
                class="h-16 bg-white border-b border-gray-200
                       flex items-center justify-between
                       px-8 sticky top-0 z-20"
            >

                {{-- Page Title --}}
                <div>

                    @php

                        $pageTitle = match (true) {

                            request()->routeIs('kasir.dashboard')
                                => 'Dashboard',

                            request()->routeIs('kasir.transactions.*')
                                => 'Pesanan',

                            request()->routeIs('kasir.payments.*')
                                => 'Pembayaran',

                            default
                                => 'Dashboard',

                        };

                    @endphp

                    <h2 class="font-semibold text-gray-800">
                        {{ $pageTitle }}
                    </h2>

                </div>


                {{-- User Information --}}
                <div class="flex items-center gap-3">

                    <div class="text-right">

                        <p class="text-sm font-semibold text-gray-800">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-xs text-gray-500">
                            {{ ucfirst(auth()->user()->role) }}
                        </p>

                    </div>


                    {{-- User Avatar --}}
                    <div
                        class="w-10 h-10 rounded-full
                               bg-gray-900 text-white
                               flex items-center justify-center
                               font-semibold"
                    >
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                </div>

            </header>


            {{-- =====================================================
                PAGE CONTENT
            ====================================================== --}}
            <main class="p-8">

                {{-- Success Message --}}
                @if (session('success'))

                    <div
                        class="mb-6 rounded-lg
                               border border-green-200
                               bg-green-50 px-4 py-3
                               text-sm text-green-700"
                    >
                        {{ session('success') }}
                    </div>

                @endif


                {{-- Error Message --}}
                @if (session('error'))

                    <div
                        class="mb-6 rounded-lg
                               border border-red-200
                               bg-red-50 px-4 py-3
                               text-sm text-red-700"
                    >
                        {{ session('error') }}
                    </div>

                @endif


                {{-- Validation Error --}}
                @if ($errors->any())

                    <div
                        class="mb-6 rounded-lg
                               border border-red-200
                               bg-red-50 px-4 py-3"
                    >

                        <p class="mb-2 text-sm font-semibold text-red-700">
                            Terdapat kesalahan:
                        </p>

                        <ul class="list-inside list-disc text-sm text-red-600">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                @yield('content')

            </main>

        </div>

    </div>

</body>

</html>
