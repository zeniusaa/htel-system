<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-[#00A39D] flex items-center justify-center">
            </div>
            <h2 class="font-semibold text-xl text-white">
                Buat Pengajuan Hak Tanggungan
            </h2>
        </div>
    </x-slot>

    <x-slot name="actions">
        <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('dashboard') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm rounded-lg transition-colors duration-200">
            Kembali
        </a>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Error --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl">
                <p class="font-semibold text-sm mb-2">Terdapat kesalahan pada input:</p>
                <ul class="list-disc pl-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('pengajuan.store') }}" class="space-y-6">
            @csrf

            {{-- ============================
                 DATA DEBITUR
            ============================= --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

                <div class="bg-[#00A39D] px-6 py-4">
                    <h3 class="text-base font-semibold text-white flex items-center gap-2">
                        Data Debitur
                    </h3>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Nama Debitur</label>
                        <input name="nama_debitur" value="{{ old('nama_debitur') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">NIK</label>
                        <input name="nik" value="{{ old('nik') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Pekerjaan</label>
                        <input name="pekerjaan" value="{{ old('pekerjaan') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Alamat</label>
                        <textarea name="alamat" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent resize-none" required>{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ============================
                 DATA SERTIFIKAT
            ============================= --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

                <div class="bg-[#00A39D] px-6 py-4">
                    <h3 class="text-base font-semibold text-white flex items-center gap-2">
                        Data Sertifikat
                    </h3>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Jenis Hak</label>
                        <select name="jenis_hak"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                            <option value="SHM" {{ old('jenis_hak') === 'SHM' ? 'selected' : '' }}>
                                SHM (Sertifikat Hak Milik)
                            </option>
                            <option value="SHGB" {{ old('jenis_hak') === 'SHGB' ? 'selected' : '' }}>
                                SHGB (Sertifikat Hak Guna Bangunan)
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">No Sertifikat</label>
                        <input name="no_sertifikat" value="{{ old('no_sertifikat') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                        <p class="text-xs text-gray-400 italic mt-1">* Jika No NIB, tulis dengan NIBnya</p>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Pemilik Sertifikat</label>
                        <input name="pemilik_sertifikat" value="{{ old('pemilik_sertifikat') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Kantor Pertanahan</label>
                        <input name="kantor_pertanahan" value="{{ old('kantor_pertanahan') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                        <p class="text-xs text-gray-400 italic mt-1">* Dapat dilihat pada dokumen SPA</p>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Desa</label>
                        <input name="desa" value="{{ old('desa') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Kecamatan</label>
                        <input name="kecamatan" value="{{ old('kecamatan') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Kota / Kabupaten</label>
                        <input name="kota" value="{{ old('kota') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Provinsi</label>
                        <input name="provinsi" value="{{ old('provinsi') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                    </div>
                </div>
            </div>

            {{-- ============================
                 DATA APHT
            ============================= --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">

                <div class="bg-[#00A39D] px-6 py-4">
                    <h3 class="text-base font-semibold text-white flex items-center gap-2">
                        Data APHT
                    </h3>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">No APHT</label>
                        <input name="no_apht" value="{{ old('no_apht') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal APHT</label>
                        <input type="date" name="tanggal_apht" value="{{ old('tanggal_apht') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Peringkat</label>
                        <input name="peringkat_apht" value="{{ old('peringkat_apht') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Nominal</label>
                        <input type="text" id="nominal_display"
                            value="{{ old('nominal') ? 'Rp ' . number_format(old('nominal'), 0, ',', '.') : '' }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#00A39D] focus:border-transparent"
                            placeholder="Rp 0" autocomplete="off" required>
                        <input type="hidden" name="nominal" id="nominal" value="{{ old('nominal') }}">
                    </div>
                </div>
            </div>

            {{-- ============================
                 AKSI
            ============================= --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('dashboard') }}"
                    class="px-5 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#00A39D] hover:bg-[#008C86] text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    Simpan Pengajuan
                </button>
            </div>

        </form>
    </div>

    <script>
        const display = document.getElementById('nominal_display');
        const hidden  = document.getElementById('nominal');

        display.addEventListener('input', function () {
            let value = this.value.replace(/[^0-9]/g, '');
            hidden.value = value;
            this.value = value ? 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
        });
    </script>

</x-app-layout>