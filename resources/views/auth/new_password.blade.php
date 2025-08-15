<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4 text-center">Setel Ulang Password</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('reset.password') }}" method="POST">
            @csrf
            <label class="block mb-2">Password Baru</label>
            <input type="password" name="new_password" class="w-full border px-3 py-2 rounded mb-4" required>

            <label class="block mb-2">Konfirmasi Password</label>
            <input type="password" name="new_password_confirmation" class="w-full border px-3 py-2 rounded mb-4"
                required>

            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Simpan Password</button>
        </form>
    </div>
</body>

</html>