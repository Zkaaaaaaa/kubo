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

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-text-input 
                id="name" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="Masukkan nama"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-0 focus:border-gray-400 placeholder-gray-500"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-text-input 
                id="email" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="username"
                placeholder="Masukkan email"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-0 focus:border-gray-400 placeholder-gray-500"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-text-input 
                id="password" 
                type="password"
                name="password"
                required 
                autocomplete="new-password"
                placeholder="Masukkan password"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-0 focus:border-gray-400 placeholder-gray-500"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-text-input 
                id="password_confirmation" 
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="Konfirmasi password"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-0 focus:border-gray-400 placeholder-gray-500"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Register Button -->
        <div>
            <button type="submit" class="w-full py-3 px-4 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-sm">
                Daftar
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center text-sm">
            <span class="text-gray-600">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-gray-800 font-medium hover:text-gray-600 ml-1">
                Masuk
            </a>
        </div>
    </form>
</x-guest-layout>

