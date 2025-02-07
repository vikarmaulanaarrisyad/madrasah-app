<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function index()
    {
        $institution = Institution::first();
        return view('admin.setting.institution', compact('institution'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'institution_head' => 'required|string|max:255',
            'institution_status' => 'required|string|max:50',
            'npsn' => 'required|string|max:20',
            'nsm' => 'required|string|max:20',
        ]);

        $institution = Institution::updateOrCreate(
            ['id' =>'1'], // Kondisi pencarian berdasarkan NPSN
            [
                'name' => $request->name,
                'institution_head' => $request->institution_head,
                'institution_status' => $request->institution_status,
                'nsm' => $request->nsm,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => $institution->wasRecentlyCreated ? 'Data baru berhasil ditambahkan' : 'Data berhasil diperbarui',
            'data' => $institution
        ], 200);
    }
}
