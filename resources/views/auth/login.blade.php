<x-guest-layout>
    <x-slot name="header">
        Login Akun
    </x-slot>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email"
                :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password"
                name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input type="checkbox" name="remember"
                    class="rounded border-gray-300 text-[#00A39D] focus:ring-[#00A39D]">
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm text-[#00A39D] hover:underline">
                    Lupa Password?
                </a>
            @endif
        </div>

        <x-primary-button class="w-full">
            Login
        </x-primary-button>

        <p class="text-sm text-center text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}"
               class="text-[#F8AD3C] font-semibold hover:underline">
                Daftar
            </a>
        </p>
    </form>
</x-guest-layout>