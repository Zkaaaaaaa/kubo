<x-guest-layout>
    <h3 class="text-lg font-bold mb-3 flex items-center">
        <span><img width="40px" class="me-2" src="{{ asset('logo.jpeg') }}" alt=""></span>
        Verifikasi Alamat Email Kamu
    </h3>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Terima kasih sudah mendaftar! Sebelum mulai, yuk cek email kamu dan klik link verifikasi yang baru aja kami
        kirim.
        Belum dapat emailnya? Tenang, kami bisa kirim ulang kok!
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            Link verifikasi baru sudah kami kirim ke email yang kamu daftarkan. Cek inbox (atau folder spam) ya!
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Kirim Ulang Link Verifikasi') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
