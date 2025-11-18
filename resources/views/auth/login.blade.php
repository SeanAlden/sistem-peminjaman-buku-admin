{{-- <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">
  <div class="w-full max-w-md p-8 bg-white rounded shadow-md">
    <h2 class="mb-6 text-2xl font-bold text-center">Login</h2>

    @if ($errors->any())
    <div class="p-2 mb-4 text-red-700 bg-red-100 rounded">
      @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
    @endforeach
    </div>
  @endif

    <form method="POST" action="{{ url('/admin/login') }}">
      @csrf
      <div class="mb-4">
        <label class="block mb-1">Email</label>
        <input type="email" name="email" class="w-full px-3 py-2 border rounded" required>
      </div>
      <div class="mb-4">
        <label class="block mb-1">Password</label>
        <input type="password" name="password" class="w-full px-3 py-2 border rounded" required>
      </div>
      <button class="w-full py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Login</button>
    </form>

    <p class="mt-4 text-sm text-center">
      <a href="{{ route('forgot.password') }}" class="text-blue-600 hover:underline">Lupa password?</a>
    </p>

    <p class="mt-4 text-sm text-center">
      Belum punya akun? <a href="{{ route('admin.register') }}" class="text-blue-600 hover:underline">Daftar di sini</a>
    </p>
  </div>
</body>

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">
  <div class="w-full max-w-md p-8 bg-white shadow-md rounded-xl">

    <!-- Logo -->
    <div class="flex flex-col items-center mb-4">
      <img src="{{ asset('assets/icons/book_logo.png') }}" 
           class="w-16 h-16 mb-2" alt="Logo">
      <h1 class="text-xl font-semibold text-gray-700">
        Welcome to <span class="font-bold">Library Management System</span>
      </h1>
    </div>

    <h2 class="mb-6 text-2xl font-bold text-center">Admin Login</h2>

    @if ($errors->any())
      <div class="p-2 mb-4 text-red-700 bg-red-100 rounded">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ url('/admin/login') }}">
      @csrf

      <div class="mb-4">
        <label class="block mb-1 font-medium">Email</label>
        <input type="email" name="email" 
               class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-200" required>
      </div>

      <div class="mb-4">
        <label class="block mb-1 font-medium">Password</label>
        <input type="password" name="password" 
               class="w-full px-3 py-2 border rounded focus:ring focus:ring-blue-200" required>
      </div>

      <button class="w-full py-2 text-white transition bg-blue-600 rounded hover:bg-blue-700">
        Login
      </button>
    </form>

    <p class="mt-4 text-sm text-center">
      <a href="{{ route('forgot.password') }}" class="text-blue-600 hover:underline">
        Forgot password?
      </a>
    </p>

    <p class="mt-4 text-sm text-center">
      Don't have an account? 
      <a href="{{ route('admin.register') }}" class="text-blue-600 hover:underline">Register here</a>
    </p>

  </div>
</body>

</html>
