<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Attendances;
use App\Models\LearningActivity;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeachingJournal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TeachingJournalController extends Controller
{
    public function index()
    {
        return view('admin.teaching-journal.index');
    }

    public function data()
    {
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            $query = TeachingJournal::with('teacher', 'learning_activity.level', 'subject')->orderBy('date', 'DESC')->get();
        } else {
            // Jika user adalah guru, tampilkan hanya data rombel yang diajar oleh guru tersebut
            $teacher = Teacher::where('user_id', $user->id)->first();
            if (!$teacher) {
                return datatables([])->make(true); // Jika tidak ditemukan sebagai guru, tampilkan kosong
            }

            $query = TeachingJournal::with('teacher', 'learning_activity.level', 'subject')
                ->where('teacher_id', $teacher->id)
                ->orderBy('date', 'DESC')->get();
        }




        return datatables($query)
            ->addIndexColumn()
            ->addColumn('learning_activity', function ($q) {
                return $this->renderLearningActivity($q);
            })
            ->addColumn('aksi', function ($q) {
                return $this->renderActionButton($q);
            })
            ->rawColumns(['aksi', 'material', 'notes', 'taks'])
            ->make(true);
    }

    private function renderLearningActivity($q)
    {
        return $q->learning_activity->level->name . ' ' . $q->learning_activity->name;
    }

    private function renderActionButton($q)
    {
        $info = $q->date . ' - ' . $q->learning_activity->level->name . ' - ' . $q->subject->name;

        return '
         <button onclick="editForm(`' . route('journals.show', $q->id) . '`)" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-pencil-alt"></i></button>
         <button onclick="deleteData(`' . route('journals.destroy', $q->id) . '`, `' .  $info . '`)" class="btn btn-sm btn-danger mr-1"><i class="fas fa-trash-alt"></i></button>
         ';
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

    public function show($id)
    {
        $journal = TeachingJournal::with('teacher', 'learning_activity.level', 'subject')->find($id);

        if (!$journal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $journal
        ], 200);
    }

    public function update(Request $request, $id)
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

        $journal = TeachingJournal::find($id);

        if (!$journal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $subject = Subject::where('id', $request->subject_id)->first();
        $journal->update([
            'date' => $request->date,
            'learning_activity_id' => $request->learning_activity_id,
            'subject_id' => $request->subject_id,
            'curiculum_id' => $subject->curiculum_id,
            'cp' => $request->cp,
            'task' => $request->task ?? '-',
            'material' => $request->material,
            'notes' => $request->notes ?? '-',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diperbarui.'
        ], 200);
    }

    public function destroy($id)
    {
        $journal = TeachingJournal::find($id);

        if (!$journal) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $journal->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus.'
        ], 200);
    }


    // Ambil daftar Learning Activities berdasarkan Tahun Akademik Aktif
    public function getLearningActivity1()
    {
        $academicYear = AcademicYear::where('is_active', '1')->first();
        if (!$academicYear) {
            return response()->json([]);
        }

        $learningActivities = LearningActivity::where('academic_year_id', $academicYear->id)
            ->with(['level']) // Pastikan relasi level() ada di model
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'level_name' => $item->level->name ?? 'N/A',
                    'curiculum_id' => $item->curiculum_id // Pastikan ini ada di tabel
                ];
            });

        return response()->json($learningActivities);
    }

    public function getLearningActivity()
    {
        $user = Auth::user(); // Ambil user yang sedang login

        // Cari Tahun Akademik Aktif
        $academicYear = AcademicYear::where('is_active', 1)->first();
        if (!$academicYear) {
            return response()->json([]);
        }

        // Ambil data guru berdasarkan user yang sedang login
        $teacher = Teacher::where('user_id', $user->id)->first();
        if (!$teacher) {
            return response()->json([]); // Jika bukan guru, return data kosong
        }

        // Ambil hanya Learning Activities yang diajar oleh guru tersebut
        $learningActivities = LearningActivity::where('academic_year_id', $academicYear->id)
            ->where('teacher_id', $teacher->id) // Filter hanya untuk guru yang sedang login
            ->with(['level']) // Pastikan relasi level() ada di model
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'level_name' => $item->level->name ?? 'N/A',
                    'curiculum_id' => $item->curiculum_id // Pastikan ini ada di tabel
                ];
            });

        return response()->json($learningActivities);
    }


    public function getSubject(Request $request)
    {
        $curiculumId = $request->curiculum_id;
        $search = $request->search; // Ambil query pencarian

        if (!$curiculumId) {
            return response()->json([]);
        }

        // Filter berdasarkan curiculum_id dan pencarian nama
        $subjects = Subject::where('curiculum_id', $curiculumId)
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->get();

        $formattedSubjects = $subjects->map(function ($subject) {
            return [
                'id' => $subject->id,
                'name' => $subject->name,
            ];
        });

        return response()->json($formattedSubjects);
    }
}
