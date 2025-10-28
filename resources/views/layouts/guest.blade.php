<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Blaze') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen flex flex-col">
    
    {{-- 🔹 NAVBAR (same as main layout but simplified for guests) --}}
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200/60 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">B</span>
                    </div>
                    <a href="{{ url('/') }}" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        {{ config('app.name', 'Blaze') }}
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 text-sm">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 text-sm">Register</a>
                </div>
            </div>
        </div>
    </nav>

    {{-- 🔹 MAIN AUTH CONTAINER --}}
    <main class="flex-1 flex flex-col justify-center items-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md bg-white/90 backdrop-blur-md shadow-xl rounded-2xl p-8 border border-gray-100">
            <div class="flex justify-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center shadow-sm">
                    <span class="text-white font-bold text-lg">B</span>
                </div>
            </div>
            <h2 class="text-center text-2xl font-semibold text-gray-800 mb-6">
                Welcome to {{ config('app.name', 'Blaze') }}
            </h2>

            {{ $slot }}
        </div>
    </main>

    {{-- 🔹 FOOTER --}}
    <footer class="bg-gradient-to-r from-gray-900 to-blue-900 text-white mt-16">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} {{ config('app.name', 'Blaze') }} — All rights reserved.
        </div>
    </footer>

</body>
</html>
