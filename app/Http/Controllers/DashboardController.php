<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        return match ($user->role) {
            'PPAT' => $this->dashboardPpat($request, $user),
            'BANK' => $this->dashboardBank($request),
            default => abort(403),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD PPAT
    |--------------------------------------------------------------------------
    */
private function dashboardPpat(Request $request, $user)
{
    $query = Pengajuan::where('user_id', $user->id)
        ->where('status', '!=', 'SELESAI');

    if ($request->filled('search')) {
        $query->where('nama_debitur', 'like', "%{$request->search}%");
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $pengajuans = $query
        ->orderByRaw("CASE status
            WHEN 'UPLOAD'          THEN 1
            WHEN 'DIAJUKAN'        THEN 2
            WHEN 'DIPROSES'        THEN 3
            WHEN 'DITANGGUHKAN'    THEN 4
            WHEN 'PERINTAH_SETOR'  THEN 5
            WHEN 'DIBAYAR'         THEN 6
            WHEN 'TERBIT_SHT'      THEN 7
            ELSE 8 END")
        ->latest()
        ->get();

    $statistik = $this->generateStatistikPPAT($user->id);

    return view('dashboard.ppat', compact('pengajuans', 'statistik'));
}

    private function generateStatistikPPAT($userId)
{
    $counts = Pengajuan::where('user_id', $userId)
        ->selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

    $statusList = [
        'UPLOAD', 'DIAJUKAN', 'DIPROSES', 'DITANGGUHKAN',
        'PERINTAH_SETOR', 'DIBAYAR', 'TERBIT_SHT'
    ];

    return collect($statusList)
        ->mapWithKeys(fn($s) => [$s => $counts->get($s, 0)])
        ->all();
}

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD BANK
    |--------------------------------------------------------------------------
    */
    private function dashboardBank(Request $request)
{
    $query = Pengajuan::with('ppat')
        ->whereNotIn('status', ['UPLOAD', 'SELESAI']);

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('nama_debitur', 'like', "%$search%")
              ->orWhereHas('ppat', function ($ppat) use ($search) {
                  $ppat->where('name', 'like', "%$search%");
              });
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $pengajuans = $query
        ->orderByRaw("CASE status
            WHEN 'DIAJUKAN'        THEN 1
            WHEN 'DIPROSES'        THEN 2
            WHEN 'DITANGGUHKAN'    THEN 3
            WHEN 'PERINTAH_SETOR'  THEN 4
            WHEN 'DIBAYAR'         THEN 5
            WHEN 'TERBIT_SHT'      THEN 6
            ELSE 7 END")
        ->latest()
        ->get();

    $statistik = $this->generateStatistikBank();

    return view('dashboard.bank', compact('pengajuans', 'statistik'));
}

// SESUDAH
private function generateStatistikBank()
{
    $counts = Pengajuan::whereNotIn('status', ['UPLOAD', 'SELESAI'])
        ->selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

    $statusList = [
        'DIAJUKAN', 'DIPROSES', 'DITANGGUHKAN',
        'PERINTAH_SETOR', 'DIBAYAR', 'TERBIT_SHT'
    ];

    return collect($statusList)
        ->mapWithKeys(fn($s) => [$s => $counts->get($s, 0)])
        ->all();
}
    /*
    |--------------------------------------------------------------------------
    | ARSIP SELESAI
    |--------------------------------------------------------------------------
    */
    // SESUDAH
public function arsipSelesai(Request $request)
{
    $user = Auth::user();

    // Query untuk hitung total (tidak terpengaruh filter search)
    $countQuery = Pengajuan::where('status', 'SELESAI');
    if ($user->role === 'PPAT') {
        $countQuery->where('user_id', $user->id);
    }
    $totalSelesai = $countQuery->count();

    // Query untuk data tampil (dengan filter search)
    $query = Pengajuan::with('ppat')->where('status', 'SELESAI');

    if ($user->role === 'PPAT') {
        $query->where('user_id', $user->id);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('nama_debitur', 'like', "%$search%")
              ->orWhere('no_sertifikat', 'like', "%$search%")
              ->orWhereHas('ppat', function ($ppat) use ($search) {
                  $ppat->where('name', 'like', "%$search%");
              });
        });
    }

    $pengajuans = $query->latest()->get();

    $statistik = [
        'SELESAI' => $totalSelesai,
    ];

    return view('dashboard.arsip', compact('pengajuans', 'statistik'));
}
}
