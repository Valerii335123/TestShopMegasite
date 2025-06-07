<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100">
<div class="min-h-screen">
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('products.index') }}" class="text-xl font-bold text-indigo-600">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('cart') }}" class="text-xl font-bold text-indigo-600">
                            {{__('pages.common.cart_title')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>
</div>

@livewireScripts
</body>
</html> 