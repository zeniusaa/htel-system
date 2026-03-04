<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\DokumenPengajuan;
use App\Models\Validasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;

class PengajuanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ====================== PPAT SECTION ======================
    |--------------------------------------------------------------------------
    */

    // LIST PENGAJUAN
    public function index()
    {
        $pengajuans = Pengajuan::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('dashboard', compact('pengajuans'));
    }

    // FORM TAMBAH
    public function create()
    {
        return view('pengajuan.create');
    }

    // SIMPAN
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_debitur' => 'required',
            'nik' => 'required|digits:16',
            'tanggal_lahir' => 'required|date',
            'pekerjaan' => 'required',
            'alamat' => 'required',

            'jenis_hak' => 'required',
            'no_sertifikat' => 'required',
            'pemilik_sertifikat' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',

            'no_apht' => 'required',
            'tanggal_apht' => 'required|date',
            'peringkat_apht' => 'required|integer',
            'nominal' => 'required|numeric',
            'kantor_pertanahan' => 'required',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'UPLOAD';

        Pengajuan::create($validated);

        return redirect('dashboard')
            ->with('success', 'Pengajuan berhasil disimpan');
    }

    // DETAIL PPAT
    public function show($id)
    {
        $pengajuan = Pengajuan::with([
                'dokumen.uploader',
                'validasis.user'
            ])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $dokumen = $pengajuan->dokumen->keyBy('jenis_dokumen');

        return view('pengajuan.show', compact('pengajuan', 'dokumen'));
    }

    // EDIT
    public function edit($id)
    {
        $pengajuan = Pengajuan::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['UPLOAD','DITANGGUHKAN'])
            ->firstOrFail();

        return view('pengajuan.edit', compact('pengajuan'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $pengajuan = Pengajuan::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['UPLOAD','DITANGGUHKAN'])
            ->firstOrFail();

        $validated = $request->validate([
            'nama_debitur' => 'required',
            'nik' => 'required|digits:16',
            'tanggal_lahir' => 'required|date',
            'pekerjaan' => 'required',
            'alamat' => 'required',

            'jenis_hak' => 'required',
            'no_sertifikat' => 'required',
            'pemilik_sertifikat' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'kota' => 'required',
            'provinsi' => 'required',

            'no_apht' => 'required',
            'tanggal_apht' => 'required|date',
            'peringkat_apht' => 'required|integer',
            'nominal' => 'required|numeric',
            'kantor_pertanahan' => 'required',
        ]);

        $pengajuan->update($validated);

        return redirect()
            ->route('pengajuan.show', $pengajuan->id)
            ->with('success', 'Data pengajuan berhasil diperbarui');
    }

    // UPLOAD DOKUMEN
    public function uploadDokumen(Request $request, $id)
    {
        $request->validate([
            'jenis_dokumen' => 'required',
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        $path = $request->file('file')
            ->store('dokumen_pengajuan', 'public');

        DokumenPengajuan::create([
            'pengajuan_id' => $id,
            'uploaded_by' => Auth::id(),
            'jenis_dokumen' => $request->jenis_dokumen,
            'file_path' => $path,
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Dokumen berhasil diupload');
    }

    // HAPUS DOKUMEN
    public function hapusDokumen(DokumenPengajuan $dokumen)
    {
        $pengajuan = $dokumen->pengajuan;

        if (
            $pengajuan->user_id !== Auth::id() ||
            !in_array($pengajuan->status, ['UPLOAD','DITANGGUHKAN'])
        ) {
            abort(403);
        }

        Storage::disk('public')->delete($dokumen->file_path);
        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus');
    }

    // AJUKAN KE BANK
    public function ajukan($id)
    {
        $pengajuan = Pengajuan::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['UPLOAD','DITANGGUHKAN'])
            ->firstOrFail();

        $wajib = ['AKAD','APHT','SPA','KTP','SERTIFIKAT'];

        $lengkap = collect($wajib)->every(function ($j) use ($pengajuan) {
            return $pengajuan->dokumen()
                ->where('jenis_dokumen', $j)
                ->exists();
        });

        if (!$lengkap) {
            return back()->with('error', 'Dokumen belum lengkap');
        }

        $pengajuan->update(['status' => 'DIAJUKAN']);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Pengajuan berhasil diajukan');
    }

    // UPLOAD BUKTI BAYAR
    public function uploadBuktiBayar(Request $request, $id)
    {
        $pengajuan = Pengajuan::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'PERINTAH_SETOR')
            ->firstOrFail();

        $request->validate([
            'file_bayar' => 'required|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $path = $request->file('file_bayar')
            ->store('dokumen_pengajuan', 'public');

        $dokumen = $pengajuan->dokumen()
            ->where('jenis_dokumen', 'BAYAR')
            ->first();

        if ($dokumen) {
            $dokumen->update([
                'file_path' => $path,
                'uploaded_by' => Auth::id(),
            ]);
        } else {
            $pengajuan->dokumen()->create([
                'jenis_dokumen' => 'BAYAR',
                'file_path' => $path,
                'uploaded_by' => Auth::id(),
            ]);
        }

        $pengajuan->update(['status' => 'DIBAYAR']);

        return back()->with('success', 'Bukti bayar berhasil dikirim.');
    }

    // SELESAI
    public function selesai($id)
    {
        $pengajuan = Pengajuan::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'TERBIT_SHT')
            ->firstOrFail();

        $pengajuan->update(['status' => 'SELESAI']);

        return back()->with('success', 'Pengajuan telah diselesaikan.');
    }

    // HAPUS PENGAJUAN
    public function destroy($id)
    {
        $pengajuan = Pengajuan::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['UPLOAD','DITANGGUHKAN'])
            ->firstOrFail();

        foreach ($pengajuan->dokumen as $dokumen) {
            Storage::disk('public')->delete($dokumen->file_path);
            $dokumen->delete();
        }

        $pengajuan->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Pengajuan berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | ====================== BANK SECTION ======================
    |--------------------------------------------------------------------------
    */

    public function showBank(Pengajuan $pengajuan)
    {
        abort_if(Auth::user()->role !== 'BANK', 403);

        $pengajuan->load([
            'dokumen.uploader',
            'ppat',
            'validasis.user'
        ]);

        $dokumen = $pengajuan->dokumen->keyBy('jenis_dokumen');

        return view('bank.pengajuan-detail', compact('pengajuan', 'dokumen'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:DITANGGUHKAN,DIPROSES',
            'catatan' => 'nullable|string'
        ]);

        $pengajuan = Pengajuan::findOrFail($id);

        Validasi::create([
            'pengajuan_id' => $pengajuan->id,
            'user_id' => Auth::id(),
            'status_validasi' => $request->status,
            'catatan' => $request->catatan
        ]);

        $pengajuan->update(['status' => $request->status]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Validasi berhasil disimpan');
    }

    public function uploadSps(Request $request, Pengajuan $pengajuan)
    {
        abort_if(Auth::user()->role !== 'BANK', 403);

        $request->validate([
            'file_sps' => 'required|mimes:pdf|max:2048'
        ]);

        $path = $request->file('file_sps')->store('dokumen', 'public');

        $dokumen = $pengajuan->dokumen()
            ->where('jenis_dokumen', 'SPS')
            ->first();

        if ($dokumen) {
            $dokumen->update([
                'file_path' => $path,
                'uploaded_by' => Auth::id(),
            ]);
        } else {
            $pengajuan->dokumen()->create([
                'jenis_dokumen' => 'SPS',
                'file_path' => $path,
                'uploaded_by' => Auth::id(),
            ]);
        }

        $pengajuan->update(['status' => 'PERINTAH_SETOR']);

        return back()->with('success', 'SPS berhasil dikirim.');
    }

    public function uploadSht(Request $request, Pengajuan $pengajuan)
    {
        abort_if(Auth::user()->role !== 'BANK', 403);

        if ($pengajuan->status !== 'DIBAYAR') {
            abort(403);
        }

        $request->validate([
            'sht' => 'required|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $path = $request->file('sht')
            ->store('dokumen_pengajuan', 'public');

        $dokumen = $pengajuan->dokumen()
            ->where('jenis_dokumen', 'SHT')
            ->first();

        if ($dokumen) {
            $dokumen->update([
                'file_path' => $path,
                'uploaded_by' => Auth::id(),
            ]);
        } else {
            $pengajuan->dokumen()->create([
                'jenis_dokumen' => 'SHT',
                'file_path' => $path,
                'uploaded_by' => Auth::id(),
            ]);
        }

        $pengajuan->update(['status' => 'TERBIT_SHT']);

        return back()->with('success', 'SHT berhasil diterbitkan.');
    }

    public function generateLamp13(Pengajuan $pengajuan)
    {
        abort_if(Auth::user()->role !== 'BANK', 403);

        $existing = $pengajuan->dokumen()
            ->where('jenis_dokumen', 'LAMP13')
            ->first();

        if ($existing) {
            return back();
        }

        $data = [
            'pengajuan' => $pengajuan
        ];

        $pdf = Pdf::loadView('pdf.lampiran13', $data)
            ->setPaper('a4', 'portrait');

        $fileName = 'lamp13_' . $pengajuan->id . '.pdf';
        $filePath = 'dokumen_pengajuan/' . $fileName;

        Storage::disk('public')->put($filePath, $pdf->output());

        $pengajuan->dokumen()->create([
            'jenis_dokumen' => 'LAMP13',
            'file_path' => $filePath,
            'uploaded_by' => Auth::id(),
        ]);

        return back()->with('success', 'Lampiran 13 berhasil dibuat');
    }

    public function hapusLamp13(Pengajuan $pengajuan)
    {
        abort_if(Auth::user()->role !== 'BANK', 403);

        $lamp13 = $pengajuan->dokumen()
            ->where('jenis_dokumen', 'LAMP13')
            ->first();

        if (!$lamp13) {
            return back()->with('error', 'Lampiran 13 tidak ditemukan.');
        }

        if (Storage::disk('public')->exists($lamp13->file_path)) {
            Storage::disk('public')->delete($lamp13->file_path);
        }

        $lamp13->delete();

        return back()->with('success', 'Lampiran 13 berhasil dihapus.');
    }

    public function downloadZip(Pengajuan $pengajuan)
    {
        abort_if(Auth::user()->role !== 'BANK', 403);

        if ($pengajuan->status !== 'DIPROSES') {
            abort(403, 'Dokumen hanya bisa diunduh saat status DIPROSES.');
        }

        $namaNasabah = $pengajuan->nama_debitur ?? 'Nasabah';
        $namaPpat    = $pengajuan->ppat->name ?? 'PPAT';

        $namaNasabah = Str::slug($namaNasabah, '_');
        $namaPpat    = Str::slug($namaPpat, '_');

        $zipFileName = $namaNasabah . '_' . $namaPpat . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        $dokumenList = [
            'AKAD',
            'APHT',
            'KTP',
            'SPA',
            'LAMP13',
            'SERTIFIKAT'
        ];

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

            foreach ($dokumenList as $jenis) {

                $dokumen = $pengajuan->dokumen()
                    ->where('jenis_dokumen', $jenis)
                    ->first();

                if ($dokumen && Storage::disk('public')->exists($dokumen->file_path)) {

                    $filePath = storage_path('app/public/' . $dokumen->file_path);
                    $fileName = $jenis . '.' . pathinfo($filePath, PATHINFO_EXTENSION);

                    $zip->addFile($filePath, $fileName);
                }
            }

            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function downloadSht(Pengajuan $pengajuan)
    {
        if (
            Auth::user()->role !== 'BANK' &&
            $pengajuan->user_id !== Auth::id()
        ) {
            abort(403);
        }

        $sht = $pengajuan->dokumen()
            ->where('jenis_dokumen', 'SHT')
            ->firstOrFail();

        $filePath = storage_path('app/public/' . $sht->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        $namaNasabah = Str::slug($pengajuan->nama_debitur, '_');
        $fileName = 'SHT_' . $namaNasabah . '.pdf';

        return response()->download($filePath, $fileName);
    }
}