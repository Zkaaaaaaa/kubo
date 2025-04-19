<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-start pt-20 bg-white px-4">
        <!-- Logo and Brand -->
        <div class="mb-12 text-center">
            <div class="mb-4">
                <svg class="w-16 h-16 mx-auto" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Simplified angel with crown icon - you can replace this with your actual logo -->
                    <path d="M50 10 L60 25 L40 25 Z" stroke="black" stroke-width="1" fill="none"/>
                    <path d="M30 35 Q50 20 70 35" stroke="black" stroke-width="1" fill="none"/>
                </svg>
            </div>
            <h1 class="text-2xl font-medium tracking-wider text-gray-800">Kubo Kopi</h1>
        </div>

        <div class="w-full max-w-[320px]">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-3">
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
                        autocomplete="username"
                        placeholder="Masukkan email"
                        class="w-full h-12 px-4 bg-gray-900 text-white border-0 rounded-lg focus:ring-0 placeholder-gray-400 focus:bg-gray-900"
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
                        autocomplete="current-password"
                        placeholder="Masukkan Password"
                        class="w-full h-12 px-4 bg-gray-900 text-white border-0 rounded-lg focus:ring-0 placeholder-gray-400 focus:bg-gray-900"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <label for="remember_me" class="inline-flex items-center">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            name="remember" 
                            class="rounded border-gray-300 text-gray-600 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50"
                        >
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                </div>

                <!-- Login Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full h-12 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                        Masuk
                    </button>
                </div>

                <!-- Additional Links -->
                <div class="flex flex-col items-center space-y-3 pt-2">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 hover:text-gray-800" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <div class="text-sm">
                            <span class="text-gray-600">Belum punya akun?</span>
                            <a href="{{ route('register') }}" class="text-gray-800 font-medium hover:text-gray-600 ml-1">
                                Daftar
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Style untuk input saat diisi */
        input:not(:placeholder-shown) {
            background-color: rgb(241, 245, 249) !important;
            color: black !important;
        }
    </style>
</x-guest-layout>
