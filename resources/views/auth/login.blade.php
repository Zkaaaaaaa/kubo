<x-guest-layout>
    <h3 class="text-2xl font-bold mb-3 flex items-center justify-center"><span><img width="40px" class="me-2"
                src="{{ asset('logo.jpeg') }}" alt=""></span>{{ __('KUBO KOPI') }}</h3>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-3">
        @csrf

        <!-- Email Address -->
        <div>
            <input id="email" type="email" name="email" required autocomplete="current-email"
                placeholder="Masukkan Email"
                class="w-full h-12 px-4 pr-12 border border-gray-300 rounded-lg focus:ring-0 placeholder-gray-400" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative">
            <input id="password" type="password" name="password" required autocomplete="current-password"
                placeholder="Masukkan Password"
                class="w-full h-12 px-4 pr-12 border border-gray-300 rounded-lg focus:ring-0 placeholder-gray-400" />

            <button type="button" id="togglePassword"
                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-white focus:outline-none">
                <i class="fa-solid fa-eye" id="iconToggle"></i>
            </button>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-300 text-gray-600 shadow-sm focus:border-gray-300 focus:ring focus:ring-gray-200 focus:ring-opacity-50">
                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <!-- Login Button -->
        <div class="pt-2">
            <button type="submit"
                class="w-full h-12 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
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

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const iconToggle = document.getElementById('iconToggle');

        togglePassword.addEventListener('click', function() {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';

            // Ganti ikon Font Awesome
            iconToggle.classList.toggle('fa-eye');
            iconToggle.classList.toggle('fa-eye-slash');
        });
    </script>
</x-guest-layout>
