<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Profil Pengguna</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 space-y-6">

        {{-- HERO CARD --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#00A39D] to-[#007C78] px-8 py-8">
                <div class="flex items-center gap-5">
                    <div class="min-w-0">
                        <p class="text-white font-bold text-lg leading-tight truncate">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-white/70 text-sm mt-0.5 truncate">
                            {{ auth()->user()->email }}
                        </p>
                        <span class="inline-block mt-2 px-3 py-0.5 rounded-full bg-white/20 text-white text-xs font-semibold tracking-wide">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- FORM INFORMASI PROFIL --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-[#00A39D]/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#00A39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Informasi Profil</h3>
                    <p class="text-xs text-gray-400">Perbarui nama akun Anda</p>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- FORM UBAH PASSWORD --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-[#00A39D]/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#00A39D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Ubah Password</h3>
                    <p class="text-xs text-gray-400">Gunakan password yang kuat dan unik</p>
                </div>
            </div>
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- LOGOUT --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Keluar</p>
                        <p class="text-xs text-gray-400">Akhiri sesi Anda sekarang</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>

</x-app-layout>
