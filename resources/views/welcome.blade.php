<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $setting?->nama_laundry ?? "SAM'S LAUNDRY" }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-white text-gray-800 antialiased">

    {{-- =========================================================
        NAVBAR
    ========================================================== --}}
    <header
        class="fixed top-0 left-0 right-0 z-50
               bg-white/95 backdrop-blur
               border-b border-gray-100"
    >

        <div
            class="max-w-7xl mx-auto
                   px-5 sm:px-6 lg:px-8
                   h-20
                   flex items-center justify-between"
        >

            {{-- BRAND --}}
            <a
                href="{{ route('welcome') }}"
                class="flex items-center gap-3"
            >

                <div
                    class="w-11 h-11 rounded-full
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

                        <span class="font-bold text-gray-600">
                            {{ strtoupper(substr($setting?->nama_laundry ?? 'L', 0, 1)) }}
                        </span>

                    @endif

                </div>


                <div>

                    <p class="font-bold text-gray-900 leading-tight">
                        {{ $setting?->nama_laundry ?? "SAM'S LAUNDRY" }}
                    </p>

                    <p class="text-xs text-gray-500">
                        Laundry & Care
                    </p>

                </div>

            </a>


            {{-- DESKTOP NAV --}}
            <nav class="hidden lg:flex items-center gap-7">

                <a
                    href="#layanan"
                    class="text-sm font-medium text-gray-600
                           hover:text-gray-900 transition"
                >
                    Layanan
                </a>

                <a
                    href="#harga"
                    class="text-sm font-medium text-gray-600
                           hover:text-gray-900 transition"
                >
                    Harga
                </a>

                <a
                    href="#cara-kerja"
                    class="text-sm font-medium text-gray-600
                           hover:text-gray-900 transition"
                >
                    Cara Kerja
                </a>

                <a
                    href="#faq"
                    class="text-sm font-medium text-gray-600
                           hover:text-gray-900 transition"
                >
                    FAQ
                </a>

                <a
                    href="#kontak"
                    class="text-sm font-medium text-gray-600
                           hover:text-gray-900 transition"
                >
                    Kontak
                </a>

            </nav>


            {{-- AUTH BUTTON --}}
            <div class="flex items-center gap-2">

                <a
                    href="{{ route('login') }}"
                    class="hidden sm:inline-flex
                           px-4 py-2.5
                           rounded-xl
                           text-sm font-semibold
                           text-gray-700
                           hover:bg-gray-100
                           transition"
                >
                    Login
                </a>

                <a
                    href="{{ route('register') }}"
                    class="inline-flex
                           px-4 py-2.5
                           rounded-xl
                           bg-gray-900
                           text-white
                           text-sm font-semibold
                           hover:bg-gray-800
                           transition"
                >
                    Register
                </a>

            </div>

        </div>

    </header>



    {{-- =========================================================
        HERO
    ========================================================== --}}
    <main>

        <section
            class="pt-32 pb-20
                   bg-gray-50"
        >

            <div
                class="max-w-7xl mx-auto
                       px-5 sm:px-6 lg:px-8"
            >

                <div
                    class="grid lg:grid-cols-2
                           gap-12
                           items-center"
                >

                    {{-- HERO TEXT --}}
                    <div>

                        <div
                            class="inline-flex items-center gap-2
                                   px-3 py-1.5
                                   rounded-full
                                   bg-white
                                   border border-gray-200
                                   text-xs font-semibold
                                   text-gray-600
                                   mb-6"
                        >

                            <span
                                class="w-2 h-2
                                       rounded-full
                                       bg-green-500"
                            ></span>

                            Laundry terpercaya untuk kebutuhan sehari-hari

                        </div>


                        <h1
                            class="text-4xl sm:text-5xl lg:text-6xl
                                   font-bold
                                   tracking-tight
                                   text-gray-900
                                   leading-tight"
                        >
                            Laundry lebih mudah,
                            <span class="text-gray-500">
                                waktu lebih banyak.
                            </span>
                        </h1>


                        <p
                            class="mt-6
                                   text-lg
                                   text-gray-600
                                   leading-relaxed
                                   max-w-xl"
                        >
                            {{ $setting?->nama_laundry ?? "Sam's Laundry" }}
                            hadir untuk membantu kebutuhan laundry kamu
                            dengan layanan yang praktis, harga transparan,
                            dan proses yang dapat dipantau.
                        </p>


                        {{-- HERO BUTTON --}}
                        <div class="mt-8 flex flex-wrap gap-3">

                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center gap-2
                                       px-6 py-3
                                       rounded-xl
                                       bg-gray-900
                                       text-white
                                       font-semibold
                                       hover:bg-gray-800
                                       transition"
                            >

                                Mulai Pesan

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"
                                    />
                                </svg>

                            </a>


                            <a
                                href="#layanan"
                                class="inline-flex
                                       px-6 py-3
                                       rounded-xl
                                       bg-white
                                       border border-gray-200
                                       text-gray-700
                                       font-semibold
                                       hover:bg-gray-100
                                       transition"
                            >
                                Lihat Layanan
                            </a>

                        </div>


                        {{-- TRUST POINT --}}
                        <div
                            class="mt-8
                                   flex flex-wrap
                                   gap-x-6 gap-y-3
                                   text-sm text-gray-500"
                        >

                            <span class="flex items-center gap-2">
                                <span class="text-green-600">✓</span>
                                Harga transparan
                            </span>

                            <span class="flex items-center gap-2">
                                <span class="text-green-600">✓</span>
                                Status dapat dipantau
                            </span>

                            <span class="flex items-center gap-2">
                                <span class="text-green-600">✓</span>
                                Pembayaran mudah
                            </span>

                        </div>

                    </div>


                    {{-- HERO VISUAL --}}
                    <div>

                        <div
                            class="relative
                                   bg-white
                                   rounded-3xl
                                   border border-gray-200
                                   shadow-sm
                                   p-8"
                        >

                            <div
                                class="aspect-square
                                       max-w-md
                                       mx-auto
                                       rounded-3xl
                                       bg-gray-100
                                       flex items-center justify-center"
                            >

                                <div class="text-center px-8">

                                    <div
                                        class="w-24 h-24
                                               mx-auto
                                               rounded-3xl
                                               bg-gray-900
                                               text-white
                                               flex items-center justify-center
                                               mb-6"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="w-12 h-12"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M3 12h18"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M5 12V8a2 2 0 012-2h10a2 2 0 012 2v4"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M5 12v5a2 2 0 002 2h10a2 2 0 002-2v-5"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M8 17h.01M12 17h.01M16 17h.01"
                                            />
                                        </svg>

                                    </div>


                                    <h3
                                        class="text-xl
                                               font-bold
                                               text-gray-900"
                                    >
                                        Laundry Tanpa Ribet
                                    </h3>

                                    <p
                                        class="mt-2
                                               text-sm
                                               text-gray-500
                                               leading-relaxed"
                                    >
                                        Pilih layanan, serahkan cucian,
                                        dan pantau proses laundry kamu
                                        dengan mudah.
                                    </p>

                                </div>

                            </div>


                            {{-- FLOATING INFO --}}
                            <div
                                class="absolute
                                       -bottom-5
                                       -left-5
                                       bg-white
                                       border border-gray-200
                                       shadow-lg
                                       rounded-2xl
                                       px-5 py-4"
                            >

                                <p class="text-xs text-gray-500">
                                    Status laundry
                                </p>

                                <p
                                    class="mt-1
                                           text-sm
                                           font-bold
                                           text-gray-900"
                                >
                                    Dapat dipantau
                                </p>

                            </div>


                            <div
                                class="absolute
                                       -top-5
                                       -right-5
                                       bg-gray-900
                                       text-white
                                       shadow-lg
                                       rounded-2xl
                                       px-5 py-4"
                            >

                                <p class="text-xs text-gray-400">
                                    Layanan
                                </p>

                                <p class="mt-1 text-sm font-bold">
                                    {{ $packages->count() }} Paket
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>



        {{-- =========================================================
            BENEFITS
        ========================================================== --}}
        <section class="py-16">

            <div
                class="max-w-7xl mx-auto
                       px-5 sm:px-6 lg:px-8"
            >

                <div
                    class="grid sm:grid-cols-2 lg:grid-cols-4
                           gap-4"
                >

                    @php
                        $benefits = [
                            [
                                'title' => 'Harga Transparan',
                                'text' => 'Harga layanan ditampilkan dengan jelas sebelum kamu melakukan pemesanan.',
                                'icon' => '₽',
                            ],
                            [
                                'title' => 'Proses Terpantau',
                                'text' => 'Kamu dapat mengetahui status laundry dari pesanan yang sedang diproses.',
                                'icon' => '✓',
                            ],
                            [
                                'title' => 'Pilihan Layanan',
                                'text' => 'Tersedia beberapa pilihan paket sesuai kebutuhan laundry kamu.',
                                'icon' => '≡',
                            ],
                            [
                                'title' => 'Pembayaran Mudah',
                                'text' => 'Pembayaran dapat dilakukan melalui metode yang tersedia.',
                                'icon' => 'Rp',
                            ],
                        ];
                    @endphp


                    @foreach($benefits as $benefit)

                        <div
                            class="p-6
                                   rounded-2xl
                                   border border-gray-200
                                   bg-white
                                   hover:shadow-sm
                                   transition"
                        >

                            <div
                                class="w-10 h-10
                                       rounded-xl
                                       bg-gray-100
                                       flex items-center justify-center
                                       text-sm font-bold
                                       text-gray-700"
                            >
                                {{ $benefit['icon'] }}
                            </div>

                            <h3
                                class="mt-5
                                       font-semibold
                                       text-gray-900"
                            >
                                {{ $benefit['title'] }}
                            </h3>

                            <p
                                class="mt-2
                                       text-sm
                                       leading-relaxed
                                       text-gray-500"
                            >
                                {{ $benefit['text'] }}
                            </p>

                        </div>

                    @endforeach

                </div>

            </div>

        </section>



        {{-- =========================================================
            LAYANAN
        ========================================================== --}}
        <section
            id="layanan"
            class="py-20 bg-gray-50"
        >

            <div
                class="max-w-7xl mx-auto
                       px-5 sm:px-6 lg:px-8"
            >

                <div class="max-w-2xl">

                    <p
                        class="text-sm
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider"
                    >
                        Layanan
                    </p>

                    <h2
                        class="mt-2
                               text-3xl
                               font-bold
                               text-gray-900"
                    >
                        Pilih layanan sesuai kebutuhanmu
                    </h2>

                    <p
                        class="mt-4
                               text-gray-600
                               leading-relaxed"
                    >
                        Setiap paket memiliki harga dan estimasi pengerjaan
                        yang berbeda. Pilih yang paling sesuai dengan
                        kebutuhan laundry kamu.
                    </p>

                </div>


                <div
                    id="harga"
                    class="mt-10
                           grid md:grid-cols-2
                           lg:grid-cols-4
                           gap-5"
                >

                    @forelse($packages as $package)

                        <div
                            class="bg-white
                                   rounded-2xl
                                   border border-gray-200
                                   p-6
                                   flex flex-col"
                        >

                            <div
                                class="flex items-start
                                       justify-between gap-3"
                            >

                                <h3
                                    class="font-bold
                                           text-gray-900"
                                >
                                    {{ $package->nama_paket }}
                                </h3>

                                <span
                                    class="px-2 py-1
                                           rounded-lg
                                           bg-gray-100
                                           text-xs
                                           font-medium
                                           text-gray-600
                                           whitespace-nowrap"
                                >
                                    {{ $package->estimasi_hari }} hari
                                </span>

                            </div>


                            <div class="mt-6">

                                <p
                                    class="text-2xl
                                           font-bold
                                           text-gray-900"
                                >
                                    Rp {{ number_format($package->harga_per_kg, 0, ',', '.') }}
                                </p>

                                <p
                                    class="text-sm
                                           text-gray-500
                                           mt-1"
                                >
                                    per kilogram
                                </p>

                            </div>


                            <p
                                class="mt-5
                                       text-sm
                                       text-gray-500
                                       leading-relaxed
                                       flex-1"
                            >
                                {{ $package->deskripsi
                                    ?? 'Layanan laundry berkualitas untuk kebutuhan sehari-hari.' }}
                            </p>


                            <a
                                href="{{ route('register') }}"
                                class="mt-6
                                       w-full
                                       text-center
                                       px-4 py-2.5
                                       rounded-xl
                                       bg-gray-900
                                       text-white
                                       text-sm
                                       font-semibold
                                       hover:bg-gray-800
                                       transition"
                            >
                                Pilih Paket
                            </a>

                        </div>

                    @empty

                        <div
                            class="lg:col-span-4
                                   bg-white
                                   rounded-2xl
                                   border border-gray-200
                                   p-10
                                   text-center"
                        >

                            <p class="font-semibold text-gray-900">
                                Belum ada layanan tersedia.
                            </p>

                            <p class="mt-2 text-sm text-gray-500">
                                Silakan kembali lagi nanti.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </section>



        {{-- =========================================================
            CARA KERJA
        ========================================================== --}}
        <section
            id="cara-kerja"
            class="py-20"
        >

            <div
                class="max-w-7xl mx-auto
                       px-5 sm:px-6 lg:px-8"
            >

                <div class="text-center max-w-2xl mx-auto">

                    <p
                        class="text-sm
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider"
                    >
                        Cara Kerja
                    </p>

                    <h2
                        class="mt-2
                               text-3xl
                               font-bold
                               text-gray-900"
                    >
                        Laundry jadi lebih sederhana
                    </h2>

                    <p
                        class="mt-4
                               text-gray-600"
                    >
                        Ikuti beberapa langkah sederhana untuk menggunakan
                        layanan {{ $setting?->nama_laundry ?? "Sam's Laundry" }}.
                    </p>

                </div>


                <div
                    class="mt-12
                           grid md:grid-cols-3
                           gap-8"
                >

                    @php
                        $steps = [
                            [
                                'number' => '01',
                                'title' => 'Daftar / Login',
                                'text' => 'Buat akun pelanggan atau login jika sudah memiliki akun.',
                            ],
                            [
                                'number' => '02',
                                'title' => 'Pilih Layanan',
                                'text' => 'Pilih paket laundry yang sesuai dengan kebutuhan kamu.',
                            ],
                            [
                                'number' => '03',
                                'title' => 'Pantau Pesanan',
                                'text' => 'Laundry diproses dan status pesanan dapat dipantau melalui akun kamu.',
                            ],
                        ];
                    @endphp


                    @foreach($steps as $step)

                        <div class="relative">

                            <div
                                class="w-12 h-12
                                       rounded-2xl
                                       bg-gray-900
                                       text-white
                                       flex items-center justify-center
                                       font-bold"
                            >
                                {{ $step['number'] }}
                            </div>


                            <h3
                                class="mt-5
                                       text-lg
                                       font-bold
                                       text-gray-900"
                            >
                                {{ $step['title'] }}
                            </h3>


                            <p
                                class="mt-2
                                       text-sm
                                       text-gray-500
                                       leading-relaxed"
                            >
                                {{ $step['text'] }}
                            </p>

                        </div>

                    @endforeach

                </div>

            </div>

        </section>



        {{-- =========================================================
            STATUS LAUNDRY
        ========================================================== --}}
        <section
            class="py-20
                   bg-gray-900
                   text-white"
        >

            <div
                class="max-w-7xl mx-auto
                       px-5 sm:px-6 lg:px-8"
            >

                <div
                    class="grid lg:grid-cols-2
                           gap-12
                           items-center"
                >

                    <div>

                        <p
                            class="text-sm
                                   font-semibold
                                   text-gray-400
                                   uppercase
                                   tracking-wider"
                        >
                            Pantau Pesanan
                        </p>

                        <h2
                            class="mt-3
                                   text-3xl
                                   sm:text-4xl
                                   font-bold"
                        >
                            Tahu posisi laundry kamu tanpa perlu bertanya.
                        </h2>

                        <p
                            class="mt-5
                                   text-gray-400
                                   leading-relaxed
                                   max-w-xl"
                        >
                            Setelah melakukan pemesanan, kamu dapat melihat
                            perkembangan laundry melalui akun pelanggan.
                            Status laundry akan diperbarui selama proses
                            pengerjaan.
                        </p>

                        <a
                            href="{{ route('login') }}"
                            class="inline-flex
                                   mt-7
                                   px-5 py-3
                                   rounded-xl
                                   bg-white
                                   text-gray-900
                                   font-semibold
                                   hover:bg-gray-100
                                   transition"
                        >
                            Cek Pesanan
                        </a>

                    </div>


                    <div
                        class="bg-white/10
                               border border-white/10
                               rounded-3xl
                               p-6"
                    >

                        @php
                            $statusSteps = [
                                ['label' => 'Menunggu', 'active' => true],
                                ['label' => 'Dicuci', 'active' => true],
                                ['label' => 'Dikeringkan', 'active' => true],
                                ['label' => 'Disetrika', 'active' => true],
                                ['label' => 'Siap Diambil', 'active' => true],
                                ['label' => 'Selesai', 'active' => true],
                            ];
                        @endphp


                        <div class="space-y-4">

                            @foreach($statusSteps as $status)

                                <div
                                    class="flex items-center gap-4
                                           p-3 rounded-xl
                                           bg-white/5"
                                >

                                    <div
                                        class="w-9 h-9
                                               rounded-full
                                               bg-white
                                               text-gray-900
                                               flex items-center justify-center
                                               text-sm font-bold"
                                    >
                                        ✓
                                    </div>

                                    <span
                                        class="text-sm font-medium"
                                    >
                                        {{ $status['label'] }}
                                    </span>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        </section>



        {{-- =========================================================
            FAQ
        ========================================================== --}}
        <section
            id="faq"
            class="py-20"
        >

            <div
                class="max-w-4xl mx-auto
                       px-5 sm:px-6 lg:px-8"
            >

                <div class="text-center">

                    <p
                        class="text-sm
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider"
                    >
                        FAQ
                    </p>

                    <h2
                        class="mt-2
                               text-3xl
                               font-bold
                               text-gray-900"
                    >
                        Pertanyaan yang sering ditanyakan
                    </h2>

                </div>


                <div class="mt-10 space-y-3">

                    <details
                        class="group
                               rounded-2xl
                               border border-gray-200
                               p-5"
                    >

                        <summary
                            class="cursor-pointer
                                   list-none
                                   flex items-center
                                   justify-between
                                   font-semibold
                                   text-gray-900"
                        >
                            Bagaimana cara menggunakan layanan laundry?

                            <span
                                class="text-gray-400
                                       group-open:rotate-45
                                       transition"
                            >
                                +
                            </span>

                        </summary>

                        <p
                            class="mt-4
                                   text-sm
                                   text-gray-500
                                   leading-relaxed"
                        >
                            Daftar akun terlebih dahulu, kemudian pilih
                            layanan laundry yang tersedia. Setelah pesanan
                            dibuat, proses laundry dapat dipantau melalui
                            akun pelanggan.
                        </p>

                    </details>


                    <details
                        class="group
                               rounded-2xl
                               border border-gray-200
                               p-5"
                    >

                        <summary
                            class="cursor-pointer
                                   list-none
                                   flex items-center
                                   justify-between
                                   font-semibold
                                   text-gray-900"
                        >
                            Bagaimana perhitungan harga laundry?

                            <span
                                class="text-gray-400
                                       group-open:rotate-45
                                       transition"
                            >
                                +
                            </span>

                        </summary>

                        <p
                            class="mt-4
                                   text-sm
                                   text-gray-500
                                   leading-relaxed"
                        >
                            Harga dihitung berdasarkan berat laundry dan
                            paket yang dipilih. Harga per kilogram setiap
                            paket dapat dilihat pada bagian layanan di atas.
                        </p>

                    </details>


                    <details
                        class="group
                               rounded-2xl
                               border border-gray-200
                               p-5"
                    >

                        <summary
                            class="cursor-pointer
                                   list-none
                                   flex items-center
                                   justify-between
                                   font-semibold
                                   text-gray-900"
                        >
                            Bagaimana cara mengetahui status laundry?

                            <span
                                class="text-gray-400
                                       group-open:rotate-45
                                       transition"
                            >
                                +
                            </span>

                        </summary>

                        <p
                            class="mt-4
                                   text-sm
                                   text-gray-500
                                   leading-relaxed"
                        >
                            Setelah login, pelanggan dapat melihat pesanan
                            dan status laundry yang sedang diproses.
                        </p>

                    </details>


                    <details
                        class="group
                               rounded-2xl
                               border border-gray-200
                               p-5"
                    >

                        <summary
                            class="cursor-pointer
                                   list-none
                                   flex items-center
                                   justify-between
                                   font-semibold
                                   text-gray-900"
                        >
                            Apa saja status laundry?

                            <span
                                class="text-gray-400
                                       group-open:rotate-45
                                       transition"
                            >
                                +
                            </span>

                        </summary>

                        <p
                            class="mt-4
                                   text-sm
                                   text-gray-500
                                   leading-relaxed"
                        >
                            Status laundry terdiri dari Menunggu, Dicuci,
                            Dikeringkan, Disetrika, Siap Diambil, dan
                            Selesai.
                        </p>

                    </details>

                </div>

            </div>

        </section>



        {{-- =========================================================
            CTA
        ========================================================== --}}
        <section class="pb-20">

            <div
                class="max-w-7xl mx-auto
                       px-5 sm:px-6 lg:px-8"
            >

                <div
                    class="rounded-3xl
                           bg-gray-100
                           border border-gray-200
                           px-6 py-12
                           sm:px-12
                           text-center"
                >

                    <h2
                        class="text-3xl
                               font-bold
                               text-gray-900"
                    >
                        Siap membuat laundry jadi lebih mudah?
                    </h2>

                    <p
                        class="mt-4
                               text-gray-600
                               max-w-xl
                               mx-auto"
                    >
                        Daftar sekarang dan mulai gunakan layanan
                        {{ $setting?->nama_laundry ?? "Sam's Laundry" }}.
                    </p>


                    <div
                        class="mt-7
                               flex flex-wrap
                               justify-center
                               gap-3"
                    >

                        <a
                            href="{{ route('register') }}"
                            class="px-6 py-3
                                   rounded-xl
                                   bg-gray-900
                                   text-white
                                   font-semibold
                                   hover:bg-gray-800
                                   transition"
                        >
                            Daftar Sekarang
                        </a>

                        <a
                            href="{{ route('login') }}"
                            class="px-6 py-3
                                   rounded-xl
                                   bg-white
                                   border border-gray-200
                                   text-gray-700
                                   font-semibold
                                   hover:bg-gray-50
                                   transition"
                        >
                            Sudah Punya Akun?
                        </a>

                    </div>

                </div>

            </div>

        </section>

    </main>



    {{-- =========================================================
        FOOTER
    ========================================================== --}}
    <footer
        id="kontak"
        class="border-t border-gray-200
               bg-white"
    >

        <div
            class="max-w-7xl mx-auto
                   px-5 sm:px-6 lg:px-8
                   py-12"
        >

            <div
                class="grid md:grid-cols-3
                       gap-10"
            >

                {{-- BRAND --}}
                <div>

                    <div class="flex items-center gap-3">

                        <div
                            class="w-10 h-10
                                   rounded-full
                                   overflow-hidden
                                   border border-gray-200
                                   bg-gray-100
                                   flex items-center justify-center"
                        >

                            @if($setting?->logo)

                                <img
                                    src="{{ asset('uploads/logo/' . $setting->logo) }}"
                                    alt="Logo"
                                    class="w-full h-full object-cover"
                                >

                            @else

                                <span class="font-bold text-gray-500">
                                    {{ strtoupper(substr($setting?->nama_laundry ?? 'L', 0, 1)) }}
                                </span>

                            @endif

                        </div>


                        <div>

                            <p class="font-bold text-gray-900">
                                {{ $setting?->nama_laundry ?? "SAM'S LAUNDRY" }}
                            </p>

                            <p class="text-xs text-gray-500">
                                Laundry & Care
                            </p>

                        </div>

                    </div>


                    <p
                        class="mt-4
                               text-sm
                               text-gray-500
                               leading-relaxed
                               max-w-sm"
                    >
                        Layanan laundry untuk membantu menjaga pakaian
                        tetap bersih dan memberikan lebih banyak waktu
                        untuk aktivitas kamu.
                    </p>

                </div>


                {{-- KONTAK --}}
                <div>

                    <h3
                        class="font-semibold
                               text-gray-900"
                    >
                        Kontak
                    </h3>

                    <div
                        class="mt-4
                               space-y-3
                               text-sm
                               text-gray-500"
                    >

                        @if($setting?->alamat)

                            <p>
                                {{ $setting->alamat }}
                            </p>

                        @endif


                        @if($setting?->phone)

                            <p>
                                {{ $setting->phone }}
                            </p>

                        @endif


                        @if($setting?->email)

                            <p>
                                {{ $setting->email }}
                            </p>

                        @endif

                    </div>

                </div>


                {{-- LINKS --}}
                <div>

                    <h3
                        class="font-semibold
                               text-gray-900"
                    >
                        Navigasi
                    </h3>

                    <div
                        class="mt-4
                               flex flex-col
                               gap-3
                               text-sm"
                    >

                        <a
                            href="#layanan"
                            class="text-gray-500 hover:text-gray-900"
                        >
                            Layanan
                        </a>

                        <a
                            href="#cara-kerja"
                            class="text-gray-500 hover:text-gray-900"
                        >
                            Cara Kerja
                        </a>

                        <a
                            href="#faq"
                            class="text-gray-500 hover:text-gray-900"
                        >
                            FAQ
                        </a>

                        <a
                            href="{{ route('login') }}"
                            class="text-gray-500 hover:text-gray-900"
                        >
                            Login
                        </a>

                    </div>

                </div>

            </div>


            <div
                class="mt-10
                       pt-6
                       border-t border-gray-100
                       flex flex-col sm:flex-row
                       justify-between
                       gap-3
                       text-xs
                       text-gray-400"
            >

                <p>
                    © {{ date('Y') }}
                    {{ $setting?->nama_laundry ?? "Sam's Laundry" }}.
                    All rights reserved.
                </p>

                <p>
                    Laundry Management System
                </p>

            </div>

        </div>

    </footer>

</body>

</html>
