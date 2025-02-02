<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\Religion;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function index()
    {
        $genders = Gender::pluck('id', 'name');
        $religions = Religion::pluck('id', 'name');

        return view('admin.teacher.index', compact('genders', 'religions'));
    }

    public function data()
    {
        $query = Teacher::orderBy('full_name', 'DESC')->get();

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('m_gender_id', function ($q) {
                return $this->renderGender($q);
            })
            ->addColumn('aksi', function ($q) {
                return $this->renderActionButton($q);
            })
            ->rawColumns(['status', 'aksi']) // Pastikan kolom ini diproses sebagai HTML
            ->make(true);
    }

    private function renderGender($q)
    {

        return $q->gender->name;
    }

    private function renderActionButton($q)
    {
        return '
         <button onclick="editForm(`' . route('teachers.show', $q->id) . '`)" class="btn btn-xs btn-primary" title="Edit"><i class="fas fa-pencil-alt"></i></button>

            ';
    }

    public function store(Request $request)
    {
        $rules = [
            'full_name' => 'required',
            'brith_place' => 'required',
            'birth_date' => 'required',
            'm_gender_id' => 'required',
            'm_religion_id' => 'required',
            'address' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'postal_code_num' => 'required',
            'tmt_teacher' => 'required',
            'tmt_employe' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        DB::beginTransaction(); // Mulai transaksi

        try {
            // Simpan user
            $user = User::create([
                'name' => $request->full_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make('password') // Bisa ganti dengan request input
            ]);

            // Simpan teacher
            Teacher::create([
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'brith_place' => $request->brith_place,
                'birth_date' => $request->birth_date,
                'm_gender_id' => $request->m_gender_id,
                'm_religion_id' => $request->m_religion_id,
                'address' => $request->address,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'postal_code_num' => $request->postal_code_num,
                'tmt_teacher' => $request->tmt_teacher,
                'tmt_employe' => $request->tmt_employe,
                'full_address' => $request->address . ' RT.' . $request->rt . ' RW.' . $request->rw,
            ]);

            DB::commit(); // Simpan transaksi jika semua berhasil

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika ada kesalahan

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id); // Mengambil data teacher beserta user

        if (!$teacher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $teacher
        ], 200);
    }

    public function update(Request $request, $id)
    {
        // Cari data teacher berdasarkan ID
        $teacher = Teacher::findOrFail($id);

        // Update data user terkait
        $user = User::findOrFail($teacher->user_id);
        $rules = [
            'full_name' => 'required',
            'brith_place' => 'required',
            'birth_date' => 'required',
            'm_gender_id' => 'required',
            'm_religion_id' => 'required',
            'address' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'postal_code_num' => 'required',
            'tmt_teacher' => 'required',
            'tmt_employe' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|unique:users,username,' . $user->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        DB::beginTransaction();
        try {

            $user->update([
                'name' => $request->full_name,
                'username' => $request->username,
                'email' => $request->email,
            ]);

            // Update data teacher
            $teacher->update([
                'full_name' => $request->full_name,
                'brith_place' => $request->brith_place,
                'birth_date' => $request->birth_date,
                'm_gender_id' => $request->m_gender_id,
                'm_religion_id' => $request->m_religion_id,
                'address' => $request->address,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'postal_code_num' => $request->postal_code_num,
                'tmt_teacher' => $request->tmt_teacher,
                'tmt_employe' => $request->tmt_employe,
                'full_address' => $request->address . ' RT.' . $request->rt . ' RW.' . $request->rw,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diperbarui',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
