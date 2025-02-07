<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Curiculum;
use App\Models\LearningActivity;
use App\Models\Level;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LearningActivityController extends Controller
{
    public function index()
    {
        $levels = Level::all();
        $teachers = Teacher::all();
        $curiculums = Curiculum::all();

        return view('admin.learning-activity.index', compact('levels', 'teachers', 'curiculums'));
    }

    public function data()
    {
        $query = LearningActivity::with('teacher', 'students', 'level', 'academicYear', 'curiculum')
            ->orderBy('name', 'ASC')
            ->get();

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('name', function ($q) {
                return $q->level->name . ' ' . $q->name;
            })
            ->addColumn('teacher_id', function ($q) {
                return $q->teacher->full_name;
            })
            ->addColumn('curiculum_id', function ($q) {
                return $q->curiculum->name ?? '<span class="badge badge-warning">Belum disetting kurikulum</span>';
            })
            ->addColumn('number_of_student', function ($q) {
                return $q->students->count(); // Hitung jumlah siswa dalam rombel
            })
            ->addColumn('aksi', function ($q) {
                return $this->renderActionButton($q);
            })
            ->rawColumns(['curiculum_id', 'aksi'])
            ->make(true);
    }

    private function renderActionButton($q)
    {
        $user = Auth::user(); // Ambil user yang sedang login

        // Jika user adalah wali kelas dari learning activity, tampilkan tombol Presensi
        if ($user->id == $q->teacher_id) {
            return '
            <a href="' . route('rombel.detail', $q->id) . '" class="btn btn-sm btn-primary">Detail</a>
            <a href="' . route('attendance.show', $q->id) . '" class="btn btn-sm btn-warning">Presensi</a>
        ';
        } else {
            return '
            <a href="' . route('rombel.detail', $q->id) . '" class="btn btn-sm btn-primary">Detail</a>
        ';
        }
    }

    public function store(Request $request)
    {
        $academicYear = AcademicYear::where('is_active', '1')->first();

        $rules = [
            'teacher_id' => 'required',
            'm_level_id' => 'required',
            'curiculum_id' => 'required',
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
            'academic_year_id' => $academicYear->id,
            'm_level_id' => $request->m_level_id,
            'rombel_type_id' => $request->m_level_id,
            'teacher_id' => $request->teacher_id,
            'curiculum_id' => $request->curiculum_id,
            'name' => $request->name,
        ];

        // Simpan to dataabse
        LearningActivity::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan'
        ], 200);
    }

    public function detail($id)
    {
        $learningActivity = LearningActivity::with('teacher', 'students', 'level', 'academicYear', 'curiculum')->findOrfail($id);

        return view('admin.learning-activity.detail', compact('learningActivity'));
    }

    public function edit($id)
    {
        $learningActivity = LearningActivity::with('teacher', 'students', 'level', 'academicYear', 'curiculum')->findOrFail($id);

        $teachers = Teacher::all(); // Get all teachers for dropdown
        // Get all students who are NOT enrolled in the current learning activity
        $students = Student::whereDoesntHave('learningActivities', function ($query) use ($id) {
            $query->where('learning_activity_id', $id);
        })->get();

        $curiculums = Curiculum::all();

        return view('admin.learning-activity.edit', compact('learningActivity', 'teachers', 'students', 'curiculums'));
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'teacher_id' => 'required',
            'curiculum_id' => 'required',
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
            'teacher_id' => $request->teacher_id,
            'curiculum_id' => $request->curiculum_id,
            'name' => $request->name,
        ];

        $learningActivity = LearningActivity::findOrfail($id);
        $learningActivity->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan'
        ], 200);
    }

    public function addStudent(Request $request, LearningActivity $learningActivity)
    {
        // Validate the incoming data - ensure student_id is an array and all IDs exist
        $request->validate([
            'student_id' => 'required|array|min:1',  // Ensure at least one student is selected
            'student_id.*' => 'exists:students,id',  // Ensure each student ID is valid
        ]);

        // Get the student IDs from the request
        $studentIds = $request->student_id;

        // Check for existing students in the learning activity
        $existingStudents = $learningActivity->students()->whereIn('student_id', $studentIds)->pluck('student_id')->toArray();

        // Find the students that are not already in the learning activity
        $studentsToAdd = array_diff($studentIds, $existingStudents);

        // If there are no new students to add, return a message
        if (empty($studentsToAdd)) {
            return response()->json([
                'message' => 'Semua siswa sudah terdaftar di rombel ini.'
            ], 400);
        }

        // Attach the students to the learning activity
        $learningActivity->students()->attach($studentsToAdd);

        return response()->json([
            'message' => 'Siswa berhasil ditambahkan ke rombel.'
        ]);
    }

    public function removeStudent($learningActivityId, $studentId)
    {
        $learningActivity = LearningActivity::findOrFail($learningActivityId);
        $student = Student::findOrFail($studentId);

        // Hapus siswa dari learning activity
        $learningActivity->students()->detach($student->id);

        // Kembalikan response dalam format JSON
        return response()->json([
            'message' => 'Siswa berhasil dihapus!',
        ]);
    }
}
