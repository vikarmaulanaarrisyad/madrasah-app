<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.academic-year.index');
    }

    public function data()
    {
        $query = AcademicYear::orderBy('name', 'DESC')->get();

        return datatables($query)
            ->addIndexColumn()
            ->editColumn('status', function ($q) {
                return $this->renderStatusBadge($q);
            })
            ->addColumn('aksi', function ($q) {
                return $this->renderActionButton($q);
            })
            ->rawColumns(['status', 'aksi']) // Pastikan kolom ini diproses sebagai HTML
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'semester' => 'required|in:Ganjil,Genap'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        } else {
            $data = [
                'name' => $request->name,
                'semester' => $request->semester,
                'year' => $request->name . ' ' . $request->semester,
            ];

            AcademicYear::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan'
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = AcademicYear::findOrfail($id);
        return response()->json(['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $academicYear = AcademicYear::findOrfail($id);

        $rules = [
            'name' => 'required',
            'semester' => 'required|in:Ganjil,Genap'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        } else {
            $data = [
                'name' => $request->name,
                'semester' => $request->semester,
                'year' => $request->name . ' ' . $request->semester,
            ];

            $academicYear->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diperbaharui'
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus($id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        DB::transaction(function () use ($academicYear) {
            // Nonaktifkan semua yang aktif
            AcademicYear::where('is_active', 1)->update(['is_active' => 0]);

            // Aktifkan hanya yang dipilih
            $academicYear->update(['is_active' => 1]);
        });

        return response()->json(['message' => 'Status berhasil diperbarui'], 200);
    }

    private function renderStatusBadge($q)
    {

        return '<span class="badge badge-' . e($q->statusColor()) . '">' . e($q->statusText()) . '</span>';
    }

    private function renderActionButton($q)
    {
        return '
        <button onclick="updateStatus(`' . e($q->id) . '`)" class="btn btn-xs btn-warning mr-1" title="Ubah Status">
                    <i class="fas fa-exchange-alt"></i>
                </button>

         <button onclick="editForm(`' . route('academicyears.show', $q->id) . '`)" class="btn btn-xs btn-primary" title="Edit"><i class="fas fa-pencil-alt"></i></button>

            ';
    }
}
