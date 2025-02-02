<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login, ambil user yang sedang login
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            return view('admin.dashboard.index');
        } else if ($user->hasRole('Kepala')) {
            return view('kepalamadrasah.dashboard.index');
        } else {
            return view('guru.dashboard.index');
        }
    }
}
