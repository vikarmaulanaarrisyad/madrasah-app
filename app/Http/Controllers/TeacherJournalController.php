<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeachingJournal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TeacherJournalController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id; // Mengambil ID user yang login
        $teacher = Teacher::where('user_id', $userId)->first(); // Mencari data guru berdasarkan user_id

        if (!$teacher) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan.');
        }

        // Mengambil jurnal berdasarkan teacher_id dari guru yang login
        $journals = TeachingJournal::where('teacher_id', $teacher->id)
            ->orderBy('date', 'desc')
            ->get();

        return view('teacher.journal.index', compact('journals'));
    }

    public function store(Request $request)
    {
        $rules = [
            'date' => 'required',
            'learning_activity_id' => 'required',
            'subject_id' => 'required',
            'cp' => 'required',
            'material' => 'required',
            'notes' => 'nullable',
            'task' => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ], 422);
        }

        $userId = Auth::user()->id;
        $teacher = Teacher::where('user_id', $userId)->first();
        $subject = Subject::where('id', $request->subject_id)->first();
        $academicYear = AcademicYear::where('is_active', '1')->first();

        $data = [
            'teacher_id' => $teacher->id ?? 1,
            'date' => $request->date,
            'learning_activity_id' => $request->learning_activity_id,
            'subject_id' => $request->subject_id,
            'curiculum_id' => $subject->curiculum_id,
            'academic_year_id' => $academicYear->id,
            'cp' => $request->cp,
            'task' => $request->task ?? '-',
            'material' => $request->material,
            'notes' => $request->notes ?? '-',
        ];

        TeachingJournal::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan'
        ], 200);
    }
}
