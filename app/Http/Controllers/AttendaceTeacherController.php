<?php

namespace App\Http\Controllers;

use App\Models\AttendaceTeacher;
use App\Models\Teacher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class AttendaceTeacherController extends Controller
{
    public function create()
    {
        $userId = Auth::id();
        $teacher = Teacher::where('user_id', $userId)->first();
        // Ambil waktu sekarang
        $tglPresensi = date('Y-m-d');

        // Cek apakah user sudah absen masuk hari ini
        $absenHariIni = AttendaceTeacher::where('teacher_id', $teacher->id)
            ->where('tgl_presensi', $tglPresensi)
            ->count();
        return view('teacher.attendace.index', compact('absenHariIni'));
    }

    public function store(Request $request)
    {
        // Pastikan ada file yang dikirim
        if (!$request->hasFile('foto')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada file yang diunggah'
            ], 400);
        }

        // Ambil ID user yang login
        $userId = Auth::id();
        $teacher = Teacher::where('user_id', $userId)->first();

        if (!$teacher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data guru tidak ditemukan'
            ], 404);
        }

        // Ambil waktu sekarang
        $tglPresensi = date('Y-m-d');
        $jam = date('H:i:s');

        // Cek apakah user sudah absen masuk hari ini
        $absenHariIni = AttendaceTeacher::where('teacher_id', $teacher->id)
            ->where('tgl_presensi', $tglPresensi)
            ->first();

        if ($absenHariIni) {
            $ket = 'out';
        } else {
            $ket = 'in';
        }

        // Dapatkan nama asli file
        $originalName = $ket . '_' . $request->file('foto')->getClientOriginalName();

        // Simpan file baru
        $fotoPath = $this->uploadFile($request->file('foto'), 'uploads/teacher/absensi', $originalName);

        if ($absenHariIni) {
            // Jika user sudah absen masuk, update jam_out dan foto_out
            $absenHariIni->update([
                'jam_out' => $jam,
                'foto_out' => $fotoPath
            ]);
            $message = 'Presensi keluar berhasil disimpan';
        } else {
            // Jika user belum absen, simpan sebagai jam_in dan foto_in
            AttendaceTeacher::create([
                'teacher_id' => $teacher->id,
                'foto_in' => $fotoPath,
                'jam_in' => $jam,
                'tgl_presensi' => $tglPresensi
            ]);
            $message = 'Presensi masuk berhasil disimpan';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'file_path' => $fotoPath
        ]);
    }

    /**
     * Fungsi untuk mengunggah file dengan nama yang telah ditentukan
     */
    private function uploadFile(UploadedFile $file, string $path, string $name): string
    {
        // Gunakan nama yang ditentukan dengan ekstensi file asli
        $extension = $file->getClientOriginalExtension();
        $newFileName = $name . '.' . $extension;

        // Simpan file dan kembalikan path yang tersimpan
        return $file->storeAs($path, $newFileName, 'public');
    }
}
