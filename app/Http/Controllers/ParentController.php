<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ParentController extends Controller
{
    public function store1(Request $request)
    {
        $rules = [
            'student_id'         => 'required|exists:students,id',
            'father_full_name'   => 'required|string|max:255',
            'father_nik'         => 'required|numeric|digits:16',
            'father_birth_place' => 'required|string|max:255',
            'father_birth_date'  => 'required|date',
            'father_m_job_id'    => 'nullable|integer',
            'father_phone_number' => 'nullable|string|max:15',
            'father_address'     => 'nullable|string',
            'father_kk_file'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

            'mother_full_name'   => 'required|string|max:255',
            'mother_nik'         => 'required|numeric|digits:16',
            'mother_birth_place' => 'required|string|max:255',
            'mother_birth_date'  => 'required|date',
            'mother_phone_number' => 'nullable|string|max:15',
            'mother_address'     => 'nullable|string',
            'mother_kk_file'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

            'wali_full_name'     => 'required|string|max:255',
            'wali_nik'           => 'required|numeric|digits:16',
            'wali_birth_place'   => 'required|string|max:255',
            'wali_birth_date'    => 'required|date',
            'wali_phone_number'  => 'nullable|string|max:15',
            'wali_address'       => 'nullable|string',
            'wali_kk_file'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        $messages = [
            'required' => ':attribute wajib diisi.',
            'string'   => ':attribute harus berupa teks.',
            'max'      => ':attribute tidak boleh lebih dari :max karakter.',
            'numeric'  => ':attribute harus berupa angka.',
            'digits'   => ':attribute harus :digits digit.',
            'date'     => ':attribute harus berupa tanggal yang valid.',
            'integer'  => ':attribute harus berupa angka.',
            'file'     => ':attribute harus berupa file.',
            'mimes'    => ':attribute harus berformat: :values.',
            'exists'   => ':attribute tidak valid.',
        ];

        $attributes = [
            'student_id'         => 'ID Siswa',
            'father_full_name'   => 'Nama Lengkap Ayah',
            'father_nik'         => 'NIK Ayah',
            'father_birth_place' => 'Tempat Lahir Ayah',
            'father_birth_date'  => 'Tanggal Lahir Ayah',
            'father_m_job_id'    => 'ID Pekerjaan Ayah',
            'father_phone_number' => 'Nomor Telepon Ayah',
            'father_address'     => 'Alamat Ayah',
            'father_kk_file'     => 'File KK Ayah',

            'mother_full_name'   => 'Nama Lengkap Ibu',
            'mother_nik'         => 'NIK Ibu',
            'mother_birth_place' => 'Tempat Lahir Ibu',
            'mother_birth_date'  => 'Tanggal Lahir Ibu',
            'mother_phone_number' => 'Nomor Telepon Ibu',
            'mother_address'     => 'Alamat Ibu',
            'mother_kk_file'     => 'File KK Ibu',

            'wali_full_name'     => 'Nama Lengkap Wali',
            'wali_nik'           => 'NIK Wali',
            'wali_birth_place'   => 'Tempat Lahir Wali',
            'wali_birth_date'    => 'Tanggal Lahir Wali',
            'wali_phone_number'  => 'Nomor Telepon Wali',
            'wali_address'       => 'Alamat Wali',
            'wali_kk_file'       => 'File KK Wali',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        DB::beginTransaction();

        try {
            $student = Student::where('id', $request->student_id)->first(); // Perbaikan dari fist() ke first()

            if (!$student) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Siswa tidak ditemukan.',
                ], 404);
            }

            // Proses upload file
            $father_kk_file = $request->hasFile('father_kk_file')
                ? $this->uploadFile($request->file('father_kk_file'), 'uploads/parents', $student->nisn)
                : null;

            $mother_kk_file = $request->hasFile('mother_kk_file')
                ? $this->uploadFile($request->file('mother_kk_file'), 'uploads/parents', $student->nisn)
                : null;

            $wali_kk_file = $request->hasFile('wali_kk_file')
                ? $this->uploadFile($request->file('wali_kk_file'), 'uploads/parents', $student->nisn)
                : null;

            // Simpan data ke tabel parents
            $parent = Parents::create([
                'student_id'         => $request->student_id,
                'father_m_life_status_id'   => $request->father_m_life_status_id,
                'father_m_last_education_id'   => $request->father_m_last_education_id,
                'father_m_job_id'   => $request->father_m_job_id,
                'father_m_average_income_per_month_id'   => $request->father_m_average_income_per_month_id,
                'father_full_name'   => $request->father_full_name,
                'father_nik'         => $request->father_nik,
                'father_birth_place' => $request->father_birth_place,
                'father_birth_date'  => $request->father_birth_date,
                'father_m_job_id'    => $request->father_m_job_id,
                'father_phone_number' => $request->father_phone_number,
                'father_address'     => $request->father_address,
                'father_postal_code'     => $request->father_postal_code,
                'father_kk_file'     => $father_kk_file,

                'mother_full_name'   => $request->mother_full_name,
                'mother_nik'         => $request->mother_nik,
                'mother_birth_place' => $request->mother_birth_place,
                'mother_birth_date'  => $request->mother_birth_date,
                'mother_phone_number' => $request->mother_phone_number,
                'mother_address'     => $request->mother_address,
                'mother_kk_file'     => $mother_kk_file,
                'mother_m_job_id'   => $request->mother_m_job_id,
                'mother_m_life_status_id'   => $request->mother_m_life_status_id,
                'mother_m_last_education_id'   => $request->mother_m_last_education_id,
                'mother_postal_code'   => $request->mother_m_job_id,
                'mother_m_average_income_per_month_id'   => $request->mother_m_average_income_per_month_id,

                'wali_full_name'     => $request->wali_full_name,
                'wali_nik'           => $request->wali_nik,
                'wali_birth_place'   => $request->wali_birth_place,
                'wali_birth_date'    => $request->wali_birth_date,
                'wali_phone_number'  => $request->wali_phone_number,
                'wali_address'       => $request->wali_address,
                'wali_kk_file'       => $wali_kk_file,
                'wali_kk_file'       => $request->wali_m_life_status_id,
                'wali_m_last_education_id'       => $request->wali_m_last_education_id,
                'wali_m_job_id'       => $request->wali_m_job_id,
                'wali_postal_code'       => $request->wali_postal_code,
                'wali_m_average_income_per_month_id'       => $request->wali_m_average_income_per_month_id,
                'wali_m_life_status_id'       => $request->wali_m_life_status_id,
            ]);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data berhasil disimpan.',
                'data'    => $parent,
            ], 201);
        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error'   => $th->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'student_id'         => 'required|exists:students,id',
            'father_full_name'   => 'required|string|max:255',
            'father_nik'         => 'required|numeric|digits:16',
            'father_birth_place' => 'required|string|max:255',
            'father_birth_date'  => 'required|date',
            'father_m_job_id'    => 'nullable|integer',
            'father_phone_number' => 'nullable|string|max:15',
            'father_address'     => 'nullable|string',
            'father_kk_file'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

            'mother_full_name'   => 'required|string|max:255',
            'mother_nik'         => 'required|numeric|digits:16',
            'mother_birth_place' => 'required|string|max:255',
            'mother_birth_date'  => 'required|date',
            'mother_phone_number' => 'nullable|string|max:15',
            'mother_address'     => 'nullable|string',
            'mother_kk_file'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

            'wali_full_name'     => 'required|string|max:255',
            'wali_nik'           => 'required|numeric|digits:16',
            'wali_birth_place'   => 'required|string|max:255',
            'wali_birth_date'    => 'required|date',
            'wali_phone_number'  => 'nullable|string|max:15',
            'wali_address'       => 'nullable|string',
            'wali_kk_file'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        $messages = [
            'required' => ':attribute wajib diisi.',
            'string'   => ':attribute harus berupa teks.',
            'max'      => ':attribute tidak boleh lebih dari :max karakter.',
            'numeric'  => ':attribute harus berupa angka.',
            'digits'   => ':attribute harus :digits digit.',
            'date'     => ':attribute harus berupa tanggal yang valid.',
            'integer'  => ':attribute harus berupa angka.',
            'file'     => ':attribute harus berupa file.',
            'mimes'    => ':attribute harus berformat: :values.',
            'exists'   => ':attribute tidak valid.',
        ];

        $attributes = [
            'student_id'         => 'ID Siswa',
            'father_full_name'   => 'Nama Lengkap Ayah',
            'father_nik'         => 'NIK Ayah',
            'father_birth_place' => 'Tempat Lahir Ayah',
            'father_birth_date'  => 'Tanggal Lahir Ayah',
            'father_m_job_id'    => 'ID Pekerjaan Ayah',
            'father_phone_number' => 'Nomor Telepon Ayah',
            'father_address'     => 'Alamat Ayah',
            'father_kk_file'     => 'File KK Ayah',

            'mother_full_name'   => 'Nama Lengkap Ibu',
            'mother_nik'         => 'NIK Ibu',
            'mother_birth_place' => 'Tempat Lahir Ibu',
            'mother_birth_date'  => 'Tanggal Lahir Ibu',
            'mother_phone_number' => 'Nomor Telepon Ibu',
            'mother_address'     => 'Alamat Ibu',
            'mother_kk_file'     => 'File KK Ibu',

            'wali_full_name'     => 'Nama Lengkap Wali',
            'wali_nik'           => 'NIK Wali',
            'wali_birth_place'   => 'Tempat Lahir Wali',
            'wali_birth_date'    => 'Tanggal Lahir Wali',
            'wali_phone_number'  => 'Nomor Telepon Wali',
            'wali_address'       => 'Alamat Wali',
            'wali_kk_file'       => 'File KK Wali',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Find the student
            $student = Student::where('id', $request->student_id)->first();

            if (!$student) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Siswa tidak ditemukan.',
                ], 404);
            }

            // Handle file uploads
            $father_kk_file = $request->hasFile('father_kk_file')
                ? $this->uploadFile($request->file('father_kk_file'), 'uploads/parents', $student->nisn)
                : $student->father_kk_file;

            $mother_kk_file = $request->hasFile('mother_kk_file')
                ? $this->uploadFile($request->file('mother_kk_file'), 'uploads/parents', $student->nisn)
                : $student->mother_kk_file;

            $wali_kk_file = $request->hasFile('wali_kk_file')
                ? $this->uploadFile($request->file('wali_kk_file'), 'uploads/parents', $student->nisn)
                :  $student->wali_kk_file;

            // Use updateOrCreate to either update or create the parent data
            $parent = Parents::updateOrCreate(
                ['student_id' => $request->student_id], // condition to check for existing record
                [
                    'father_m_life_status_id'   => $request->father_m_life_status_id,
                    'father_m_last_education_id'   => $request->father_m_last_education_id,
                    'father_m_job_id'   => $request->father_m_job_id,
                    'father_m_average_income_per_month_id'   => $request->father_m_average_income_per_month_id,
                    'father_full_name'   => $request->father_full_name,
                    'father_nik'         => $request->father_nik,
                    'father_birth_place' => $request->father_birth_place,
                    'father_birth_date'  => $request->father_birth_date,
                    'father_m_job_id'    => $request->father_m_job_id,
                    'father_phone_number' => $request->father_phone_number,
                    'father_address'     => $request->father_address,
                    'father_postal_code' => $request->father_postal_code,
                    'father_kk_file'     => $father_kk_file ?? '',

                    'mother_full_name'   => $request->mother_full_name,
                    'mother_nik'         => $request->mother_nik,
                    'mother_birth_place' => $request->mother_birth_place,
                    'mother_birth_date'  => $request->mother_birth_date,
                    'mother_phone_number' => $request->mother_phone_number,
                    'mother_address'     => $request->mother_address,
                    'mother_kk_file'     => $mother_kk_file ?? '',
                    'mother_m_job_id'    => $request->mother_m_job_id,
                    'mother_m_life_status_id' => $request->mother_m_life_status_id,
                    'mother_m_last_education_id' => $request->mother_m_last_education_id,
                    'mother_postal_code' => $request->mother_postal_code,
                    'mother_m_average_income_per_month_id' => $request->mother_m_average_income_per_month_id,

                    'wali_full_name'     => $request->wali_full_name,
                    'wali_nik'           => $request->wali_nik,
                    'wali_birth_place'   => $request->wali_birth_place,
                    'wali_birth_date'    => $request->wali_birth_date,
                    'wali_phone_number'  => $request->wali_phone_number,
                    'wali_address'       => $request->wali_address,
                    'wali_kk_file'       => $wali_kk_file,
                    'wali_kk_file'       => $request->wali_m_life_status_id,
                    'wali_m_last_education_id' => $request->wali_m_last_education_id,
                    'wali_m_job_id'      => $request->wali_m_job_id,
                    'wali_postal_code'   => $request->wali_postal_code,
                    'wali_m_average_income_per_month_id' => $request->wali_m_average_income_per_month_id,
                    'wali_m_life_status_id' => $request->wali_m_life_status_id,
                ]
            );

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data berhasil disimpan.',
                'data'    => $parent,
            ], 201);
        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error'   => $th->getMessage(),
            ], 500);
        }
    }

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
