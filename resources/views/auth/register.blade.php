<x-guest-layout>
    <h3 class="text-2xl font-bold mb-3 flex items-center justify-center"><span><img width="40px" class="me-2"
                src="{{ asset('logo.jpeg') }}" alt=""></span>{{ __('KUBO KOPI') }}</h3>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <input id="name" type="name" name="name" required autocomplete="current-name"
                placeholder="Masukkan Nama"
                class="w-full h-12 px-4 pr-12 border border-gray-300 rounded-lg focus:ring-0 placeholder-gray-400" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <input id="email" type="email" name="email" required autocomplete="current-email"
                placeholder="Masukkan Email"
                class="w-full h-12 px-4 pr-12 border border-gray-300 rounded-lg focus:ring-0 placeholder-gray-400" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative">
            <input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="Masukkan Password"
                class="w-full h-12 px-4 pr-12 border border-gray-300 rounded-lg focus:ring-0 placeholder-gray-400" />

            <button type="button" id="togglePassword"
                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-white focus:outline-none">
                <i class="fa-solid fa-eye" id="iconToggle"></i>
            </button>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="relative">
            <input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password" placeholder="Konfirmasi Password"
                class="w-full h-12 px-4 pr-12 border border-gray-300 rounded-lg focus:ring-0 placeholder-gray-400" />

            <button type="button" id="toggleConfirm"
                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-white focus:outline-none">
                <i class="fa-solid fa-eye" id="iconConfirm"></i>
            </button>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Register Button -->
        <div>
            <button type="submit"
                class="w-full py-3 px-4 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-sm">
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

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const iconToggle = document.getElementById('iconToggle');

        togglePassword.addEventListener('click', function() {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            iconToggle.classList.toggle('fa-eye');
            iconToggle.classList.toggle('fa-eye-slash');
        });

        const confirmInput = document.getElementById('password_confirmation');
        const toggleConfirm = document.getElementById('toggleConfirm');
        const iconConfirm = document.getElementById('iconConfirm');

        toggleConfirm.addEventListener('click', function() {
            const isPassword = confirmInput.type === 'password';
            confirmInput.type = isPassword ? 'text' : 'password';
            iconConfirm.classList.toggle('fa-eye');
            iconConfirm.classList.toggle('fa-eye-slash');
        });
    </script>
</x-guest-layout>
