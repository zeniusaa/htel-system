<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        if (auth()->user()->role != 'BANK') {
            abort(403);
        }

        // PPAT tampil dulu baru BANK
        $users = User::orderByRaw("FIELD(role, 'PPAT', 'BANK')")
                    ->latest()
                    ->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status_ppat' => $request->role == 'PPAT' ? 'AKTIF' : null
        ]);

        return redirect()->route('users.index')
            ->with('success','User berhasil dibuat');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->role == 'PPAT') {

            $user->status_ppat = $user->status_ppat == 'AKTIF'
                ? 'NONAKTIF'
                : 'AKTIF';

            $user->save();
        }

        return back();
    }
}