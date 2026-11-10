<!DOCTYPE html>

<html lang="id">

<head>


<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Daftar - SAM'S LAUNDRY</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="min-h-screen bg-gray-950 flex items-center
             justify-center p-6">

    <div class="w-full max-w-lg">

        <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10">

            @php
                $setting = \App\Models\Setting::first();
            @endphp

            <div class="text-center mb-8">

                <div class="mx-auto w-25 h-25 rounded-2xl
                            bg-gray-900 text-white
                            flex items-center justify-center
                            font-bold text-xl">

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

                <h1 class="text-3xl font-bold text-gray-900 mt-5">
                    Buat Akun
                </h1>

                <p class="text-sm text-gray-500 mt-2">
                    Daftar sebagai pelanggan SAM'S LAUNDRY.
                </p>

            </div>

            @if($errors->any())

                <div class="mb-6 bg-gray-100 border
                            border-gray-300 rounded-xl px-4 py-3">

                    <ul class="text-sm text-gray-600 space-y-1">

                        @foreach($errors->all() as $error)

                            <li>• {{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form
                action="{{ route('register.store') }}"
                method="POST"
                class="space-y-5"
            >

                @csrf

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Nama lengkap"
                        required
                        class="w-full px-4 py-3 rounded-xl
                            border border-gray-300
                            focus:outline-none
                            focus:ring-2 focus:ring-gray-900"
                    >

                </div>

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        required
                        class="w-full px-4 py-3 rounded-xl
                            border border-gray-300
                            focus:outline-none
                            focus:ring-2 focus:ring-gray-900"
                    >

                </div>

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Nomor HP
                    </label>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="08xxxxxxxxxx"
                        required
                        class="w-full px-4 py-3 rounded-xl
                            border border-gray-300
                            focus:outline-none
                            focus:ring-2 focus:ring-gray-900"
                    >

                </div>

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        required
                        class="w-full px-4 py-3 rounded-xl
                            border border-gray-300
                            focus:outline-none
                            focus:ring-2 focus:ring-gray-900"
                    >

                </div>

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Ulangi password"
                        required
                        class="w-full px-4 py-3 rounded-xl
                            border border-gray-300
                            focus:outline-none
                            focus:ring-2 focus:ring-gray-900"
                    >

                </div>

                <button
                    type="submit"
                    class="w-full py-3.5 rounded-xl
                        bg-gray-900 text-white
                        font-semibold hover:bg-gray-800"
                >
                    Daftar Sekarang
                </button>

            </form>

            <p class="text-center text-sm text-gray-500 mt-7">

                Sudah punya akun?

                <a
                    href="{{ route('login') }}"
                    class="font-semibold text-gray-900 hover:underline"
                >
                    Masuk

                </a>

            </p>

        </div>

    </div>

</body>

</html>
