<!DOCTYPE html>
<html lang="id">

<head>
    @php
        $institution = \App\Models\Institution::first();
    @endphp

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $institution->name }}</title>
    <style>
        @page {
            margin: 25px 55px;
        }

        /* Header hanya muncul di halaman kedua dan seterusnya */
        @page :nth(2) {
            @top-center {
                content: element(header);
            }
        }

        body {
            font-family: Arial, sans-serif;
        }

        .kop {
            width: 100%;
            border-bottom: 5px solid black;
            text-align: center;
        }

        .kop img {
            width: 80px;
            height: auto;
        }

        .kop td {
            vertical-align: middle;
        }

        .kop .lembaga {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop .alamat {
            font-size: 14px;
        }

        .judul {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .biodata-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .biodata-table td {
            padding: 5px;
            vertical-align: top;
        }

        /* Styling agar titik dua sejajar */
        .biodata-table td:first-child {
            width: 40%;
            text-align: left;
            padding-right: 5px;
            white-space: nowrap;
        }

        .biodata-table td:nth-child(2) {
            width: 5%;
            text-align: center;
            font-weight: bold;
        }

        .biodata-table td:nth-child(3) {
            width: 55%;
            text-align: left;
        }

        .section-title {
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px;
        }

        .wali-kelas {
            border: 1px solid black;
            padding: 10px;
            margin-top: 20px;
            display: inline-block;
        }

        .wali-kelas-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .wali-kelas-table td {
            padding: 20px;
        }

        /* Hindari kop sebelum konten sebelumnya selesai */
        .page-break {
            page-break-before: always;
        }

        .category-header {
            background-color: #ddd;
            font-weight: bold;
            text-align: left;
        }
    </style>
</head>

<body>
    <table class="kop">
        <tr>
            <td style="width: 10%; text-align: center;">
                <img src="{{ public_path('image/logo.jpg') }}" alt="Logo Kiri" style="width:100px;">
            </td>

            <td style="width: 90%; text-align: center;">
                <div class="lembaga">
                    <span style="font-size: 20px; font-weight: bold;">YAYASAN ASSALAFIYAH AL MUNAWAROH</span><br>
                    <span style="font-size: 22px; font-weight: bold;">MADRASAH IBTIDAIYAH ASSALAFIYAH</span><br>
                    <span style="font-size: 14px; font-weight: bold;">STATUS: TERAKREDITASI B</span><br>
                    <span style="font-size: 14px;">Desa Kemanggungan, Kec. Tarub, Kab. Tegal</span>
                </div>
                <div class="alamat" style="margin-top: 5px; font-size: 13px;">
                    Alamat: Jl. Projosumarto II Gang Mawar 1, Kemanggungan, Tarub, Tegal 52184
                </div>
            </td>
        </tr>
    </table>
    {{--  <hr style="border: 2px solid black; margin-top: 5px;">  --}}


    <div class="judul">LEMBAR BUKU INDUK SISWA</div>

    <table class="biodata-table">
        <tr>
            <td>NIS (Nomor Induk Siswa)</td>
            <td>:</td>
            <td>{{ $student->local_nis }}</td>
        </tr>
        <tr>
            <td>NISN (Nomor Induk Siswa Nasional)</td>
            <td>:</td>
            <td>{{ $student->nisn }}</td>
        </tr>
        <tr>
            <td>Sekolah</td>
            <td>:</td>
            <td>{{ $institution->name }}</td>
        </tr>
    </table>

    <p class="section-title">A. IDENTITAS PESERTA DIDIK</p>

    <table class="biodata-table">
        <tr>
            <td>1. Nama Siswa</td>
            <td>:</td>
            <td>{{ $student->full_name }}</td>
        </tr>
        <tr>
            <td>2. Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $student->gender->name }}</td>
        </tr>
        <tr>
            <td>3. Tempat/Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $student->birth_place }}, {{ tanggal_indonesia($student->birth_date) }}</td>
        </tr>
        <tr>
            <td>4. Agama</td>
            <td>:</td>
            <td>{{ $student->religion->name }}</td>
        </tr>
        <tr>
            <td>5. Kewarganegaraan</td>
            <td>:</td>
            <td>Indonesia</td>
        </tr>
        <tr>
            <td>6. Anak Ke</td>
            <td>:</td>
            <td>{{ $student->child_of_num }}</td>
        </tr>
        <tr>
            <td>7. Jumlah Saudara</td>
            <td>:</td>
            <td>{{ $student->siblings_num }}</td>
        </tr>
    </table>

    <p class="section-title">B. KETERANGAN TEMPAT TINGGAL</p>

    <table class="biodata-table">
        <tr>
            <td>8. Alamat Siswa</td>
            <td>:</td>
            <td>{{ $student->address }} RT {{ $student->rt }} RW {{ $student->rw }} Kode Pos
                {{ $student->postal_code_num }}</td>
        </tr>
        <tr>
            <td>9. Status Tempat Tinggal</td>
            <td>:</td>
            <td>{{ $student->residenceStatus->name }}</td>
        </tr>
        <tr>
            <td>10. Jarak Tempat Tinggal ke Madrasah</td>
            <td>:</td>
            <td>{{ $student->residenceDistance->name }}</td>
        </tr>
    </table>

    <p class="section-title">C. KETERANGAN KESEHATAN</p>
    <table class="biodata-table">
        <tr>
            <td>11. Tinggi Badan (cm)</td>
            <td>:</td>
            <td>{{ $student->height ?? '-' }} cm</td>
        </tr>
        <tr>
            <td>12. Berat Badan (kg)</td>
            <td>:</td>
            <td>{{ $student->weight ?? '-' }} kg</td>
        </tr>
    </table>

    <p class="section-title">D. KETERANGAN PENDIDIKAN</p>
    <table class="biodata-table">
        <tr>
            <td>13. Diterima di Madrasah ini</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="padding-left: 20px;">a. Di Kelas</td>
            <td>:</td>
            <td>{{ optional($student->learningActivities->first())->level->name ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding-left: 20px;">b. Pada Tanggal</td>
            <td>:</td>
            <td>{{ tanggal_indonesia($student->created_at) }}</td>
        </tr>
    </table>
    <p class="section-title">E. KETERANGAN AYAH KANDUNG</p>
    <table class="biodata-table">
        <tr>
            <td>14. Nama Lengkap</td>
            <td>:</td>
            <td>{{ $student->parent->father_full_name ?? '-' }}</td>
        </tr>
        <tr>
            <td>15. Tempat/Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $student->parent->father_birth_place ?? '-' }},
                {{ isset($student->parent->father_birth_date) ? tanggal_indonesia($student->parent->father_birth_date) : '-' }}
            </td>
        </tr>
        <tr>
            <td>16 Agama</td>
            <td>:</td>
            <td>{{ $student->parent->religion->name ?? 'Islam' }}</td>
        </tr>
        <tr>
            <td>17. Kewarganegaraan</td>
            <td>:</td>
            <td>Indonesia</td>
        </tr>
        <tr>
            <td>18. Pendidikan Terakhir</td>
            <td>:</td>
            <td>{{ $student->parent->education_father->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>19. Pekerjaan</td>
            <td>:</td>
            <td>{{ $student->parent->job->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>20. Penghasilan per Bulan</td>
            <td>:</td>
            <td>{{ $student->parent->average_income_father->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>21. Alamat</td>
            <td>:</td>
            <td>{{ $student->parent->father_address ?? '-' }} RT {{ $student->parent->father_rt ?? '-' }} RW
                {{ $student->parent->father_rw ?? '-' }} Kode Pos
                {{ $student->parent->father_postal_code ?? '-' }}</td>
        </tr>
        <tr>
            <td>22. Nomor Telp/HP</td>
            <td>:</td>
            <td>{{ $student->parent->father_phone_number ?? '-' }}</td>
        </tr>
        <tr>
            <td>22. Status Ayah</td>
            <td>:</td>
            <td>{{ $student->parent->life_status_father->name ?? '-' }}</td>
        </tr>
    </table>

    <p class="section-title">F. KETERANGAN IBU KANDUNG</p>
    <table class="biodata-table">
        <tr>
            <td>23. Nama Lengkap</td>
            <td>:</td>
            <td>{{ $student->parent->mother_full_name ?? '-' }}</td>
        </tr>
        <tr>
            <td>24. Tempat/Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $student->parent->mother_birth_place ?? '-' }},
                {{ isset($student->parent->mother_birth_date) ? tanggal_indonesia($student->parent->mother_birth_date) : '-' }}
            </td>
        </tr>
        <tr>
            <td>25 Agama</td>
            <td>:</td>
            <td>{{ $student->parent->religion_mother->name ?? 'Islam' }}</td>
        </tr>
        <tr>
            <td>26. Kewarganegaraan</td>
            <td>:</td>
            <td>Indonesia</td>
        </tr>
        <tr>
            <td>27. Pendidikan Terakhir</td>
            <td>:</td>
            <td>{{ $student->parent->education_mother->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>28. Pekerjaan</td>
            <td>:</td>
            <td>{{ $student->parent->job_mother->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>29. Penghasilan per Bulan</td>
            <td>:</td>
            <td>{{ $student->parent->average_income_mother->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>30. Alamat</td>
            <td>:</td>
            <td>{{ $student->parent->mother_address ?? '-' }} RT {{ $student->parent->mother_rt ?? '-' }} RW
                {{ $student->parent->mother_rw ?? '-' }} Kode Pos
                {{ $student->parent->mother_postal_code ?? '-' }}</td>
        </tr>
        <tr>
            <td>31. Nomor Telp/HP</td>
            <td>:</td>
            <td>{{ $student->parent->mother_phone_number ?? '-' }}</td>
        </tr>
        <tr>
            <td>32. Status Ibu</td>
            <td>:</td>
            <td>{{ $student->parent->life_status_mother->name ?? '-' }}</td>
        </tr>
    </table>

    {{--  KASIH FOTO UKURAN 3X4  --}}
    <div style="text-align: center; margin-bottom: 20px; margin-top:20px;">
        @if (!empty($student->upload_photo))
            <img src="{{ public_path('storage/' . $student->upload_photo) }}" alt="Foto Siswa"
                style="width: 3cm; height: 4cm; object-fit: cover; border: 1px solid black;">
        @else
            <div style="width: 3cm; height: 4cm; border: 1px solid black; display: inline-block;">
                <p> Foto Ukuran 3x4</p>
            </div>
        @endif
    </div>
    <table class="wali-kelas-table" style="width: 100%;">
        <tr>
            <td style="text-align: center; width: 50%;">
                Orang Tua/Wali
                <br><br><br><br>
                <br>
                <br>
                <b>{{ $student->parent->father_full_name ?? '...........................' }}</b>
            </td>
            <td style="text-align: center; width: 50%;">
                Guru {{ $student->learningActivities->first()->level->name }}
                <br><br><br><br>
                <br>
                <br>
                <b>{{ $student->learningActivities->first()->teacher->full_name ?? '...........................' }}</b>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; padding-top: 30px;">
                Kepala Madrasah
                <br><br><br><br>

                <br>
                <br>
                <b>{{ $institution->institution_head ?? '...........................' }}</b>
            </td>
        </tr>
    </table>

    <div class="page-break"></div> <!-- Memulai halaman baru -->

    <table class="kop">
        <tr>
            <td style="width: 10%; text-align: center;">
                <img src="{{ public_path('image/logo.jpg') }}" alt="Logo Kiri" style="width:100px;">
            </td>
            <td style="width: 90%; text-align: center;">
                <div class="lembaga">
                    <span style="font-size: 20px; font-weight: bold;">YAYASAN ASSALAFIYAH AL MUNAWAROH</span><br>
                    <span style="font-size: 22px; font-weight: bold;">MADRASAH IBTIDAIYAH ASSALAFIYAH</span><br>
                    <span style="font-size: 14px; font-weight: bold;">STATUS: TERAKREDITASI B</span><br>
                    <span style="font-size: 14px;">Desa Kemanggungan, Kec. Tarub, Kab. Tegal</span>
                </div>
                <div class="alamat" style="margin-top: 5px; font-size: 13px;">
                    Alamat: Jl. Projosumarto II Gang Mawar 1, Kemanggungan, Tarub, Tegal 52184
                </div>
            </td>
        </tr>
    </table>

    <div class="judul">NILAI AKADEMIK</div>

    {{--  <table class="biodata-table" border="1">
        <tr>
            <th>Mata Pelajaran</th>
            <th>Nilai</th>
            <th>Keterangan</th>
        </tr>
        @php
            $firstActivity = $student->learningActivities->first();
            $curiculum = $firstActivity->curiculum ?? null;
            $subjects = \App\Models\Subject::where('curiculum_id', $curiculum->id)->get();
        @endphp


        @if ($subjects && isset($subjects) && is_iterable($subjects))
            @foreach ($subjects as $record)
                <tr>
                    <td>{{ $record->name ?? 'Mata Pelajaran Tidak Ditemukan' }}</td>
                    <td>{{ $record->score ?? '-' }}</td>
                    <td>{{ $record->description ?? '-' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3">Mata Pelajaran Tidak Ditemukan</td>
            </tr>
        @endif


    </table>  --}}

    {{--  <table class="biodata-table" border="1">
        <tr>
            <th>Mata Pelajaran</th>
            @for ($i = 1; $i <= 6; $i++)
                <th>Kelas {{ $i }}</th>
            @endfor
        </tr>

        @php
            $subjects = \App\Models\Subject::all();
        @endphp

        @if ($subjects->isNotEmpty())
            @foreach ($subjects as $subject)
                <tr>
                    <td>{{ $subject->name ?? '-' }}</td>

                    @for ($i = 1; $i <= 6; $i++)
                        @php
                            $activity = $student->learningActivities->where('class_level', $i)->first();
                            $curiculum = $activity
                                ? $activity->curiculum->where('subject_id', $subject->id)->first()
                                : null;
                        @endphp
                        <td>{{ $curiculum->score ?? '-' }}</td>
                    @endfor
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7">Mata Pelajaran Tidak Ditemukan</td>
            </tr>
        @endif
    </table>  --}}

    {{--  <table class="biodata-table" border="1">
        <tr>
            <th rowspan="2">No Urut</th>
            <th rowspan="2">Mata Pelajaran</th>
            <th colspan="6">Semester</th>
        </tr>
        <tr>
            @for ($i = 1; $i <= 6; $i++)
                <th>{{ $i }}</th>
            @endfor
        </tr>


        @php
            $subjects = \App\Models\Subject::all();
            $groupedSubjects = $subjects->groupBy('group'); // Mengelompokkan mapel berdasarkan kategori
        @endphp

        @foreach ($groupedSubjects as $category => $subjects)
            <tr>
                <td colspan="8"><strong>{{ strtoupper($category) }}</strong></td>
            </tr>
            @foreach ($subjects as $index => $subject)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $subject->name }}</td>

                    @for ($i = 1; $i <= 6; $i++)
                        @php
                            $activity = $student->learningActivities->where('class_level', $i)->first();
                            $curiculum = $activity
                                ? $activity->curiculum->where('subject_id', $subject->id)->first()
                                : null;
                        @endphp
                        <td>{{ $curiculum->score ?? '-' }}</td>
                    @endfor
                </tr>
            @endforeach
        @endforeach
    </table>  --}}
    {{--
    <table class="biodata-table">
        <tr>
            <th class="col-no" rowspan="2">No</th>
            <th class="col-subject" rowspan="2">Mata Pelajaran</th>
            <th colspan="6">Semester</th>
        </tr>
        <tr>
            @for ($i = 1; $i <= 6; $i++)
                <th class="col-semester center-text">{{ $i }}</th>
            @endfor
        </tr>

        @php
            $subjects = \App\Models\Subject::all();
            $groupedSubjects = $subjects->groupBy('group'); // Mengelompokkan mapel berdasarkan kategori
        @endphp

        @foreach ($groupedSubjects as $category => $subjects)
            <tr>
                <td colspan="8" class="category-header" style="font-weight: bold; text-transform: uppercase;">
                    {{ $category }}
                </td>
            </tr>
            @foreach ($subjects as $index => $subject)
                <tr>
                    <td class="col-no center-text">{{ $index + 1 }}</td>
                    <td class="col-subject">{{ $subject->name }}</td>

                    @for ($i = 1; $i <= 6; $i++)
                        @php
                            $activity = $student->learningActivities->where('class_level', $i)->first();
                            $curiculum = $activity
                                ? $activity->curiculum->where('subject_id', $subject->id)->first()
                                : null;
                        @endphp
                        <td class="col-semester center-text">{{ $curiculum->score ?? '-' }}</td>
                    @endfor
                </tr>
            @endforeach
        @endforeach
    </table>  --}}

    <table class="biodata-table">
        <tr>
            <th>Mata Pelajaran</th>
            <th>Nilai</th>
            <th>Keterangan</th>
        </tr>

        @php
            $firstActivity = $student->learningActivities->first();
            $curiculum = $firstActivity->curiculum ?? null;
            $subjects = \App\Models\Subject::where('curiculum_id', $curiculum->id)->get();
            $groupedSubjects = $subjects->groupBy('group'); // Kelompokkan berdasarkan kategori
        @endphp

        @if ($subjects && isset($subjects) && is_iterable($subjects))
            @foreach ($groupedSubjects as $category => $subjectGroup)
                <!-- Header Kategori -->
                <tr>
                    <td colspan="3" class="category-header">
                        <strong>{{ strtoupper($category) }}</strong>
                    </td>
                </tr>

                <!-- Daftar Mata Pelajaran dalam Kategori -->
                @foreach ($subjectGroup as $record)
                    <tr>
                        <td>{{ $record->name ?? 'Mata Pelajaran Tidak Ditemukan' }}</td>
                        <td style="text-align: center;">{{ $record->score ?? '-' }}</td>
                        <td style="text-align: center;">{{ $record->description ?? '-' }}</td>
                    </tr>
                @endforeach
            @endforeach
        @else
            <tr>
                <td colspan="3">Mata Pelajaran Tidak Ditemukan</td>
            </tr>
        @endif
    </table>


</body>

</html>
