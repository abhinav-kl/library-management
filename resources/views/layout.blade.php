<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Library Management')</title>

    <!-- Tailwind CDN (for fallback or development) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Include Laravel Mix/Vite Assets Conditionally -->
    @php
        $hasVite = file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'));
    @endphp

    @if ($hasVite)
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

</head>
<body class="antialiased text-gray-800 bg-gray-100">
    <nav class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-4">
                    @if (Auth::check())
                        <a href="{{ url('/books') }}" class="text-lg font-semibold text-gray-700 hover:text-gray-900">Home</a>
                        <a href="{{ route('authors.index') }}" class="text-lg text-gray-700 hover:text-gray-900">Authors</a>
                        <a href="{{ route('genres.index') }}" class="text-lg text-gray-700 hover:text-gray-900">Genres</a>
                        @if (Auth::user()->user_type === 'ADM')
                            <a href="{{ route('users.index') }}" class="text-lg text-gray-700 hover:text-gray-900">Users</a>
                            <a href="{{ route('rentals.index') }}" class="text-lg text-gray-700 hover:text-gray-900">Rental Details</a>
                        @endif
                    @endif
                </div>
                <div class="flex items-center">
                    <!-- Example: Auth links -->
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Login</a>
                    @else
                        <span class="mr-4 text-gray-700">Hi, {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-gray-900">Logout</button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen px-4">
        @yield('content')
    </div>
</body>
</html>
