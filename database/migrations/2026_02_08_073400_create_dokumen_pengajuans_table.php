<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_pengajuans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengajuan_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('uploaded_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->enum('jenis_dokumen', [
                'AKAD',
                'APHT',
                'SPA',
                'KTP',
                'SERTIFIKAT',
                'SPS',
                'BAYAR',
                'SHT',
                'LAMP13'
            ]);

            $table->string('file_path');
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('dokumen_pengajuans');
    }
};
