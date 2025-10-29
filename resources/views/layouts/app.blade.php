<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Blaze') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <div class="min-h-screen flex flex-col">

        
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

                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-blue-50">Home</a>
                        <a href="{{ url('/products') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-blue-50">Products</a>
                        <a href="#" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-blue-50">About</a>
                        <a href="#" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-blue-50">Contact</a>
                     @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('products.trash') }}" class="text-red-600 font-semibold hover:underline">
                            View Deleted Products
                        </a>
                     @endif
                    @endauth
                    </div>

                    
                    <div class="flex items-center space-x-4">
    @auth
        <div class="flex items-center space-x-3">
            <img 
                src="{{ Auth::user()->getProfilePictureUrlAttribute() }}" 
                alt="{{ Auth::user()->name }}'s Profile Picture"
                class="w-9 h-9 rounded-full object-cover border border-gray-200 shadow-sm"
            />
            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button 
                    type="submit" 
                    class="text-gray-500 hover:text-red-500 text-sm transition"
                >
                    Logout
                </button>
            </form>
        </div>
    @else
        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 text-sm">Login</a>
        <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 text-sm">Register</a>
    @endauth
</div>
                </div>
            </div>
        </nav>

        
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        
        <main class="flex-1">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

      
        <footer class="bg-gradient-to-r from-gray-900 to-blue-900 text-white mt-16">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-purple-400 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">B</span>
                            </div>
                            <span class="text-2xl font-bold">{{ config('app.name', 'Blaze') }}</span>
                        </div>
                        <p class="text-gray-300 text-sm max-w-md">
                            Creating amazing experiences with modern web technologies. 
                            Built with Laravel, Tailwind CSS, and passion.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ url('/') }}" class="text-gray-300 hover:text-white transition-colors">Home</a></li>
                            <li><a href="{{ url('/products') }}" class="text-gray-300 hover:text-white transition-colors">Products</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition-colors">About Us</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</body>
</html>
