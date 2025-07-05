<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NurseAssist Web</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 font-sans antialiased">

    <!-- Header with Contact Us -->
    <header class="bg-white shadow-md px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-yellow-900">NurseAssist</h1>
        <a href="#contact" class="text-sm text-blue-600 hover:underline">Contact Us</a>
    </header>

    <!-- Main Content -->
    <div class="min-h-[80vh] flex items-center justify-center">
        <div class="flex flex-col md:flex-row  overflow-hidden w-full max-w-5xl">
            <!-- Left Side Image -->
            <div class="md:w-1/2 flex items-center justify-center p-8">
                <img src="{{ asset('images/nurse.png') }}" alt="Nurse Illustration" class="w-3/4">
            </div>

            <!-- Right Side Buttons -->
            <div class="md:w-1/2 flex flex-col items-center justify-center p-10 text-center space-y-6">
                <h1 class="font-bold text-black text-5xl">Nurse Assist</h1>
                <p class="text-gray-600">Helping nurses deliver patient care with ease and confidence.</p>

                <div class="flex flex-col space-y-4 w-full max-w-xs">
                    <a href="{{ route('login') }}"
                        class="block w-full text-center bg-yellow-900 text-white py-3 rounded-2xl hover:bg-yellow-600 transition">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                        class="block w-full text-center bg-yellow-900 text-white py-3 rounded-2xl hover:bg-yellow-600 transition">
                        Sign Up
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <section id="contact" class="bg-white border-t mt-10 py-8 px-6 text-center">
        <h2 class="text-2xl font-bold text-yellow-900 mb-4">Contact Us</h2>
        <p class="text-gray-700 mb-1">📞 Phone: (123) 456-7890</p>
        <p class="text-gray-700 mb-1">✉️ Email: support@nurseassistweb.com</p>
        <p class="text-gray-700">🌐 Website: www.nurseassistweb.com</p>
    </section>

    <!-- Footer -->
    <footer class="text-center py-4 text-sm text-gray-600 bg-gray-50 border-t">
        &copy; {{ now()->year }} NurseAssist Web. All rights reserved.
    </footer>

</body>
</html>
