<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Data Debitur
            $table->string('nama_debitur');
            $table->date('tanggal_lahir');
            $table->string('pekerjaan');
            $table->string('nik', 16);
            $table->text('alamat');

            // Data Sertifikat
            $table->string('jenis_hak');
            $table->string('no_sertifikat');
            $table->string('desa');
            $table->string('kecamatan');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('pemilik_sertifikat');

            // Data APHT
            $table->string('no_apht');
            $table->date('tanggal_apht');
            $table->integer('peringkat_apht');
            $table->decimal('nominal', 15, 2);
            $table->string('kantor_pertanahan');

            // Status
            $table->enum('status', [
                'UPLOAD',
                'DIAJUKAN',
                'DIPROSES',
                'DITANGGUHKAN',
                'PERINTAH_SETOR',
                'DIBAYAR',
                'TERBIT_SHT',
                'SELESAI'
            ])->default('UPLOAD');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
