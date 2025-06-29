<x-guest-layout>
    <h3 class="text-2xl font-bold mb-3 flex items-center justify-center"><span><img width="40px" class="me-2"
                src="{{ asset('logo.jpeg') }}" alt=""></span>{{ __('KUBO KOPI') }}</h3>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
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
