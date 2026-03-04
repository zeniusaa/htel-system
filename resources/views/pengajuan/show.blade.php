<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-[#00A39D] flex items-center justify-center">
            </div>
            <h2 class="font-semibold text-xl text-white">
                Detail Pengajuan
            </h2>
        </div>
    </x-slot>

    <x-slot name="actions">
        <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('dashboard') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition-colors duration-200">
            Kembali
        </a>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- ============================
             DATA PENGAJUAN
        ============================= --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

            <div class="bg-[#00A39D] px-6 py-4 flex items-center justify-between">
                <h3 class="text-base font-semibold text-white flex items-center gap-2">
                    Data Pengajuan
                </h3>

                <div class="flex items-center gap-3">
                    {{-- Status Badge --}}
                    @php
                        $statusColor = match ($pengajuan->status) {
                            'UPLOAD' => 'bg-gray-100 text-gray-700',
                            'DIAJUKAN' => 'bg-blue-100 text-blue-700',
                            'DIPROSES' => 'bg-indigo-100 text-indigo-700',
                            'DITANGGUHKAN' => 'bg-yellow-100 text-yellow-700',
                            'PERINTAH_SETOR' => 'bg-orange-100 text-orange-700',
                            'DIBAYAR' => 'bg-teal-100 text-teal-700',
                            'TERBIT_SHT' => 'bg-purple-100 text-purple-700',
                            'SELESAI' => 'bg-green-100 text-green-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                        {{ $pengajuan->status }}
                    </span>

                    {{-- Tombol Edit --}}
                    @if (in_array($pengajuan->status, ['UPLOAD', 'DITANGGUHKAN']))
                        <a href="{{ route('pengajuan.edit', $pengajuan->id) }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 hover:bg-white/30 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                            Edit Data
                        </a>
                    @endif
                </div>
            </div>

            <div class="p-6 space-y-6">

                {{-- Debitur --}}
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Debitur</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach ([
        'Nama Debitur' => $pengajuan->nama_debitur,
        'NIK' => $pengajuan->nik,
        'Tanggal Lahir' => $pengajuan->tanggal_lahir,
        'Pekerjaan' => $pengajuan->pekerjaan,
    ] as $label => $value)
                            <div class="bg-gray-50 rounded-lg px-4 py-3">
                                <p class="text-xs text-gray-500 mb-0.5">{{ $label }}</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $value }}</p>
                            </div>
                        @endforeach

                        <div class="bg-gray-50 rounded-lg px-4 py-3 md:col-span-2 lg:col-span-3">
                            <p class="text-xs text-gray-500 mb-0.5">Alamat</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $pengajuan->alamat }}</p>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- Sertifikat --}}
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Sertifikat</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach ([
        'Jenis Hak' => $pengajuan->jenis_hak,
        'No Sertifikat' => $pengajuan->no_sertifikat,
        'Pemilik Sertifikat' => $pengajuan->pemilik_sertifikat,
        'Kantor Pertanahan' => $pengajuan->kantor_pertanahan,
        'Desa' => $pengajuan->desa,
        'Kecamatan' => $pengajuan->kecamatan,
        'Kota/Kab' => $pengajuan->kota,
        'Provinsi' => $pengajuan->provinsi,
    ] as $label => $value)
                            <div class="bg-gray-50 rounded-lg px-4 py-3">
                                <p class="text-xs text-gray-500 mb-0.5">{{ $label }}</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- APHT --}}
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">APHT</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <div class="bg-gray-50 rounded-lg px-4 py-3">
                            <p class="text-xs text-gray-500 mb-0.5">No APHT</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $pengajuan->no_apht }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg px-4 py-3">
                            <p class="text-xs text-gray-500 mb-0.5">Tanggal APHT</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $pengajuan->tanggal_apht }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg px-4 py-3">
                            <p class="text-xs text-gray-500 mb-0.5">Peringkat</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $pengajuan->peringkat_apht }}</p>
                        </div>
                        <div
                            class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg px-4 py-3 border-l-4 border-orange-400 md:col-span-2">
                            <p class="text-xs text-gray-500 mb-0.5">Nominal</p>
                            <p class="text-lg font-bold text-orange-600">
                                Rp {{ number_format($pengajuan->nominal, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ============================
             RIWAYAT VALIDASI
        ============================= --}}
        @if ($pengajuan->validasis->count())
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

                <div class="bg-[#00A39D] px-6 py-4">
                    <h3 class="text-base font-semibold text-white flex items-center gap-2">
                        Riwayat Validasi
                    </h3>
                </div>

                <div class="p-6 space-y-3">
                    @foreach ($pengajuan->validasis as $v)
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg px-4 py-3">
                            <div class="flex justify-between items-start">
                                <div class="space-y-1">
                                    <p class="text-sm font-semibold text-gray-800">{{ $v->status_validasi }}</p>
                                    <p class="text-sm text-gray-600">{{ $v->catatan ?? '-' }}</p>
                                </div>
                                <span class="text-xs text-gray-400 shrink-0 ml-4">{{ $v->created_at }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ============================
             DOKUMEN PENGAJUAN
        ============================= --}}
        @php
            $jenisDokumen = ['AKAD', 'APHT', 'SPA', 'KTP', 'SERTIFIKAT', 'LAMP13'];
            $dokumenByJenis = $pengajuan->dokumen->keyBy('jenis_dokumen');
            $bisaEdit = in_array($pengajuan->status, ['UPLOAD', 'DITANGGUHKAN']);
        @endphp

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

            <div class="bg-[#00A39D] px-6 py-4">
                <h3 class="text-base font-semibold text-white flex items-center gap-2">
                    Dokumen Pengajuan
                </h3>
            </div>

            <div class="p-6 space-y-3">
                @foreach ($jenisDokumen as $jenis)
                    <div
                        class="flex items-center justify-between border border-gray-100 rounded-lg px-4 py-3 hover:bg-gray-50 transition-colors duration-150">

                        <div class="flex items-center gap-3">
                            @if (isset($dokumenByJenis[$jenis]))
                                <span
                                    class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                                </span>
                            @else
                                <span
                                    class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                                </span>
                            @endif
                            <span class="text-sm font-semibold text-gray-800">{{ $jenis }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            @if (!isset($dokumenByJenis[$jenis]))
                                @if ($bisaEdit)
                                    <form method="POST"
                                        action="{{ route('pengajuan.uploadDokumen', $pengajuan->id) }}"
                                        enctype="multipart/form-data" class="flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="jenis_dokumen" value="{{ $jenis }}">
                                        <input type="file" name="file" required
                                            class="text-xs text-gray-600 border border-gray-300 rounded-lg px-2 py-1.5">
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-[#00A39D] hover:bg-[#008C86] text-white text-xs font-medium rounded-lg transition-colors duration-200">
                                            Upload
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-400 italic">Belum ada</span>
                                @endif
                            @else
                                <button
                                    onclick="document.getElementById('modal-{{ $dokumenByJenis[$jenis]->id }}').classList.remove('hidden')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                                    Lihat
                                </button>

                                @if ($bisaEdit)
                                    <form method="POST"
                                        action="{{ route('pengajuan.hapusDokumen', $dokumenByJenis[$jenis]->id) }}"
                                        onsubmit="return confirm('Hapus dokumen ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition-colors duration-200">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ============================
             SPS & BUKTI BAYAR
        ============================= --}}
        @php
            $sps = $dokumen['SPS'] ?? null;
            $buktiBayar = $dokumen['BAYAR'] ?? null;
        @endphp

        @if ($sps || $buktiBayar)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

                <div class="bg-[#00A39D] px-6 py-4">
                    <h3 class="text-base font-semibold text-white flex items-center gap-2">
                        Surat Perintah Setor (SPS) & Bukti Bayar
                    </h3>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- SPS --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-3">Dokumen SPS</p>
                        @if ($sps)
                            <iframe src="{{ asset('storage/' . $sps->file_path) }}"
                                class="w-full h-96 border border-gray-200 rounded-lg">
                            </iframe>
                        @else
                            <div
                                class="flex items-center justify-center h-48 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                                <p class="text-sm text-gray-400 italic">SPS belum tersedia.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Bukti Bayar --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-3">Bukti Pembayaran</p>

                        @if ($pengajuan->status === 'PERINTAH_SETOR' && !$buktiBayar)
                            <form method="POST" action="{{ route('pengajuan.uploadBuktiBayar', $pengajuan->id) }}"
                                enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                <input type="file" name="file_bayar" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm">
                                <button type="submit"
                                    class="w-full bg-[#00A39D] hover:bg-[#008C86] text-white py-2.5 rounded-lg text-sm font-medium transition-colors duration-200">
                                    Kirim Bukti Bayar
                                </button>
                            </form>
                        @elseif ($buktiBayar)
                            <iframe src="{{ asset('storage/' . $buktiBayar->file_path) }}"
                                class="w-full h-96 border border-gray-200 rounded-lg">
                            </iframe>
                        @else
                            <div
                                class="flex items-center justify-center h-48 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                                <p class="text-sm text-gray-400 italic">Menunggu pembayaran.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        @endif

        {{-- ============================
             SHT
        ============================= --}}
        @php $sht = $dokumen['SHT'] ?? null; @endphp

        @if ($sht)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

                <div class="bg-[#00A39D] px-6 py-4">
                    <h3 class="text-base font-semibold text-white flex items-center gap-2">
                        Sertifikat Hak Tanggungan (SHT)
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    <iframe src="{{ asset('storage/' . $sht->file_path) }}"
                        class="w-full h-[500px] border border-gray-200 rounded-lg">
                    </iframe>

                    <div class="flex flex-wrap gap-3">
                        @if (in_array($pengajuan->status, ['TERBIT_SHT', 'SELESAI']))
                            <a href="{{ route('pengajuan.downloadSht', $pengajuan->id) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-[#00A39D] hover:bg-[#008C86] text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                Unduh SHT
                            </a>
                        @endif

                        @if ($pengajuan->status === 'TERBIT_SHT')
                            <form method="POST" action="{{ route('pengajuan.selesai', $pengajuan->id) }}">
                                @csrf
                                <button type="submit" onclick="return confirm('Selesaikan pengajuan ini?')"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-700 hover:bg-green-800 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    Konfirmasi & Selesaikan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- ============================
             AKSI BAWAH
        ============================= --}}
        @php
            $dokumenWajib = collect($jenisDokumen)->reject(fn($j) => $j === 'LAMP13');
            $lengkap = $dokumenWajib->every(fn($j) => isset($dokumenByJenis[$j]));
        @endphp

        @if ($bisaEdit)
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 px-6 py-5 flex justify-between items-center">

                <form method="POST" action="{{ route('pengajuan.destroy', $pengajuan->id) }}"
                    onsubmit="return confirm('Yakin hapus pengajuan ini beserta semua dokumen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-700 hover:bg-red-800 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        Hapus Pengajuan
                    </button>
                </form>

                @if ($lengkap)
                    <form method="POST" action="{{ route('pengajuan.ajukan', $pengajuan->id) }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            Ajukan ke Bank
                        </button>
                    </form>
                @else
                    <p class="text-sm text-red-500 font-medium">
                        Lengkapi semua dokumen untuk mengajukan.
                    </p>
                @endif

            </div>
        @endif

    </div>

    {{-- ============================
         MODAL VIEWER
    ============================= --}}
    @foreach ($pengajuan->dokumen as $d)
        <div id="modal-{{ $d->id }}"
            class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 p-4"
            onclick="if(event.target===this) this.classList.add('hidden')">
            <div class="bg-white w-full max-w-4xl h-[80vh] rounded-xl shadow-2xl flex flex-col overflow-hidden">

                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">{{ $d->jenis_dokumen }}</h3>
                    <button onclick="document.getElementById('modal-{{ $d->id }}').classList.add('hidden')"
                        class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center text-gray-500 transition-colors duration-200">
                    </button>
                </div>

                <div class="flex-1 p-4">
                    <iframe src="{{ asset('storage/' . $d->file_path) }}"
                        class="w-full h-full border border-gray-200 rounded-lg">
                    </iframe>
                </div>

            </div>
        </div>
    @endforeach

</x-app-layout>
