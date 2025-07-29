<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Sistem Peminjaman Buku Online</h2>

    @if ($errors->any())
      <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ url('/admin/register') }}">
      @csrf
      <div class="mb-4">
        <label class="block mb-1">Nama</label>
        <input type="text" name="name" class="w-full border px-3 py-2 rounded" required>
      </div>
      <div class="mb-4">
        <label class="block mb-1">Email</label>
        <input type="email" name="email" class="w-full border px-3 py-2 rounded" required>
      </div>
      <div class="mb-4">
        <label class="block mb-1">Telepon</label>
        <input type="text" name="phone" class="w-full border px-3 py-2 rounded" required>
      </div>
      <div class="mb-4">
        <label class="block mb-1">Password</label>
        <input type="password" name="password" class="w-full border px-3 py-2 rounded" required>
      </div>
      <div class="mb-4">
        <label class="block mb-1">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded" required>
      </div>
      <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Register</button>
    </form>

    <p class="mt-4 text-sm text-center">
      Sudah punya akun? <a href="{{ route('admin.login') }}" class="text-blue-600 hover:underline">Login di sini</a>
    </p>
  </div>
</body>
</html>
