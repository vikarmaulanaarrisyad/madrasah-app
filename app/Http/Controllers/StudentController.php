<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\Hobby;
use App\Models\LifeGoal;
use App\Models\Religion;
use App\Models\ResidenceDistance;
use App\Models\ResidenceStatus;
use App\Models\Student;
use App\Models\Time;
use App\Models\Transportation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        return view('admin.student.index');
    }

    public function data()
    {
        $query = Student::with('gender')->get();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($q) {
                return $this->renderActionButton($q);
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    private function renderActionButton($q)
    {
        return '
         <a href="' . route('students.edit', $q->id) . '" class="btn btn-sm btn-primary" title="Edit">Lihat Detail</a>';
    }

    public function create()
    {
        $genders = Gender::pluck('id', 'name');
        $religions = Religion::pluck('id', 'name');
        $hobbies = Hobby::pluck('id', 'name');
        $lifeGoals = LifeGoal::pluck('id', 'name');
        $residenceDistance = ResidenceDistance::pluck('id', 'name');
        $residenceStatus = ResidenceStatus::pluck('id', 'name');
        $times = Time::pluck('id', 'name');
        $transportations = Transportation::pluck('id', 'name');

        return view('admin.student.create', compact([
            'genders',
            'religions',
            'hobbies',
            'lifeGoals',
            'residenceDistance',
            'times',
            'transportations',
            'residenceStatus'
        ]));
    }

    public function store(Request $request)
    {
        $rules = [
            'full_name' => 'required',
            'local_nis' => 'required',
            'nisn' => 'required|min:10',
            'm_gender_id' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required|date',
            'status' => 'required',
            'kk_num' => 'required|min:16',
            'nik_siswa' => 'required|min:16',
            'siblings_num' => 'required|integer',
            'child_of_num' => 'required|integer',
            'm_religion_id' => 'required',
            'm_hobby_id' => 'required',
            'm_life_goal_id' => 'required',
            'm_residence_status_id' => 'required',
            'm_residence_distance_id' => 'required',
            'm_interval_time_id' => 'required',
            'm_transportation_id' => 'required',
            'address' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'postal_code_num' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $messages = [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'local_nis.required' => 'NIS lokal wajib diisi.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.min' => 'NISN minimal harus terdiri dari 10 karakter.',
            'm_gender_id.required' => 'Jenis kelamin wajib dipilih.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Tanggal lahir tidak valid.',
            'status.required' => 'Status wajib diisi.',
            'kk_num.required' => 'Nomor KK wajib diisi.',
            'kk_num.min' => 'Nomor KK minimal harus terdiri dari 16 karakter.',
            'nik_siswa.required' => 'NIK siswa wajib diisi.',
            'nik_siswa.min' => 'NIK siswa minimal harus terdiri dari 16 karakter.',
            'siblings_num.required' => 'Jumlah saudara wajib diisi.',
            'siblings_num.integer' => 'Jumlah saudara harus berupa angka.',
            'child_of_num.required' => 'Nomor urut anak wajib diisi.',
            'child_of_num.integer' => 'Nomor urut anak harus berupa angka.',
            'm_religion_id.required' => 'Agama wajib dipilih.',
            'm_hobby_id.required' => 'Hobi wajib dipilih.',
            'm_life_goal_id.required' => 'Tujuan hidup wajib dipilih.',
            'm_residence_status_id.required' => 'Status tempat tinggal wajib dipilih.',
            'm_residence_distance_id.required' => 'Jarak tempat tinggal wajib dipilih.',
            'm_interval_time_id.required' => 'Waktu interval wajib dipilih.',
            'm_transportation_id.required' => 'Transportasi wajib dipilih.',
            'address.required' => 'Alamat wajib diisi.',
            'rt.required' => 'RT wajib diisi.',
            'rw.required' => 'RW wajib diisi.',
            'postal_code_num.required' => 'Kode pos wajib diisi.',
            'foto.nullable' => 'Foto bersifat opsional.',
            'foto.image' => 'Foto harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Jika ada gambar yang diupload, simpan ke storage
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $this->uploadFile($request->file('foto'), 'uploads/students', $request->nisn);
            }

            // Simpan data siswa ke database
            $student = Student::create([
                'full_name' => $request->full_name,
                'local_nis' => $request->local_nis,
                'nisn' => $request->nisn,
                'm_gender_id' => $request->m_gender_id,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'status' => $request->status,
                'kk_num' => $request->kk_num,
                'nik' => $request->nik_siswa,
                'siblings_num' => $request->siblings_num,
                'child_of_num' => $request->child_of_num,
                'm_religion_id' => $request->m_religion_id,
                'm_hobby_id' => $request->m_hobby_id,
                'm_life_goal_id' => $request->m_life_goal_id,
                'm_residence_status_id' => $request->m_residence_status_id,
                'm_residence_distance_id' => $request->m_residence_distance_id,
                'm_interval_time_id' => $request->m_interval_time_id,
                'm_transportation_id' => $request->m_transportation_id,
                'address' => $request->address,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'postal_code_num' => $request->postal_code_num,
                'entered_tk_ra' => $request->entered_tk_ra ?? 0,
                'entered_paud' => $request->entered_paud ?? 0,
                'upload_photo' => $fotoPath,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data siswa berhasil disimpan!',
                'data' => $student,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $student = Student::findOrfail($id);
        $student->birth_date = Carbon::parse($student->birth_date)->format('Y-m-d');

        $genders = Gender::pluck('id', 'name');
        $religions = Religion::pluck('id', 'name');
        $hobbies = Hobby::pluck('id', 'name');
        $lifeGoals = LifeGoal::pluck('id', 'name');
        $residenceDistance = ResidenceDistance::pluck('id', 'name');
        $residenceStatus = ResidenceStatus::pluck('id', 'name');
        $times = Time::pluck('id', 'name');
        $transportations = Transportation::pluck('id', 'name');

        return view('admin.student.edit', compact([
            'student',
            'genders',
            'religions',
            'hobbies',
            'lifeGoals',
            'residenceDistance',
            'times',
            'transportations',
            'residenceStatus'
        ]));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'full_name' => 'required',
            'local_nis' => 'required',
            'nisn' => 'required|min:10',
            'm_gender_id' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required|date',
            'status' => 'required',
            'kk_num' => 'required|min:16',
            'nik_siswa' => 'required|min:16',
            'siblings_num' => 'required|integer',
            'child_of_num' => 'required|integer',
            'm_religion_id' => 'required',
            'm_hobby_id' => 'required',
            'm_life_goal_id' => 'required',
            'm_residence_status_id' => 'required',
            'm_residence_distance_id' => 'required',
            'm_interval_time_id' => 'required',
            'm_transportation_id' => 'required',
            'address' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'postal_code_num' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $messages = [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'local_nis.required' => 'NIS lokal wajib diisi.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.min' => 'NISN minimal harus terdiri dari 10 karakter.',
            'm_gender_id.required' => 'Jenis kelamin wajib dipilih.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Tanggal lahir tidak valid.',
            'status.required' => 'Status wajib diisi.',
            'kk_num.required' => 'Nomor KK wajib diisi.',
            'kk_num.min' => 'Nomor KK minimal harus terdiri dari 16 karakter.',
            'nik_siswa.required' => 'NIK siswa wajib diisi.',
            'nik_siswa.min' => 'NIK siswa minimal harus terdiri dari 16 karakter.',
            'siblings_num.required' => 'Jumlah saudara wajib diisi.',
            'siblings_num.integer' => 'Jumlah saudara harus berupa angka.',
            'child_of_num.required' => 'Nomor urut anak wajib diisi.',
            'child_of_num.integer' => 'Nomor urut anak harus berupa angka.',
            'm_religion_id.required' => 'Agama wajib dipilih.',
            'm_hobby_id.required' => 'Hobi wajib dipilih.',
            'm_life_goal_id.required' => 'Tujuan hidup wajib dipilih.',
            'm_residence_status_id.required' => 'Status tempat tinggal wajib dipilih.',
            'm_residence_distance_id.required' => 'Jarak tempat tinggal wajib dipilih.',
            'm_interval_time_id.required' => 'Waktu interval wajib dipilih.',
            'm_transportation_id.required' => 'Transportasi wajib dipilih.',
            'address.required' => 'Alamat wajib diisi.',
            'rt.required' => 'RT wajib diisi.',
            'rw.required' => 'RW wajib diisi.',
            'postal_code_num.required' => 'Kode pos wajib diisi.',
            'foto.nullable' => 'Foto bersifat opsional.',
            'foto.image' => 'Foto harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Find the existing student record by nisn
            $student = Student::where('id', $id)->first();

            if (!$student) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Siswa dengan NISN ' . $student->nisn . ' tidak ditemukan.',
                ], 404);
            }

            // If a new photo is uploaded, delete the old one and upload the new one
            $fotoPath = $student->upload_photo;
            if ($request->hasFile('foto')) {
                // Delete the old photo if exists
                if ($fotoPath) {
                    Storage::delete($fotoPath);
                }
                $fotoPath = $this->uploadFile($request->file('foto'), 'uploads/students', $request->nisn);
            }

            // Update student data in the database
            $student->update([
                'full_name' => $request->full_name,
                'local_nis' => $request->local_nis,
                'm_gender_id' => $request->m_gender_id,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'status' => $request->status,
                'kk_num' => $request->kk_num,
                'nik' => $request->nik_siswa,
                'siblings_num' => $request->siblings_num,
                'child_of_num' => $request->child_of_num,
                'm_religion_id' => $request->m_religion_id,
                'm_hobby_id' => $request->m_hobby_id,
                'm_life_goal_id' => $request->m_life_goal_id,
                'm_residence_status_id' => $request->m_residence_status_id,
                'm_residence_distance_id' => $request->m_residence_distance_id,
                'm_interval_time_id' => $request->m_interval_time_id,
                'm_transportation_id' => $request->m_transportation_id,
                'address' => $request->address,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'postal_code_num' => $request->postal_code_num,
                'entered_tk_ra' => $request->entered_tk_ra ?? 0,
                'entered_paud' => $request->entered_paud ?? 0,
                'upload_photo' => $fotoPath,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data siswa berhasil diperbarui!',
                'data' => $student,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // private function uploadFile(UploadedFile $file, string $path): string
    // {
    //     $originalName = $file->getClientOriginalName();

    //     return $file->storeAs($path, $originalName, 'public');
    // }

    private function uploadFile(UploadedFile $file, string $path, string $name): string
    {
        // Gunakan name sebagai nama file, tambahkan ekstensi file asli
        $extension = $file->getClientOriginalExtension();
        $newFileName = $name . '.' . $extension;

        // Unggah file dengan nama baru
        return $file->storeAs($path, $newFileName, 'public');
    }


    private function deleteFileIfExists(string $filePath)
    {
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
