<x-guest-layout>
    <!-- Logo and Brand -->
    <div class="mb-8 text-center">
        <div class="mb-4">
            <svg class="w-24 h-24 mx-auto" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Simplified angel with crown icon - you can replace this with your actual logo -->
                <path d="M50 10 L60 25 L40 25 Z" stroke="black" stroke-width="1" fill="none"/>
                <path d="M30 35 Q50 20 70 35" stroke="black" stroke-width="1" fill="none"/>
            </svg>
        </div>
        <h1 class="text-2xl font-medium tracking-wider">Kubo Kopi</h1>
    </div>

    <div class="mb-6 text-center">
        <h2 class="text-lg font-medium text-gray-600">Lupa Password?</h2>
        <p class="mt-2 text-sm text-gray-600">
            Masukkan email Anda dan kami akan mengirimkan link untuk mengatur ulang password.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-text-input 
                id="email" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus
                placeholder="Masukkan email"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-0 focus:border-gray-400 placeholder-gray-500"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <button type="submit" class="w-full py-3 px-4 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-sm">
                Kirim Link Reset Password
            </button>
        </div>

        <!-- Back to Login -->
        <div class="text-center text-sm">
            <a href="{{ route('login') }}" class="text-gray-800 font-medium hover:text-gray-600">
                Kembali ke Login
            </a>
        </div>
    </form>
</x-guest-layout>
