<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NurseAssist') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

    <div class="min-h-screen flex flex-col">

        <!-- Header -->
        <header class="bg-[#f9d6c3] p-6 shadow-md relative">
                <!-- Flex container for hamburger and profile -->
                <div class="flex items-center justify-between relative z-10">
                    <!-- Hamburger (left, mobile only) -->
                    <div class="md:hidden">
                        <button id="toggleSidebar" class="text-[#8f684d] focus:outline-none">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>

                    <!-- Spacer to balance layout -->
                    <div class="flex-1"></div>

                    <!-- Profile Icon (right) -->
                    <div class="relative">
                        <button id="profileMenuBtn" class="focus:outline-none">
                            <svg class="w-6 h-6 text-[#8f684d]" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5.121 17.804A13.937 13.937 0 0112 15c2.21 0 4.287.534 6.121 1.474M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white text-gray-800 rounded shadow-md z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Centered Welcome Box (absolute, above everything) -->
                <div class="absolute inset-0 flex justify-center items-center pointer-events-none">
                    <div class="bg-[#ff6664] text-white text-lg px-8 py-3 rounded-lg shadow font-semibold">
                        Welcome, {{ Auth::user()->name }}
                    </div>
                </div>
            </header>



        <div class="flex flex-1">
            <!-- Sidebar -->
            <aside id="sidebar" class="bg-white w-64 py-8 px-6 shadow-md space-y-6 flex flex-col justify-between
                         fixed md:relative inset-y-0 left-0 transform -translate-x-full md:translate-x-0
                         transition-transform duration-300 ease-in-out z-40">
                <nav class="space-y-4">
                    @php
                        $links = [
                            ['label' => 'Dashboard', 'route' => route('dashboard')],
                            ['label' => "Patient's Book", 'route' => route('patients.index')],
                            ['label' => 'Vital Signs', 'route' => route('vitals.index')],
                            ['label' => 'Nursing Notes', 'route' => route('notes.index')],
                            ['label' => 'Care Task Scheduler', 'route' => route('tasks.index')],
                            ['label' => 'Report Generator', 'route' => route('reports.index')],
                            ['label' => 'About Us', 'route' => route('about')],
                        ];
                    @endphp

                    @foreach ($links as $link)
                        <a href="{{ $link['route'] }}"
                            class="block text-center px-4 py-4 rounded-2xl text-white text-lg font-medium
                                bg-[#8f684d] hover:bg-[#9c0e0e] transition">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                </nav>
            </aside>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Profile Dropdown Toggle
        document.getElementById('profileMenuBtn')?.addEventListener('click', () => {
            document.getElementById('profileDropdown')?.classList.toggle('hidden');
        });

        // Sidebar Toggle (Mobile)
        document.getElementById('toggleSidebar')?.addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>
