<?php

namespace App\Http\Controllers;

use App\Models\Curiculum;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function index()
    {
        $curiculums = Curiculum::all();

        return view('admin.subject.index', compact('curiculums'));
    }

    public function data(Request $request)
    {
        $query = Subject::with('curiculum')
            ->when($request->has('curiculum_id') && $request->curiculum_id != "", function ($query) use ($request) {
                $query->where('curiculum_id', $request->curiculum_id);
            })
            ->get();

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
         <button onclick="editForm(`' . route('subjects.show', $q->id) . '`)" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-pencil-alt"></i></button>
            ';
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'curiculum_id' => 'required',
            'group' => 'required'
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
            'curiculum_id' => $request->curiculum_id,
            'group' => $request->group,
        ];

        Subject::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan'
        ], 200);
    }

    public function show($id)
    {
        $data = Subject::with('curiculum')->findOrfail($id);
        return response()->json(['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'curiculum_id' => 'required',
            'group' => 'required'
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
            'curiculum_id' => $request->curiculum_id,
            'group' => $request->group,
        ];

        $subject = Subject::findOrfail($id);
        $subject->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan'
        ], 200);
    }
}
