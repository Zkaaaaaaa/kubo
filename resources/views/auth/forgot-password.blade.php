<x-guest-layout>
    <h3 class="text-2xl font-bold mb-3 flex items-center justify-center"><span><img width="40px" class="me-2"
                src="{{ asset('logo.jpeg') }}" alt=""></span>{{ __('KUBO KOPI') }}</h3>
    <x-auth-session-status class="mb-4" :status="session('status')" />

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
            <input id="email" type="email" name="email" required autocomplete="current-email"
                placeholder="Masukkan Email"
                class="w-full h-12 px-4 pr-12 border border-gray-300 rounded-lg focus:ring-0 placeholder-gray-400" />
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
