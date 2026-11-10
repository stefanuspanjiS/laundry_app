<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Dashboard')
        -
        {{ $setting?->nama_laundry ?? "SAM'S LAUNDRY" }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

</head>


<body
    class="bg-gray-100 text-gray-800"
    x-data="{ sidebarOpen: false }"
>

    <div class="min-h-screen flex">


        {{-- =========================================================
            SIDEBAR
        ========================================================== --}}
        <aside
            class="w-64 bg-white
                   border-r border-gray-200
                   fixed inset-y-0 left-0 z-30
                   flex flex-col
                   overflow-y-auto
                   transform transition-transform duration-300 ease-in-out
                   -translate-x-full lg:translate-x-0"
            :class="{ 'translate-x-0': sidebarOpen }"
        >

            {{-- =====================================================
                LOGO & NAMA LAUNDRY
            ====================================================== --}}
            <div
                class="h-16
                       flex items-center
                       px-5
                       border-b border-gray-200
                       shrink-0"
            >

                @php
                    $setting = \App\Models\Setting::first();
                @endphp


                <div
                    class="flex items-center
                           gap-3
                           min-w-0"
                >

                    {{-- Logo --}}
                    <div
                        class="w-10 h-10
                               rounded-full
                               overflow-hidden
                               border border-gray-200
                               bg-gray-100
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

                            <span
                                class="text-sm
                                       font-bold
                                       text-gray-500"
                            >
                                {{ strtoupper(substr($setting?->nama_laundry ?? 'L', 0, 1)) }}
                            </span>

                        @endif

                    </div>


                    {{-- Nama Laundry --}}
                    <div class="min-w-0">

                        <h1
                            class="text-sm
                                   font-bold
                                   text-gray-900
                                   truncate"
                        >
                            {{ $setting?->nama_laundry ?? "SAM'S LAUNDRY" }}
                        </h1>

                        <p class="text-xs text-gray-500">
                            Customer Panel
                        </p>

                    </div>

                </div>

            </div>



            {{-- =====================================================
                NAVIGATION
            ====================================================== --}}
            <nav
                class="flex-1
                       overflow-y-auto
                       p-4
                       space-y-1"
            >

                {{-- Section --}}
                <p
                    class="px-3
                           pt-2
                           pb-2
                           text-xs
                           font-semibold
                           text-gray-400
                           uppercase
                           tracking-wide"
                >
                    Menu Utama
                </p>



                {{-- =================================================
                    DASHBOARD
                ================================================== --}}
                <a
                    href="{{ route('pelanggan.dashboard') }}"
                    class="group
                           flex items-center
                           gap-3
                           w-full
                           px-3 py-2.5
                           rounded-lg
                           text-sm
                           font-medium
                           transition-all
                           duration-200
                           {{ request()->routeIs('pelanggan.dashboard')
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
                    BUAT PESANAN
                ================================================== --}}
                <a
                    href="{{ route('pelanggan.orders.create') }}"
                    class="group
                           flex items-center
                           gap-3
                           w-full
                           px-3 py-2.5
                           rounded-lg
                           text-sm
                           font-medium
                           transition-all
                           duration-200
                           {{ request()->routeIs('pelanggan.orders.create')
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
                            d="M12 5v14"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 12h14"
                        />

                    </svg>

                    <span>
                        Buat Pesanan
                    </span>

                </a>



                {{-- =================================================
                    PESANAN SAYA
                ================================================== --}}
                <a
                    href="{{ route('pelanggan.orders.index') }}"
                    class="group
                           flex items-center
                           gap-3
                           w-full
                           px-3 py-2.5
                           rounded-lg
                           text-sm
                           font-medium
                           transition-all
                           duration-200
                           {{ request()->routeIs('pelanggan.orders.*')
                                && !request()->routeIs('pelanggan.orders.create')
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
                            x="3"
                            y="4"
                            width="18"
                            height="16"
                            rx="2"
                            ry="2"
                        />

                        <path
                            d="M7 8h10"
                        />

                        <path
                            d="M7 12h6"
                        />

                        <path
                            d="M7 16h4"
                        />

                    </svg>

                    <span>
                        Pesanan Saya
                    </span>

                </a>



                {{-- =================================================
                    PEMBAYARAN
                ================================================== --}}
                <a
                    href="{{ route('pelanggan.payments.index') }}"
                    class="group
                           flex items-center
                           gap-3
                           w-full
                           px-3 py-2.5
                           rounded-lg
                           text-sm
                           font-medium
                           transition-all
                           duration-200
                           {{ request()->routeIs('pelanggan.payments.*')
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
                            d="M2 10h20"
                        />

                        <path
                            d="M6 15h4"
                        />

                    </svg>

                    <span>
                        Pembayaran
                    </span>

                </a>



                {{-- =================================================
                    RIWAYAT
                ================================================== --}}
                <a
                    href="{{ route('pelanggan.history.index') }}"
                    class="group
                           flex items-center
                           gap-3
                           w-full
                           px-3 py-2.5
                           rounded-lg
                           text-sm
                           font-medium
                           transition-all
                           duration-200
                           {{ request()->routeIs('pelanggan.history.*')
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
                            d="M3 12a9 9 0 1018 0 9 9 0 00-18 0z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 7v5l3 2"
                        />

                    </svg>

                    <span>
                        Riwayat
                    </span>

                </a>



                {{-- =================================================
                    SECTION AKUN
                ================================================== --}}
                <p
                    class="px-3
                           pt-6
                           pb-2
                           text-xs
                           font-semibold
                           text-gray-400
                           uppercase
                           tracking-wide"
                >
                    Akun
                </p>



                {{-- =================================================
                    PROFIL
                ================================================== --}}
                <a
                    href="{{ route('pelanggan.profile.index') }}"
                    class="group
                           flex items-center
                           gap-3
                           w-full
                           px-3 py-2.5
                           rounded-lg
                           text-sm
                           font-medium
                           transition-all
                           duration-200
                           {{ request()->routeIs('pelanggan.profile.*')
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

                        <circle
                            cx="12"
                            cy="8"
                            r="4"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 21a8 8 0 0116 0"
                        />

                    </svg>

                    <span>
                        Profil
                    </span>

                </a>



                {{-- =================================================
                    LOGOUT
                ================================================== --}}
                <div
                    class="pt-4
                           mt-3
                           border-t border-gray-100"
                >

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="group
                                   flex items-center
                                   gap-3
                                   w-full
                                   px-3 py-2.5
                                   rounded-lg
                                   text-sm
                                   font-medium
                                   text-red-600
                                   hover:bg-red-50
                                   hover:text-red-700
                                   transition-all
                                   duration-200"
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
            MOBILE SIDEBAR OVERLAY
        ========================================================== --}}
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
                class="h-16
                       bg-white
                       border-b border-gray-200
                       flex items-center
                       px-4 sm:px-6 lg:px-8
                       sticky top-0
                       z-20"
            >

                {{-- Left Side --}}
                <div
                    class="flex items-center
                           gap-3
                           min-w-0
                           flex-1"
                >

                    {{-- Mobile Menu Button --}}
                    <button
                        type="button"
                        @click="sidebarOpen = true"
                        class="lg:hidden
                               inline-flex items-center justify-center
                               w-10 h-10
                               rounded-lg
                               text-gray-600
                               hover:bg-gray-100
                               hover:text-gray-900
                               transition
                               shrink-0"
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
                    <div class="min-w-0">

                        @php
                            $pageTitle = match (true) {

                                request()->routeIs('pelanggan.dashboard')
                                    => 'Dashboard',

                                request()->routeIs('pelanggan.orders.create')
                                    => 'Buat Pesanan',

                                request()->routeIs('pelanggan.orders.*')
                                    => 'Pesanan Saya',

                                request()->routeIs('pelanggan.payments.*')
                                    => 'Pembayaran',

                                request()->routeIs('pelanggan.history.*')
                                    => 'Riwayat',

                                request()->routeIs('pelanggan.profile.*')
                                    => 'Profil',

                                default
                                    => 'Dashboard',
                            };
                        @endphp


                        <h2
                            class="font-semibold
                                   text-gray-800
                                   truncate"
                        >
                            {{ $pageTitle }}
                        </h2>

                    </div>

                </div>



                {{-- =================================================
                    USER INFO
                ================================================== --}}
                <div
                    class="flex items-center
                           gap-3
                           shrink-0
                           ml-auto"
                >

                    <div class="text-right">

                        <p
                            class="hidden sm:block
                                   text-sm
                                   font-semibold
                                   text-gray-800"
                        >
                            {{ auth()->user()->name }}
                        </p>

                        <p
                            class="hidden sm:block
                                   text-xs
                                   text-gray-500"
                        >
                            Pelanggan
                        </p>

                    </div>


                    {{-- Avatar --}}
                    <div
                        class="w-10 h-10
                               rounded-full
                               bg-gray-900
                               text-white
                               flex items-center
                               justify-center
                               font-semibold
                               shrink-0"
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


    {{-- =========================================================
        ALPINE JS
    ========================================================== --}}
    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
    ></script>

</body>

</html>
