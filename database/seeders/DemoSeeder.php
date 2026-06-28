<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pengajuan;
use App\Models\DokumenPengajuan;
use App\Models\Validasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================================
        // USERS
        // ============================================================

        $bank = User::create([
            'name'        => 'Bank Demo',
            'email'       => 'bank@mail.com',
            'password'    => Hash::make('password'),
            'role'        => 'BANK',
            'status_ppat' => null,
        ]);

        $ppat1 = User::create([
            'name'        => 'Andi Kusuma',
            'email'       => 'andi@mail.com',
            'password'    => Hash::make('password'),
            'role'        => 'PPAT',
            'status_ppat' => 'AKTIF',
        ]);

        $ppat2 = User::create([
            'name'        => 'Sari Dewi',
            'email'       => 'sari@mail.com',
            'password'    => Hash::make('password'),
            'role'        => 'PPAT',
            'status_ppat' => 'AKTIF',
        ]);

        $ppat3 = User::create([
            'name'        => 'Rizky Pratama',
            'email'       => 'rizky@mail.com',
            'password'    => Hash::make('password'),
            'role'        => 'PPAT',
            'status_ppat' => 'AKTIF',
        ]);

        // ============================================================
        // PENGAJUAN PPAT 1 — Andi Kusuma
        // ============================================================

        // Pengajuan 1 — Budi Santoso | Status: DIPROSES
        $p1 = Pengajuan::create([
            'user_id'           => $ppat1->id,
            'nama_debitur'      => 'Budi Santoso',
            'nik'               => '3273011504850001',
            'tanggal_lahir'     => '1985-04-15',
            'pekerjaan'         => 'Wiraswasta',
            'alamat'            => 'Jl. Merdeka No. 12, Kel. Merdeka, Kota Bandung',
            'jenis_hak'         => 'Hak Milik',
            'no_sertifikat'     => '1234/Sukajadi',
            'pemilik_sertifikat'=> 'Budi Santoso',
            'desa'              => 'Sukajadi',
            'kecamatan'         => 'Sukajadi',
            'kota'              => 'Bandung',
            'provinsi'          => 'Jawa Barat',
            'no_apht'           => '01/APHT/2026',
            'tanggal_apht'      => '2026-01-10',
            'peringkat_apht'    => 1,
            'nominal'           => 500000000,
            'kantor_pertanahan' => 'BPN Kota Bandung',
            'status'            => 'DIPROSES',
        ]);
        $this->uploadDokumen($p1, $ppat1->id, ['KTP','AKAD','APHT','SPA','SERTIFIKAT'], 'p1');
        Validasi::create([
            'pengajuan_id'   => $p1->id,
            'user_id'        => $bank->id,
            'status_validasi'=> 'DIPROSES',
            'catatan'        => 'Dokumen lengkap, pengajuan sedang diproses.',
        ]);

        // Pengajuan 2 — Dewi Rahayu | Status: DIAJUKAN
        $p2 = Pengajuan::create([
            'user_id'           => $ppat1->id,
            'nama_debitur'      => 'Dewi Rahayu',
            'nik'               => '3273024507900002',
            'tanggal_lahir'     => '1990-07-05',
            'pekerjaan'         => 'Pegawai Negeri Sipil',
            'alamat'            => 'Jl. Sudirman No. 45, Kel. Antapani, Kota Bandung',
            'jenis_hak'         => 'Hak Milik',
            'no_sertifikat'     => '5678/Antapani',
            'pemilik_sertifikat'=> 'Dewi Rahayu',
            'desa'              => 'Antapani',
            'kecamatan'         => 'Antapani',
            'kota'              => 'Bandung',
            'provinsi'          => 'Jawa Barat',
            'no_apht'           => '02/APHT/2026',
            'tanggal_apht'      => '2026-02-15',
            'peringkat_apht'    => 1,
            'nominal'           => 300000000,
            'kantor_pertanahan' => 'BPN Kota Bandung',
            'status'            => 'DIAJUKAN',
        ]);
        $this->uploadDokumen($p2, $ppat1->id, ['KTP','AKAD','APHT','SPA','SERTIFIKAT'], 'p2');

        // Pengajuan 3 — Rudi Hartono | Status: UPLOAD (draft)
        $p3 = Pengajuan::create([
            'user_id'           => $ppat1->id,
            'nama_debitur'      => 'Rudi Hartono',
            'nik'               => '3273031208750003',
            'tanggal_lahir'     => '1975-08-12',
            'pekerjaan'         => 'Dokter',
            'alamat'            => 'Jl. Diponegoro No. 8, Kel. Coblong, Kota Bandung',
            'jenis_hak'         => 'Hak Guna Bangunan',
            'no_sertifikat'     => '9012/Coblong',
            'pemilik_sertifikat'=> 'Rudi Hartono',
            'desa'              => 'Coblong',
            'kecamatan'         => 'Coblong',
            'kota'              => 'Bandung',
            'provinsi'          => 'Jawa Barat',
            'no_apht'           => '03/APHT/2026',
            'tanggal_apht'      => '2026-03-20',
            'peringkat_apht'    => 1,
            'nominal'           => 750000000,
            'kantor_pertanahan' => 'BPN Kota Bandung',
            'status'            => 'UPLOAD',
        ]);
        $this->uploadDokumen($p3, $ppat1->id, ['KTP','AKAD'], 'p3');

        // ============================================================
        // PENGAJUAN PPAT 2 — Sari Dewi
        // ============================================================

        // Pengajuan 4 — Hendra Gunawan | Status: PERINTAH_SETOR
        $p4 = Pengajuan::create([
            'user_id'           => $ppat2->id,
            'nama_debitur'      => 'Hendra Gunawan',
            'nik'               => '3578010203800004',
            'tanggal_lahir'     => '1980-03-02',
            'pekerjaan'         => 'Pengusaha',
            'alamat'            => 'Jl. Ahmad Yani No. 100, Wonokromo, Surabaya',
            'jenis_hak'         => 'Hak Milik',
            'no_sertifikat'     => '3456/Wonokromo',
            'pemilik_sertifikat'=> 'Hendra Gunawan',
            'desa'              => 'Wonokromo',
            'kecamatan'         => 'Wonokromo',
            'kota'              => 'Surabaya',
            'provinsi'          => 'Jawa Timur',
            'no_apht'           => '04/APHT/2026',
            'tanggal_apht'      => '2026-01-05',
            'peringkat_apht'    => 1,
            'nominal'           => 1200000000,
            'kantor_pertanahan' => 'BPN Kota Surabaya',
            'status'            => 'PERINTAH_SETOR',
        ]);
        $this->uploadDokumen($p4, $ppat2->id, ['KTP','AKAD','APHT','SPA','SERTIFIKAT'], 'p4');
        $this->uploadDokumen($p4, $bank->id, ['SPS'], 'p4');
        Validasi::create([
            'pengajuan_id'   => $p4->id,
            'user_id'        => $bank->id,
            'status_validasi'=> 'DIPROSES',
            'catatan'        => 'Dokumen disetujui. Silakan lakukan pembayaran.',
        ]);

        // Pengajuan 5 — Lina Marlina | Status: DITANGGUHKAN
        $p5 = Pengajuan::create([
            'user_id'           => $ppat2->id,
            'nama_debitur'      => 'Lina Marlina',
            'nik'               => '3578024508850005',
            'tanggal_lahir'     => '1985-08-05',
            'pekerjaan'         => 'Karyawan Swasta',
            'alamat'            => 'Jl. Raya Darmo No. 22, Tegalsari, Surabaya',
            'jenis_hak'         => 'Hak Milik',
            'no_sertifikat'     => '7890/Tegalsari',
            'pemilik_sertifikat'=> 'Lina Marlina',
            'desa'              => 'Tegalsari',
            'kecamatan'         => 'Tegalsari',
            'kota'              => 'Surabaya',
            'provinsi'          => 'Jawa Timur',
            'no_apht'           => '05/APHT/2026',
            'tanggal_apht'      => '2026-02-10',
            'peringkat_apht'    => 2,
            'nominal'           => 450000000,
            'kantor_pertanahan' => 'BPN Kota Surabaya',
            'status'            => 'DITANGGUHKAN',
        ]);
        $this->uploadDokumen($p5, $ppat2->id, ['KTP','AKAD','APHT','SPA','SERTIFIKAT'], 'p5');
        Validasi::create([
            'pengajuan_id'   => $p5->id,
            'user_id'        => $bank->id,
            'status_validasi'=> 'DITANGGUHKAN',
            'catatan'        => 'Dokumen APHT perlu diperbaiki. Mohon unggah ulang.',
        ]);

        // Pengajuan 6 — Agus Setiawan | Status: SELESAI
        $p6 = Pengajuan::create([
            'user_id'           => $ppat2->id,
            'nama_debitur'      => 'Agus Setiawan',
            'nik'               => '3578031509700006',
            'tanggal_lahir'     => '1970-09-15',
            'pekerjaan'         => 'TNI',
            'alamat'            => 'Jl. Basuki Rahmat No. 5, Gubeng, Surabaya',
            'jenis_hak'         => 'Hak Milik',
            'no_sertifikat'     => '2345/Gubeng',
            'pemilik_sertifikat'=> 'Agus Setiawan',
            'desa'              => 'Gubeng',
            'kecamatan'         => 'Gubeng',
            'kota'              => 'Surabaya',
            'provinsi'          => 'Jawa Timur',
            'no_apht'           => '10/APHT/2025',
            'tanggal_apht'      => '2025-11-01',
            'peringkat_apht'    => 1,
            'nominal'           => 600000000,
            'kantor_pertanahan' => 'BPN Kota Surabaya',
            'status'            => 'SELESAI',
        ]);
        $this->uploadDokumen($p6, $ppat2->id, ['KTP','AKAD','APHT','SPA','SERTIFIKAT'], 'p6');
        $this->uploadDokumen($p6, $bank->id,  ['SPS','LAMP13'], 'p6');
        $this->uploadDokumen($p6, $ppat2->id, ['BAYAR'], 'p6');
        $this->uploadDokumen($p6, $bank->id,  ['SHT'], 'p6');
        Validasi::create([
            'pengajuan_id'   => $p6->id,
            'user_id'        => $bank->id,
            'status_validasi'=> 'DIPROSES',
            'catatan'        => 'Dokumen lengkap dan valid.',
        ]);

        // ============================================================
        // PENGAJUAN PPAT 3 — Rizky Pratama
        // ============================================================

        // Pengajuan 7 — Mega Wati | Status: DIBAYAR
        $p7 = Pengajuan::create([
            'user_id'           => $ppat3->id,
            'nama_debitur'      => 'Mega Wati',
            'nik'               => '3171010607920007',
            'tanggal_lahir'     => '1992-07-06',
            'pekerjaan'         => 'Notaris',
            'alamat'            => 'Jl. Thamrin No. 77, Menteng, Jakarta Pusat',
            'jenis_hak'         => 'Hak Milik',
            'no_sertifikat'     => '5555/Menteng',
            'pemilik_sertifikat'=> 'Mega Wati',
            'desa'              => 'Menteng',
            'kecamatan'         => 'Menteng',
            'kota'              => 'Jakarta Pusat',
            'provinsi'          => 'DKI Jakarta',
            'no_apht'           => '07/APHT/2026',
            'tanggal_apht'      => '2026-02-05',
            'peringkat_apht'    => 1,
            'nominal'           => 2000000000,
            'kantor_pertanahan' => 'BPN Jakarta Pusat',
            'status'            => 'DIBAYAR',
        ]);
        $this->uploadDokumen($p7, $ppat3->id, ['KTP','AKAD','APHT','SPA','SERTIFIKAT'], 'p7');
        $this->uploadDokumen($p7, $bank->id,  ['SPS'], 'p7');
        $this->uploadDokumen($p7, $ppat3->id, ['BAYAR'], 'p7');
        Validasi::create([
            'pengajuan_id'   => $p7->id,
            'user_id'        => $bank->id,
            'status_validasi'=> 'DIPROSES',
            'catatan'        => 'Dokumen disetujui.',
        ]);

        // Pengajuan 8 — Eko Prasetyo | Status: TERBIT_SHT
        $p8 = Pengajuan::create([
            'user_id'           => $ppat3->id,
            'nama_debitur'      => 'Eko Prasetyo',
            'nik'               => '3171021108880008',
            'tanggal_lahir'     => '1988-11-08',
            'pekerjaan'         => 'Arsitek',
            'alamat'            => 'Jl. Sudirman No. 200, Kebayoran, Jakarta Selatan',
            'jenis_hak'         => 'Hak Guna Bangunan',
            'no_sertifikat'     => '6666/Kebayoran',
            'pemilik_sertifikat'=> 'Eko Prasetyo',
            'desa'              => 'Kebayoran Baru',
            'kecamatan'         => 'Kebayoran Baru',
            'kota'              => 'Jakarta Selatan',
            'provinsi'          => 'DKI Jakarta',
            'no_apht'           => '08/APHT/2026',
            'tanggal_apht'      => '2026-02-10',
            'peringkat_apht'    => 1,
            'nominal'           => 850000000,
            'kantor_pertanahan' => 'BPN Jakarta Selatan',
            'status'            => 'TERBIT_SHT',
        ]);
        $this->uploadDokumen($p8, $ppat3->id, ['KTP','AKAD','APHT','SPA','SERTIFIKAT'], 'p8');
        $this->uploadDokumen($p8, $bank->id,  ['SPS'], 'p8');
        $this->uploadDokumen($p8, $ppat3->id, ['BAYAR'], 'p8');
        $this->uploadDokumen($p8, $bank->id,  ['SHT'], 'p8');
        Validasi::create([
            'pengajuan_id'   => $p8->id,
            'user_id'        => $bank->id,
            'status_validasi'=> 'DIPROSES',
            'catatan'        => 'Semua dokumen valid. SHT diterbitkan.',
        ]);

        // Pengajuan 9 — Fitri Handayani | Status: DIAJUKAN
        $p9 = Pengajuan::create([
            'user_id'           => $ppat3->id,
            'nama_debitur'      => 'Fitri Handayani',
            'nik'               => '3171030209950009',
            'tanggal_lahir'     => '1995-09-02',
            'pekerjaan'         => 'Dosen',
            'alamat'            => 'Jl. Kebon Sirih No. 15, Cikini, Jakarta Pusat',
            'jenis_hak'         => 'Hak Milik',
            'no_sertifikat'     => '7777/Cikini',
            'pemilik_sertifikat'=> 'Fitri Handayani',
            'desa'              => 'Cikini',
            'kecamatan'         => 'Menteng',
            'kota'              => 'Jakarta Pusat',
            'provinsi'          => 'DKI Jakarta',
            'no_apht'           => '09/APHT/2026',
            'tanggal_apht'      => '2026-03-01',
            'peringkat_apht'    => 1,
            'nominal'           => 400000000,
            'kantor_pertanahan' => 'BPN Jakarta Pusat',
            'status'            => 'DIAJUKAN',
        ]);
        $this->uploadDokumen($p9, $ppat3->id, ['KTP','AKAD','APHT','SPA','SERTIFIKAT'], 'p9');
    }

    // ============================================================
    // HELPER: Salin PDF dummy ke storage Laravel & simpan ke DB
    // ============================================================
    private function uploadDokumen(Pengajuan $pengajuan, int $userId, array $jenisList, string $prefix): void
    {
        foreach ($jenisList as $jenis) {
            $sumber = database_path("seeders/pdf_dummy/{$prefix}_{$jenis}.pdf");

            if (!file_exists($sumber)) {
                continue;
            }

            $tujuan = "dokumen_pengajuan/{$prefix}_{$jenis}_" . $pengajuan->id . ".pdf";

            Storage::disk('public')->put(
                $tujuan,
                file_get_contents($sumber)
            );

            DokumenPengajuan::create([
                'pengajuan_id' => $pengajuan->id,
                'uploaded_by'  => $userId,
                'jenis_dokumen'=> $jenis,
                'file_path'    => $tujuan,
                'keterangan'   => null,
            ]);
        }
    }
}
