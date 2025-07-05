<x-guest-layout>
    <div class="w-full max-w-md mx-auto bg-white p-8 shadow-lg rounded-2xl mt-10">

        <!-- Heading -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-yellow-900">Login to NurseAssist</h1>
            <p class="text-sm text-gray-500 mt-1">Welcome back! Please enter your credentials.</p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500" />
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500" />
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-yellow-600 shadow-sm focus:ring-yellow-500">
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-yellow-900 hover:underline" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                    class="w-full bg-yellow-900 text-white py-3 rounded-lg hover:bg-yellow-700 transition">
                    Login
                </button>
            </div>
        </form>

        <!-- Sign Up Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-yellow-900 font-semibold hover:underline">
                    Sign Up
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>
