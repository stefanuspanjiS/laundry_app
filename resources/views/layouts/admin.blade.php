<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Admin Dashboard') - Laundry App
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex">

        {{-- =========================================================
            SIDEBAR
        ========================================================== --}}
        <aside  class="w-64 bg-white border-r border-gray-200
                fixed inset-y-0 left-0 z-30
                overflow-y-auto
                transform transition-transform duration-300 ease-in-out
                -translate-x-full lg:translate-x-0"
                :class="{ 'translate-x-0': sidebarOpen }"
        >

            {{-- Logo & Nama Laundry --}}
            <div
                class="h-16 flex items-center px-5
                       border-b border-gray-200"
            >

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

                        <h1
                            class="text-sm font-bold text-gray-900 truncate"
                        >
                            {{ $setting?->nama_laundry ?? "SAM'S LAUNDRY" }}
                        </h1>

                        <p class="text-xs text-gray-500">
                            Admin Panel
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
                    href="{{ route('admin.dashboard') }}"
                    class="group flex items-center gap-3
                           w-full px-3 py-2.5 rounded-lg
                           text-sm font-medium
                           transition-all duration-200
                           {{ request()->routeIs('admin.dashboard')
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

                    <span>Dashboard</span>

                </a>


                {{-- =================================================
                    USER
                ================================================== --}}
                <a
                    href="{{ route('admin.users.index') }}"
                    class="group flex items-center gap-3
                           w-full px-3 py-2.5 rounded-lg
                           text-sm font-medium
                           transition-all duration-200
                           {{ request()->routeIs('admin.users.*')
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
                            d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                        />

                        <circle
                            cx="9"
                            cy="7"
                            r="4"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M22 21v-2a4 4 0 00-3-3.87"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16 3.13a4 4 0 010 7.75"
                        />
                    </svg>

                    <span>User</span>

                </a>


                {{-- =================================================
                    PAKET LAUNDRY
                ================================================== --}}
                <a
                    href="{{ route('admin.packages.index') }}"
                    class="group flex items-center gap-3
                           w-full px-3 py-2.5 rounded-lg
                           text-sm font-medium
                           transition-all duration-200
                           {{ request()->routeIs('admin.packages.*')
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
                            d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.27 6.96L12 12l8.73-5.04"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 22V12"
                        />
                    </svg>

                    <span>Paket Laundry</span>

                </a>


                {{-- =================================================
                    TRANSAKSI
                ================================================== --}}
                <a
                    href="{{ route('admin.transactions.index') }}"
                    class="group flex items-center gap-3
                           w-full px-3 py-2.5 rounded-lg
                           text-sm font-medium
                           transition-all duration-200
                           {{ request()->routeIs('admin.transactions.*')
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

                    <span>Transaksi</span>

                </a>


                {{-- =================================================
                    PESANAN
                ================================================== --}}
                <a
                    href="{{ route('admin.pesanan.index') }}"
                    class="group flex items-center gap-3
                           w-full px-3 py-2.5 rounded-lg
                           text-sm font-medium
                           transition-all duration-200
                           {{ request()->routeIs('admin.pesanan.*')
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
                            d="M20 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"
                        />
                    </svg>

                    <span>Pesanan</span>

                </a>


                {{-- =================================================
                    PEMBAYARAN
                ================================================== --}}
                <a
                    href="{{ route('admin.payments.index') }}"
                    class="group flex items-center gap-3
                           w-full px-3 py-2.5 rounded-lg
                           text-sm font-medium
                           transition-all duration-200
                           {{ request()->routeIs('admin.payments.*')
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

                    <span>Pembayaran</span>

                </a>


                {{-- =================================================
                    SECTION LAINNYA
                ================================================== --}}
                <p
                    class="px-3 pt-6 pb-2
                           text-xs font-semibold
                           text-gray-400 uppercase tracking-wide"
                >
                    Lainnya
                </p>


                {{-- =================================================
                    LAPORAN
                ================================================== --}}
                <a
                    href="{{ route('admin.reports.index') }}"
                    class="group flex items-center gap-3
                           w-full px-3 py-2.5 rounded-lg
                           text-sm font-medium
                           transition-all duration-200
                           {{ request()->routeIs('admin.reports.*')
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
                            d="M4 19V5"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 17l5-5 4 3 7-8"
                        />
                    </svg>

                    <span>Laporan</span>

                </a>

                {{-- =================================================
                    PENGELUARAN
                ================================================== --}}
                <a
                    href="{{ route('admin.expenses.index') }}"
                    class="group flex items-center gap-3
                           w-full px-3 py-2.5 rounded-lg
                           text-sm font-medium
                           transition-all duration-200
                           {{ request()->routeIs('admin.expenses.*')
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
                            d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-2.25-3.75 2.25-3.75-2.25-3.75 2.25V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M10.5 7.5h.008v.008h-.008V7.5zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                        />
                    </svg>

                    <span>Pengeluaran</span>

                </a>


                {{-- =================================================
                    PENGATURAN
                ================================================== --}}
                <a
                    href="{{ route('admin.settings.index') }}"
                    class="group flex items-center gap-3
                           w-full px-3 py-2.5 rounded-lg
                           text-sm font-medium
                           transition-all duration-200
                           {{ request()->routeIs('admin.settings.*')
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
                            d="M12 15.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.6 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.6h.09A1.65 1.65 0 0010 3.09V3a2 2 0 014 0v.09A1.65 1.65 0 0015 4.6a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9v.09A1.65 1.65 0 0020.91 10H21a2 2 0 010 4h-.09A1.65 1.65 0 0019.4 15z"
                        />
                    </svg>

                    <span>Pengaturan</span>

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

                            <span>Logout</span>

                        </button>

                    </form>

                </div>

            </nav>

        </aside>

        <div
            x-show="sidebarOpen"
            x-transition.opacity
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/40 z-20 lg:hidden"
            x-cloak
        ></div>


        {{-- =========================================================
            MAIN CONTENT
        ========================================================== --}}
        <div class="lg:ml-64 flex-1 min-h-screen">

            {{-- =====================================================
                TOP NAVBAR
            ====================================================== --}}
            <header
                class="h-16 bg-white border-b border-gray-200
                flex items-center
                px-4 sm:px-6 lg:px-8
                sticky top-0 z-20"
            >

            {{-- Left Side --}}
            <div class="flex items-center gap-3 min-w-0 flex-1">

                {{-- Mobile Menu Button --}}
                <button
                    type="button"
                    @click="sidebarOpen = true"
                    class="lg:hidden inline-flex items-center justify-center
                        w-10 h-10 rounded-lg
                        text-gray-600 hover:bg-gray-100 hover:text-gray-900
                        transition shrink-0"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                </button>

                {{-- Page Title --}}
                <div>

                    @php
                        $pageTitle = match (true) {

                            request()->routeIs('admin.dashboard')
                                => 'Dashboard',

                            request()->routeIs('admin.users.*')
                                => 'User',

                            request()->routeIs('admin.packages.*')
                                => 'Paket Laundry',

                            request()->routeIs('admin.transactions.*')
                                => 'Transaksi',

                            request()->routeIs('admin.pesanan.*')
                                => 'Pesanan',

                            request()->routeIs('admin.payments.*')
                                => 'Pembayaran',

                            request()->routeIs('admin.reports.*')
                                => 'Laporan',

                            request()->routeIs('admin.settings.*')
                                => 'Pengaturan',

                            default
                                => 'Dashboard',
                        };
                    @endphp

                    <h2 class="font-semibold text-gray-800">
                        {{ $pageTitle }}
                    </h2>

                </div>

                {{-- User Information --}}
                <div class="flex items-center gap-3 shrink-0 ml-auto">

                    <div class="text-right">

                        <p class="hidden sm:block text-sm font-semibold text-gray-800">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="hidden sm:block text-xs text-gray-500">
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
            <main class="p-4 sm:p-6 lg:p-8">

                @yield('content')

            </main>

        </div>

    </div>

    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
    ></script>

</body>

</html>

