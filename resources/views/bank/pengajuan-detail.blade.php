<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-[#00A39D] flex items-center justify-center">
            </div>
            <h2 class="font-semibold text-xl text-white">
            Validasi Pengajuan</h2>
        </div>
    </x-slot>

    <x-slot name="actions">
        <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('dashboard') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition-colors duration-200">
            Kembali
        </a>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- ============================
             BLOK 1 — DATA DEBITUR
        ============================= --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

            <div class="bg-[#00A39D] px-6 py-4">
                <h3 class="text-base font-semibold text-white flex items-center gap-2">
                    Data Debitur
                </h3>
            </div>

            <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- FILE KTP --}}
                <div class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center min-h-[400px] overflow-hidden">
                    @if (isset($dokumen['KTP']))
                        <iframe id="viewer-debitur"
                            src="{{  $dokumen['KTP']->file_path) }}"
                            class="w-full h-96 rounded-lg">
                        </iframe>
                    @else
                        <div class="text-center py-8">
                            <span class="mt-2 block text-sm font-medium text-gray-400">File KTP tidak tersedia</span>
                        </div>
                    @endif
                </div>

                {{-- DATA DEBITUR --}}
                <div class="space-y-3">
                    @foreach ([
                        'Nama'         => $pengajuan->nama_debitur,
                        'Tanggal Lahir'=> $pengajuan->tanggal_lahir,
                        'Nomor KTP'    => $pengajuan->nik,
                        'Alamat'       => $pengajuan->alamat,
                    ] as $label => $value)
                        <div class="bg-gray-50 hover:bg-gray-100 rounded-lg px-4 py-3 transition-colors duration-150">
                            <p class="text-xs text-gray-500 font-medium mb-0.5">{{ $label }}</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $value }}</p>
                        </div>
                    @endforeach

                    {{-- Tombol Dokumen --}}
                    <div class="pt-2">
                        <p class="text-xs text-gray-500 font-medium mb-2">Dokumen Tersedia</p>
                        <div class="flex flex-wrap gap-2">
                            @if (isset($dokumen['KTP']))
                                <button onclick="gantiFile('viewer-debitur', '{{  $dokumen['KTP']->file_path) }}', this)"
                                    class="file-btn active">
                                    KTP
                                </button>
                            @endif

                            @if (isset($dokumen['AKAD']))
                                <button onclick="gantiFile('viewer-debitur', '{{  $dokumen['AKAD']->file_path) }}', this)"
                                    class="file-btn">
                                    AKAD
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ============================
             BLOK 2 — SERTIFIKAT
        ============================= --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

            <div class="bg-[#00A39D] px-6 py-4">
                <h3 class="text-base font-semibold text-white flex items-center gap-2">
                    Sertifikat Tanah
                </h3>
            </div>

            <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- FILE SERTIFIKAT --}}
                <div class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center min-h-[400px] overflow-hidden">
                    @if (isset($dokumen['SERTIFIKAT']))
                        <iframe src="{{  $dokumen['SERTIFIKAT']->file_path }}"
                            class="w-full h-96 rounded-lg">
                        </iframe>
                    @else
                        <div class="text-center py-8">
                            <span class="mt-2 block text-sm font-medium text-gray-400">File Sertifikat tidak tersedia</span>
                        </div>
                    @endif
                </div>

                {{-- DATA SERTIFIKAT --}}
                <div class="space-y-3">
                    @foreach ([
                        'No Sertifikat'  => $pengajuan->no_sertifikat,
                        'AN Sertifikat'  => $pengajuan->pemilik_sertifikat,
                        'Desa'           => $pengajuan->desa,
                        'Kecamatan'      => $pengajuan->kecamatan,
                        'Kab/Kota'       => $pengajuan->kota,
                    ] as $label => $value)
                        <div class="bg-gray-50 hover:bg-gray-100 rounded-lg px-4 py-3 transition-colors duration-150">
                            <p class="text-xs text-gray-500 font-medium mb-0.5">{{ $label }}</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        {{-- ============================
             BLOK 3 — APHT
        ============================= --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

            <div class="bg-[#00A39D] px-6 py-4">
                <h3 class="text-base font-semibold text-white flex items-center gap-2">
                    Akta Pembebanan Hak Tanggungan (APHT)
                </h3>
            </div>

            <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- FILE APHT --}}
                <div class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center min-h-[400px] overflow-hidden">
                    @if (isset($dokumen['APHT']))
                        <iframe id="viewer-apht"
                            src="{{  $dokumen['APHT']->file_path) }}"
                            class="w-full h-96 rounded-lg">
                        </iframe>
                    @else
                        <div class="text-center py-8">
                            <span class="mt-2 block text-sm font-medium text-gray-400">File APHT tidak tersedia</span>
                        </div>
                    @endif
                </div>

                {{-- DATA APHT --}}
                <div class="space-y-3">
                    @foreach ([
                        'No APHT'       => $pengajuan->no_apht,
                        'Tanggal APHT'  => $pengajuan->tanggal_apht,
                        'Peringkat'     => $pengajuan->peringkat_apht,
                        'Kantor Cabang' => $pengajuan->kantor_pertanahan,
                    ] as $label => $value)
                        <div class="bg-gray-50 hover:bg-gray-100 rounded-lg px-4 py-3 transition-colors duration-150">
                            <p class="text-xs text-gray-500 font-medium mb-0.5">{{ $label }}</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $value }}</p>
                        </div>
                    @endforeach

                    {{-- Nominal --}}
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg px-4 py-3 border-l-4 border-orange-400">
                        <p class="text-xs text-gray-500 font-medium mb-0.5">Nominal</p>
                        <p class="text-xl font-bold text-orange-600">
                            Rp {{ number_format($pengajuan->nominal, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- Tombol Dokumen --}}
                    <div class="pt-2">
                        <p class="text-xs text-gray-500 font-medium mb-2">Dokumen Tersedia</p>
                        <div class="flex flex-wrap gap-2">
                            @if (isset($dokumen['APHT']))
                                <button onclick="gantiFile('viewer-apht', '{{  $dokumen['APHT']->file_path) }}', this)"
                                    class="file-btn active">
                                    APHT
                                </button>
                            @endif

                            @if (isset($dokumen['SPA']))
                                <button onclick="gantiFile('viewer-apht', '{{  $dokumen['SPA']->file_path) }}', this)"
                                    class="file-btn">
                                    SPA
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ============================
             LAMPIRAN 13
        ============================= --}}
        @php $lamp13 = $dokumen['LAMP13'] ?? null; @endphp

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

            <div class="bg-[#00A39D] px-6 py-4">
                <h3 class="text-base font-semibold text-white flex items-center gap-2">
                    Lampiran 13
                </h3>
            </div>

            <div class="p-6">
                @if ($lamp13)
                    <iframe src="{{ $lamp13->file_path }}"
                        class="w-full h-96 border border-gray-200 rounded-lg">
                    </iframe>

                    @if ($pengajuan->status === 'DIAJUKAN')
                        <div class="mt-4">
                            <form method="POST" action="{{ route('bank.hapusLamp13', $pengajuan->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus Lampiran 13?')"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    Hapus Lampiran 13
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <form method="POST" action="{{ route('bank.generateLamp13', $pengajuan->id) }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-[#00A39D] hover:bg-[#008C86] text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            Buat Lampiran 13
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- ============================
             SPS & BUKTI BAYAR
        ============================= --}}
        @if (in_array($pengajuan->status, ['DIPROSES', 'PERINTAH_SETOR', 'DIBAYAR', 'TERBIT_SHT', 'SELESAI']))

            @php
                $sps       = $dokumen['SPS']   ?? null;
                $buktiBayar = $dokumen['BAYAR'] ?? null;
            @endphp

            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

                <div class="bg-[#00A39D] px-6 py-4">
                    <h3 class="text-base font-semibold text-white flex items-center gap-2">
                        Surat Perintah Setor (SPS)
                    </h3>
                </div>

                <div class="p-6">

                    {{-- Upload SPS (hanya jika DIPROSES & belum ada SPS) --}}
                    @if ($pengajuan->status === 'DIPROSES' && !$sps)
                        <form method="POST" action="{{ route('bank.pengajuan.uploadSps', $pengajuan->id) }}"
                            enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    Pilih File SPS (PDF)
                                </label>
                                <input type="file" name="file_sps" accept="application/pdf" required
                                    class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent">
                            </div>

                            <button type="submit"
                                class="w-full bg-[#00A39D] hover:bg-[#008C86] text-white py-2.5 rounded-lg font-medium text-sm transition-colors duration-200">
                                Kirim SPS
                            </button>
                        </form>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Kolom SPS --}}
                            <div>
                                <p class="text-sm font-semibold text-gray-700 mb-3">Dokumen SPS</p>
                                @if ($sps)
                                    <iframe src="{{  $sps->file_path }}"
                                        class="w-full h-96 border border-gray-200 rounded-lg">
                                    </iframe>
                                @else
                                    <p class="text-sm text-gray-400 italic">SPS belum tersedia.</p>
                                @endif
                            </div>

                            {{-- Kolom Bukti Bayar --}}
                            <div>
                                <p class="text-sm font-semibold text-gray-700 mb-3">Bukti Pembayaran</p>
                                @if (in_array($pengajuan->status, ['DIBAYAR', 'TERBIT_SHT', 'SELESAI']) && $buktiBayar)
                                    <iframe src="{{  $buktiBayar->file_path }}"
                                        class="w-full h-96 border border-gray-200 rounded-lg">
                                    </iframe>
                                @elseif ($pengajuan->status === 'PERINTAH_SETOR')
                                    <div class="flex items-center justify-center h-48 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                                        <p class="text-sm text-gray-400 italic">Menunggu pembayaran dari PPAT.</p>
                                    </div>
                                @else
                                    <div class="flex items-center justify-center h-48 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                                        <p class="text-sm text-gray-400 italic">Bukti bayar belum tersedia.</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    @endif

                </div>
            </div>

        @endif

        {{-- ============================
             FORM VALIDASI BANK
        ============================= --}}
        @if (in_array($pengajuan->status, ['DIAJUKAN', 'DITANGGUHKAN', 'DIPROSES']))

            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

                <div class="bg-[#00A39D] px-6 py-4">
                    <h3 class="text-base font-semibold text-white flex items-center gap-2">
                        Validasi Dokumen
                    </h3>
                </div>

                <div class="p-6">

                    {{-- Status: DIAJUKAN --}}
                    @if ($pengajuan->status === 'DIAJUKAN')
                        <form method="POST" action="{{ route('bank.pengajuan.updateStatus', $pengajuan->id) }}"
                            class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    Catatan Validasi
                                </label>
                                <textarea name="catatan" rows="4"
                                    class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent resize-none"
                                    placeholder="Isi catatan jika dokumen tidak sesuai..."></textarea>
                            </div>

                            <div class="flex justify-end gap-3 pt-2">
                                <button type="submit" name="status" value="DITANGGUHKAN"
                                    class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    Tidak Sesuai
                                </button>
                                <button type="submit" name="status" value="DIPROSES"
                                    class="px-5 py-2.5 bg-[#00A39D] hover:bg-[#008C86] text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    Sesuai & Proses
                                </button>
                            </div>
                        </form>

                    {{-- Status: DIPROSES --}}
                    @elseif ($pengajuan->status === 'DIPROSES')
                        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-5">
                            <p class="text-green-700 font-semibold mb-4">Pengajuan sudah diproses oleh Bank</p>
                            <a href="{{ route('bank.downloadZip', $pengajuan->id) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-[#00A39D] hover:bg-[#008C86] text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                Unduh Semua Dokumen (ZIP)
                            </a>
                        </div>

                    {{-- Status: DITANGGUHKAN --}}
                    @elseif ($pengajuan->status === 'DITANGGUHKAN')
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-5">
                            <p class="text-sm font-semibold text-yellow-700 mb-3">Riwayat Penangguhan</p>

                            @if ($pengajuan->validasis->count())
                                @php $validasi = $pengajuan->validasis->last(); @endphp

                                <div class="space-y-2 text-sm text-gray-700">
                                    <p><span class="font-medium">Status:</span> {{ $validasi->status_validasi }}</p>
                                    <p><span class="font-medium">Catatan:</span> {{ $validasi->catatan ?? '-' }}</p>
                                    <p class="text-xs text-gray-400 pt-1">{{ $validasi->created_at }}</p>
                                </div>
                            @else
                                <p class="text-sm text-gray-500 italic">Tidak ada catatan.</p>
                            @endif
                        </div>
                    @endif

                </div>
            </div>

        @endif

        {{-- ============================
             UPLOAD SHT
        ============================= --}}
        @if ($pengajuan->status === 'DIBAYAR')

            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

                <div class="bg-[#00A39D] px-6 py-4">
                    <h3 class="text-base font-semibold text-white flex items-center gap-2">
                        Upload SHT
                    </h3>
                </div>

                <div class="p-6">
                    <form action="{{ route('bank.pengajuan.uploadSht', $pengajuan->id) }}"
                        method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Pilih File SHT (PDF / Gambar)
                            </label>
                            <input type="file" name="sht" id="file_sht"
                                accept=".pdf,.jpg,.jpeg,.png" required
                                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent">
                        </div>

                        {{-- Preview area --}}
                        <div id="previewContainer" class="hidden">
                            <iframe id="previewFrame" class="hidden w-full h-[500px] border border-gray-200 rounded-lg"></iframe>
                            <img id="previewImage" class="hidden w-full rounded-lg shadow-sm mt-2">
                        </div>

                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#00A39D] hover:bg-[#008C86] text-white text-sm font-medium rounded-lg transition-colors duration-200">

                            Upload SHT
                        </button>
                    </form>
                </div>
            </div>

        @endif

        {{-- ============================
             FILE SHT
        ============================= --}}
        @php $sht = $pengajuan->dokumen()->where('jenis_dokumen', 'SHT')->first(); @endphp

        @if (in_array($pengajuan->status, ['DIBAYAR', 'TERBIT_SHT', 'SELESAI']) && $sht)

            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

                <div class="bg-[#00A39D] px-6 py-4">
                    <h3 class="text-base font-semibold text-white flex items-center gap-2">
                        File SHT
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    @php $extension = pathinfo($sht->file_path, PATHINFO_EXTENSION); @endphp

                    @if ($extension === 'pdf')
                        <iframe src="{{  $sht->file_path }}"
                            class="w-full h-[500px] border border-gray-200 rounded-lg">
                        </iframe>

                        @if (in_array($pengajuan->status, ['TERBIT_SHT', 'SELESAI']))
                            <a href="{{ route('pengajuan.downloadSht', $pengajuan->id) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-[#00A39D] hover:bg-[#008C86] text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                Unduh SHT
                            </a>
                        @endif
                    @else
                        <img src="{{  $sht->file_path) }}"
                            class="w-full rounded-lg shadow-sm">
                    @endif
                </div>
            </div>

        @endif

    </div>

    {{-- ============================
         STYLES
    ============================= --}}
    <style>
        .file-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            background: white;
            font-size: 13px;
            font-weight: 500;
            color: #4b5563;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .file-btn:hover {
            background: #f9fafb;
            border-color: #d1d5db;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }
        .file-btn.active {
            background: #00A39D;
            color: white;
            border-color: #00A39D;
            box-shadow: 0 3px 8px rgba(0,163,157,0.3);
        }
    </style>

    {{-- ============================
         SCRIPTS
    ============================= --}}
    <script>
        function gantiFile(targetId, url, el) {
            document.getElementById(targetId).src = url;

            if (el) {
                el.closest('.flex').querySelectorAll('.file-btn')
                    .forEach(btn => btn.classList.remove('active'));
                el.classList.add('active');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('file_sht');
            if (!fileInput) return;

            fileInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;

                const previewContainer = document.getElementById('previewContainer');
                const previewFrame     = document.getElementById('previewFrame');
                const previewImage     = document.getElementById('previewImage');
                const fileURL          = URL.createObjectURL(file);

                previewContainer.classList.remove('hidden');

                if (file.type === 'application/pdf') {
                    previewFrame.src = fileURL;
                    previewFrame.classList.remove('hidden');
                    previewImage.classList.add('hidden');
                    previewFrame.onload = () => URL.revokeObjectURL(fileURL);
                } else {
                    previewImage.src = fileURL;
                    previewImage.classList.remove('hidden');
                    previewFrame.classList.add('hidden');
                }
            });
        });
    </script>

</x-app-layout>