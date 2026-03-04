<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',

        // Debitur
        'nama_debitur',
        'tanggal_lahir',
        'pekerjaan',
        'nik',
        'alamat',

        // Sertifikat
        'jenis_hak',
        'no_sertifikat',
        'pemilik_sertifikat',
        'desa',
        'kecamatan',
        'kota',
        'provinsi',

        // APHT
        'no_apht',
        'tanggal_apht',
        'peringkat_apht',
        'nominal',
        'kantor_pertanahan',

        // Status
        'status'
    ];


    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */


    // PPAT yang membuat pengajuan
    public function ppat()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    // Dokumen pengajuan
    public function dokumen()
    {
        return $this->hasMany(DokumenPengajuan::class);
    }


    // Riwayat validasi BANK
    public function validasis()
    {
        return $this->hasMany(Validasi::class, 'pengajuan_id');
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER STATUS
    |--------------------------------------------------------------------------
    */

    public function isSelesai()
    {
        return $this->status === 'SELESAI';
    }

    public function isDitangguhkan()
    {
        return $this->status === 'DITANGGUHKAN';
    }
}