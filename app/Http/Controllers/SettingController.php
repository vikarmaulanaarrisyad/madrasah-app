<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting.aplikasi', compact('setting'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'application_name' => 'required|string|max:255',
            'favicon' => 'nullable|image|mimes:png,jpg,jpeg,ico|max:2048',
            'logo_login' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Ambil data setting yang ada
        $setting = Setting::first();

        // Handle Favicon
        if ($request->hasFile('favicon')) {
            // Hapus favicon lama jika ada dan bukan default
            if ($setting && $setting->favicon && $setting->favicon !== 'favicon.png') {
                Storage::disk('public')->delete($setting->favicon);
            }
            // Simpan favicon baru
            $favicon = $request->file('favicon')->store('uploads', 'public');
        } else {
            $favicon = $setting->favicon ?? 'favicon.png';
        }

        // Handle Logo Login
        if ($request->hasFile('logo_login')) {
            // Hapus logo lama jika ada dan bukan default
            if ($setting && $setting->logo_login && $setting->logo_login !== 'logo_login.png') {
                Storage::disk('public')->delete($setting->logo_login);
            }
            // Simpan logo baru
            $logo_login = $request->file('logo_login')->store('uploads', 'public');
        } else {
            $logo_login = $setting->logo_login ?? 'logo_login.png';
        }

        // Simpan atau update pengaturan
        Setting::updateOrCreate([], [
            'application_name' => $request->application_name,
            'favicon' => $favicon,
            'logo_login' => $logo_login,
        ]);

        return response()->json(['message' => 'Pengaturan berhasil disimpan!']);
    }
}
