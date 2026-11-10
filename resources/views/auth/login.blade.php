<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Login - SAM'S LAUNDRY</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen bg-gray-950 flex items-center justify-center p-6">

    <div class="w-full max-w-5xl">

        @php
            $setting = \App\Models\Setting::first();
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-2
                    bg-white rounded-3xl overflow-hidden
                    shadow-2xl">


            {{-- LEFT --}}
            <div class="hidden lg:flex bg-gray-900 text-white
                        p-12 flex-col justify-between">

                <div>

                    <center>
                    <div class="w-60 h-60 rounded-2xl bg-white
                                text-gray-900 flex items-center
                                justify-center text-2xl font-bold">

                        @if($setting?->logo)
                            <img
                                src="{{ asset('uploads/logo/' . $setting->logo) }}"
                                alt="Logo {{ $setting->nama_laundry ?? 'Laundry' }}"
                                class="w-full h-full object-cover"
                            >
                        @else
                            <span class="text-white font-bold">
                                {{ strtoupper(substr($setting?->nama_laundry ?? 'L', 0, 1)) }}
                            </span>
                        @endif
                    </div>
                    </center>


                    <h1 class="text-4xl font-bold mt-8 leading-tight">

                        Selamat Datang
                        <br>
                        di SAM'S LAUNDRY

                    </h1>


                    <p class="mt-5 text-gray-400 leading-relaxed">

                        Kelola laundry dengan lebih mudah,
                        cepat, dan terorganisir.

                    </p>

                </div>


                <div>

                    <p class="text-xs text-gray-500 mt-5">
                        © {{ date('Y') }} SAM'S LAUNDRY
                    </p>

                </div>

            </div>


            {{-- RIGHT --}}
            <div class="p-8 sm:p-12">

                <div class="max-w-md mx-auto">

                    {{-- Logo mobile --}}
                    <div class="lg:hidden mb-8">

                        <div class="w-12 h-12 rounded-2xl bg-gray-900
                                flex items-center justify-center
                                overflow-hidden">

                        @if($setting?->logo)
                            <img
                                src="{{ asset('uploads/logo/' . $setting->logo) }}"
                                alt="Logo {{ $setting->nama_laundry ?? 'Laundry' }}"
                                class="w-full h-full object-cover"
                            >
                        @else
                            <span class="text-white font-bold">
                                {{ strtoupper(substr($setting?->nama_laundry ?? 'L', 0, 1)) }}
                            </span>
                        @endif

                    </div>

                    </div>


                    <h2 class="text-3xl font-bold text-gray-900">
                        Masuk
                    </h2>

                    <p class="text-sm text-gray-500 mt-2">
                        Masuk ke akun SAM'S LAUNDRY kamu.
                    </p>


                    {{-- Success --}}
                    @if(session('success'))

                        <div class="mt-6 bg-gray-100 border
                                    border-gray-200 rounded-xl
                                    px-4 py-3 text-sm text-gray-700">

                            {{ session('success') }}

                        </div>

                    @endif


                    {{-- Error --}}
                    @if($errors->any())

                        <div class="mt-6 bg-gray-100 border
                                    border-gray-300 rounded-xl
                                    px-4 py-3">

                            <p class="text-sm font-medium text-gray-900">
                                Login gagal
                            </p>

                            <p class="text-sm text-gray-600 mt-1">
                                {{ $errors->first() }}
                            </p>

                        </div>

                    @endif


                    <form
                        action="{{ route('login.store') }}"
                        method="POST"
                        class="mt-8 space-y-5"
                    >

                        @csrf


                        {{-- Email --}}
                        <div>

                            <label class="block text-sm font-medium
                                        text-gray-700 mb-2">

                                Email

                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                required
                                autofocus
                                class="w-full px-4 py-3 rounded-xl
                                    border border-gray-300
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-gray-900"
                            >

                        </div>


                        {{-- Password --}}
                        <div>

                            <div class="flex justify-between mb-2">

                                <label class="text-sm font-medium
                                            text-gray-700">

                                    Password

                                </label>

                                <a
                                    href="{{ route('password.request') }}"
                                    class="text-sm font-medium
                                        text-gray-900 hover:underline"
                                >
                                    Lupa password?
                                </a>

                            </div>


                            <input
                                type="password"
                                name="password"
                                placeholder="Masukkan password"
                                required
                                class="w-full px-4 py-3 rounded-xl
                                    border border-gray-300
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-gray-900"
                            >

                        </div>


                        {{-- Remember --}}
                        <label class="flex items-center gap-2">

                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                class="rounded border-gray-300"
                            >

                            <span class="text-sm text-gray-600">
                                Ingat saya
                            </span>

                        </label>


                        <button
                            type="submit"
                            class="w-full py-3.5 rounded-xl
                                bg-gray-900 text-white
                                font-semibold
                                hover:bg-gray-800
                                transition"
                        >

                            Masuk

                        </button>

                    </form>


                    <div class="mt-8 text-center">

                        <p class="text-sm text-gray-500">

                            Belum punya akun?

                            <a
                                href="{{ route('register') }}"
                                class="font-semibold text-gray-900
                                    hover:underline"
                            >
                                Daftar sebagai pelanggan
                            </a>

                        </p>

                    </div>


                </div>

            </div>

        </div>

    </div>

</body>

</html>
