<x-app-layout>
    <x-slot name="header">
            <h2 class="text-xl font-semibold text-white">
            Arsip Pengajuan Selesai
        </h2>
            <p class="text-sm text-white/80">
            Daftar pengajuan dengan status SELESAI
        </p>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

        <div class="bg-white shadow rounded mb-6 p-4 text-center">
            <p class="text-sm text-green-600">Total Selesai</p>
            <p class="text-2xl font-bold text-green-600">
                {{ $statistik['SELESAI'] ?? 0 }}
            </p>
        </div>

        <div class="bg-white shadow rounded">
            <div class="p-4 border-b">
                <h3 class="font-semibold text-lg">
                    Daftar Arsip
                </h3>
            </div>

                <form method="GET" class="flex gap-2 flex-wrap">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari data..."
               class="border rounded px-3 py-2 text-sm">

        <button class="bg-blue-600 text-white px-4 py-2 rounded text-sm">
            Cari
        </button>

        <a href="{{ route(Route::currentRouteName()) }}"
           class="bg-gray-500 text-white px-4 py-2 rounded text-sm">
            Reset
        </a>

    </form>
            

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Nama Debitur</th>
                            <th class="px-4 py-2 text-left">No Sertifikat</th>
                            <th class="px-4 py-2 text-left">PPAT</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuans as $index => $p)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $p->nama_debitur }}</td>
                                <td class="px-4 py-2">{{ $p->no_sertifikat }}</td>
                                <td class="px-4 py-2">
                                    {{ $p->ppat->name ?? '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded bg-green-600 text-white text-xs">
                                        SELESAI
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    @if (auth()->user()->role === 'BANK')
                                        <a href="{{ route('bank.pengajuan.show', $p->id) }}"
                                            class="text-blue-600 hover:underline">
                                            Detail
                                        </a>
                                    @else
                                        <a href="{{ route('pengajuan.show', $p->id) }}"
                                            class="text-blue-600 hover:underline">
                                            Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500">
                                    Belum ada arsip selesai
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
