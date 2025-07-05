<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite('resources/css/app.css')

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">

        <!-- Custom Header -->
        <header class="flex justify-between items-center bg-yellow-900 text-white p-4 shadow-md">
            <h1 class="text-xl font-semibold">Welcome, {{ Auth::user()->name }}</h1>
            <button id="toggleSidebar" class="md:hidden focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </header>

        <!-- Page Content -->
        <div class="flex">
            {{ $slot }}
        </div>
    </div>

    <!-- Sidebar Toggle Script (used in dashboard.blade.php too) -->
    <script>
        document.getElementById('toggleSidebar')?.addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            sidebar?.classList.toggle('-translate-x-full');
        });
    </script>
</body>

</html>
