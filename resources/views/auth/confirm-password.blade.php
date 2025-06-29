<x-guest-layout>
    <h3 class="text-2xl font-bold mb-3 flex items-center justify-center"><span><img width="40px" class="me-2"
                src="{{ asset('logo.jpeg') }}" alt=""></span>{{ __('KUBO KOPI') }}</h3>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

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

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
