<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-white">
                Selamat Datang, {{ auth()->user()->name }}
            </h2>
            <p class="text-sm text-white/80">
                Dashboard Bank – Sistem Pengajuan Hak Tanggungan
            </p>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">

{{-- ================= STATISTIK ================= --}}
@php
    $currentStatus = request('status');

    function statusUrl($status) {
        return request('status') === $status
            ? route(Route::currentRouteName())
            : route(Route::currentRouteName(), ['status' => $status]);
    }
@endphp

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    @foreach ([
        'DIAJUKAN',
        'DIPROSES',
        'DITANGGUHKAN',
        'PERINTAH_SETOR',
        'DIBAYAR',
        'TERBIT_SHT'
    ] as $status)

        <a href="{{ statusUrl($status) }}"
           class="bg-white border border-gray-200 rounded-xl p-4 text-center shadow-sm hover:shadow-md transition
           {{ $currentStatus === $status ? 'ring-2 ring-[#00A39D] bg-[#F0FBFA]' : '' }}">

            <p class="text-xs text-gray-500 uppercase tracking-wide">
                {{ str_replace('_', ' ', $status) }}
            </p>

            <p class="text-2xl font-bold text-[#00A39D] mt-1">
                {{ $statistik[$status] ?? 0 }}
            </p>
        </a>
    @endforeach
</div>

<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-800">
        Daftar Pengajuan Masuk
    </h3>
</div>

{{-- ================= FILTER ================= --}}
<div class="bg-white p-4 rounded-xl shadow-sm mb-6 border border-gray-100">
    <form method="GET" class="flex flex-wrap gap-3 items-center">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari nama debitur / "
               class="border-gray-300 rounded-lg focus:border-[#00A39D] focus:ring-[#00A39D] text-sm w-full md:w-1/3">

        <select name="status"
                class="border-gray-300 rounded-lg focus:border-[#00A39D] focus:ring-[#00A39D] text-sm">
            <option value="">Semua Status</option>
            <option value="DIAJUKAN">Diajukan</option>
            <option value="DIPROSES">Diproses</option>
            <option value="DITANGGUHKAN">Ditangguhkan</option>
            <option value="PERINTAH_SETOR">Perintah Setor</option>
            <option value="DIBAYAR">Dibayar</option>
        </select>

        <button class="bg-[#00A39D] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#008C86]">
            Cari
        </button>

        <a href="{{ route(Route::currentRouteName()) }}"
           class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-300">
            Reset
        </a>
    </form>
</div>

{{-- ================= TABEL ================= --}}
<div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-[#F0FBFA] text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama Debitur</th>
                    <th class="px-4 py-3 text-left">PPAT</th>
                    <th class="px-4 py-3 text-left">No Sertifikat</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">

            @forelse ($pengajuans as $index => $p)

                @php
                    $badge = match ($p->status) {
                        'DIAJUKAN' => 'bg-blue-50 text-blue-700',
                        'DIPROSES' => 'bg-yellow-50 text-yellow-700',
                        'DITANGGUHKAN' => 'bg-red-50 text-red-700',
                        'PERINTAH_SETOR' => 'bg-purple-50 text-purple-700',
                        'DIBAYAR' => 'bg-green-50 text-green-700',
                        'TERBIT_SHT' => 'bg-[#E6F6F5] text-[#006D69]',
                        default => 'bg-gray-100 text-gray-600',
                    };
                @endphp

                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 font-medium">{{ $p->nama_debitur }}</td>
                    <td class="px-4 py-3">{{ $p->ppat->name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $p->no_sertifikat }}</td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                            {{ str_replace('_',' ',$p->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('bank.pengajuan.show',$p->id) }}"
                           class="text-[#00A39D] font-semibold hover:underline">
                            Detail
                        </a>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-gray-400">
                        Belum ada pengajuan masuk
                    </td>
                </tr>
            @endforelse

            </tbody>
        </table>
    </div>
</div>

    </div>
</x-app-layout>