<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Reset Password - SAM'S LAUNDRY</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen bg-gray-950 flex items-center
             justify-center p-6">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10">

            <div class="text-center">

                <div class="mx-auto w-14 h-14 rounded-2xl
                            bg-gray-900 text-white
                            flex items-center justify-center
                            font-bold text-xl">

                    S

                </div>

                <h1 class="text-2xl font-bold text-gray-900 mt-5">
                    Reset Password
                </h1>

                <p class="text-sm text-gray-500 mt-2">
                    Buat password baru untuk akun kamu.
                </p>

            </div>


            @if($errors->any())

                <div class="mt-6 bg-gray-100 border
                            border-gray-300 rounded-xl
                            px-4 py-3">

                    <ul class="text-sm text-gray-600 space-y-1">

                        @foreach($errors->all() as $error)

                            <li>• {{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                action="{{ route('password.update') }}"
                method="POST"
                class="mt-8 space-y-5"
            >

                @csrf


                <input
                    type="hidden"
                    name="token"
                    value="{{ $token }}"
                >


                <div>

                    <label class="block text-sm font-medium mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ $email }}"
                        required
                        class="w-full px-4 py-3 rounded-xl
                            border border-gray-300
                            focus:outline-none
                            focus:ring-2 focus:ring-gray-900"
                    >

                </div>


                <div>

                    <label class="block text-sm font-medium mb-2">
                        Password Baru
                    </label>

                    <input
                        type="password"
                        name="password"
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
                    Simpan Password Baru
                </button>

            </form>

        </div>

    </div>

</body>

</html>
