<?php

namespace App\Http\Controllers;

use App\Models\Curiculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CuriculumController extends Controller
{
    public function index()
    {
        return view('admin.curiculum.index');
    }

    public function data(Request $request)
    {
        $query = Curiculum::all();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($q) {
                return $this->renderActionButton($q);
            })
            ->rawColumns(['status', 'aksi'])
            ->make(true);
    }

    private function renderActionButton($q)
    {
        return '
         <button onclick="editForm(`' . route('curiculums.show', $q->id) . '`)" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-pencil-alt"></i></button>
            ';
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        $data = [
            'name' => $request->name,
        ];

        Curiculum::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan'
        ], 200);
    }

    public function show($id)
    {
        $data = Curiculum::findOrfail($id);
        return response()->json(['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        $data = [
            'name' => $request->name,
        ];

        $subject = Curiculum::findOrfail($id);
        $subject->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan'
        ], 200);
    }
}
