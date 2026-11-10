<!DOCTYPE html>

<html lang="id">

<head>


<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Lupa Password - SAM'S LAUNDRY</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body class="min-h-screen bg-gray-950 flex items-center
             justify-center p-6">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10">

            <div class="text-center">

                @php
                    $setting = \App\Models\Setting::first();
                @endphp

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

                <h1 class="text-2xl font-bold text-gray-900 mt-5">
                    Lupa Password?
                </h1>

                <p class="text-sm text-gray-500 mt-2">
                    Masukkan email akun kamu untuk mendapatkan
                    link reset password.
                </p>

            </div>


            @if(session('success'))

                <div class="mt-6 bg-gray-100 border
                            border-gray-200 rounded-xl
                            px-4 py-3 text-sm text-gray-700">

                    {{ session('success') }}

                </div>

            @endif


            @if($errors->any())

                <div class="mt-6 bg-gray-100 border
                            border-gray-300 rounded-xl
                            px-4 py-3 text-sm text-gray-600">

                    {{ $errors->first() }}

                </div>

            @endif


            <form
                action="{{ route('password.email') }}"
                method="POST"
                class="mt-8 space-y-5"
            >

                @csrf

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
                        autofocus
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
                    Kirim Link Reset
                </button>

            </form>


            <div class="text-center mt-7">

                <a
                    href="{{ route('login') }}"
                    class="text-sm font-semibold text-gray-900
                        hover:underline"
                >
                    ← Kembali ke Login
                </a>

            </div>

        </div>

    </div>

</body>

</html>
