<x-guest-layout>
    <x-slot name="header">
        Registrasi Akun
    </x-slot>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" type="text" name="name"
                :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email"
                name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" type="password"
                name="password" required />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="password_confirmation"
                type="password" name="password_confirmation" required />
        </div>

        <x-primary-button class="w-full">
            Daftar
        </x-primary-button>

        <p class="text-sm text-center text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}"
               class="text-[#00A39D] font-semibold hover:underline">
                Login
            </a>
        </p>
    </form>
</x-guest-layout>