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

        // Search
        if ($request->filled('search')) {
            $query->where('nama_debitur', 'like', "%{$request->search}%");
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuans = $query->latest()->get();

        $statistik = $this->generateStatistikPPAT($user->id);

        return view('dashboard.ppat', compact('pengajuans', 'statistik'));
    }

    private function generateStatistikPPAT($userId)
    {
        $data = Pengajuan::where('user_id', $userId)->get();

        return [
            'UPLOAD' => $data->where('status', 'UPLOAD')->count(),
            'DIAJUKAN' => $data->where('status', 'DIAJUKAN')->count(),
            'DIPROSES' => $data->where('status', 'DIPROSES')->count(),
            'DITANGGUHKAN' => $data->where('status', 'DITANGGUHKAN')->count(),
            'PERINTAH_SETOR' => $data->where('status', 'PERINTAH_SETOR')->count(),
            'DIBAYAR' => $data->where('status', 'DIBAYAR')->count(),
            'TERBIT_SHT' => $data->where('status', 'TERBIT_SHT')->count(),
        ];
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
            ->orderByRaw("CASE WHEN status = 'DIAJUKAN' THEN 1 ELSE 2 END")
            ->latest()
            ->get();

        $statistik = $this->generateStatistikBank();

        return view('dashboard.bank', compact('pengajuans', 'statistik'));
    }

    private function generateStatistikBank()
    {
        $data = Pengajuan::where('status', '!=', 'UPLOAD')->get();

        return [
            'DIAJUKAN' => $data->where('status', 'DIAJUKAN')->count(),
            'DIPROSES' => $data->where('status', 'DIPROSES')->count(),
            'DITANGGUHKAN' => $data->where('status', 'DITANGGUHKAN')->count(),
            'PERINTAH_SETOR' => $data->where('status', 'PERINTAH_SETOR')->count(),
            'DIBAYAR' => $data->where('status', 'DIBAYAR')->count(),
            'TERBIT_SHT' => $data->where('status', 'TERBIT_SHT')->count(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | ARSIP SELESAI
    |--------------------------------------------------------------------------
    */
    public function arsipSelesai(Request $request)
    {
        $user = Auth::user();

        $query = Pengajuan::with('ppat')
            ->where('status', 'SELESAI');

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
            'SELESAI' => $query->count(),
        ];

        return view('dashboard.arsip', compact('pengajuans', 'statistik'));
    }
}