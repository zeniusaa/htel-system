<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Hak Tanggungan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen">

    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">

        {{-- ============================
         SIDEBAR
    ============================= --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed z-40 w-64 bg-[#00A39D] text-white min-h-screen transform transition-transform duration-300 flex flex-col">

            {{-- Logo --}}
            <div class="px-6 py-5 border-b border-white/20 flex justify-between items-center">
                <div>
                    <h1 class="text-base font-bold leading-tight">
                        Hak Tanggungan Elektronik
                    </h1>
                    <p class="text-xs opacity-75 mt-0.5">
                        Monitoring Pengajuan HT-el
                    </p>
                </div>

                <button @click="sidebarOpen = false"
                    class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-white/20 transition text-white">
                    ✕
                </button>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-5 space-y-1 text-sm">

                <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-lg hover:bg-white/20 transition">
                    Dashboard
                </a>

                <a href="{{ route('arsip.selesai') }}"
                    class="block px-4 py-2.5 rounded-lg hover:bg-white/20 transition">
                    Arsip
                </a>

                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 rounded-lg hover:bg-white/20 transition">
                    Profile
                </a>

                @if (auth()->user()->role == 'BANK')
                    <a href="{{ route('users.index') }}"
                        class="block px-4 py-2.5 rounded-lg hover:bg-white/20 transition">
                        Kelola User
                    </a>
                @endif

            </nav>

            {{-- User + Logout --}}
            <div class="px-4 py-4 border-t border-white/20 space-y-3">

                <div class="px-2">
                    <p class="text-sm font-semibold text-white truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-white/60 truncate">
                        {{ auth()->user()->role }}
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-2.5 rounded-lg hover:bg-white/20 text-white text-sm transition">
                        Logout
                    </button>
                </form>

                <p class="text-xs text-white/40 text-center pb-1">
                    © {{ date('Y') }} Sistem Koordinasi HTEL
                </p>

            </div>

        </aside>

        {{-- Overlay --}}
        <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/40 z-30">
        </div>

        {{-- ============================
         MAIN CONTENT
    ============================= --}}
        <div class="flex-1 flex flex-col min-h-screen">

            {{-- TOPBAR --}}
            <header class="bg-[#00A39D] shadow-sm px-6 py-4 flex items-center justify-between gap-4 text-white">

                <div class="flex items-center gap-4 min-w-0">

                    {{-- Hamburger --}}
                    <button @click="sidebarOpen = true"
                        class="shrink-0 w-9 h-9 flex items-center justify-center rounded-lg text-white hover:bg-white/20 transition">
                        ☰
                    </button>

                    {{-- Page Title --}}
                    <div class="min-w-0 text-white">
                        {{ $header ?? '' }}
                    </div>

                </div>

                {{-- Optional Actions --}}
                @isset($actions)
                    <div class="shrink-0 text-white">
                        {{ $actions }}
                    </div>
                @endisset

            </header>

            {{-- Content --}}
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>

        </div>

    </div>

    {{-- AlpineJS --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</body>

</html>
