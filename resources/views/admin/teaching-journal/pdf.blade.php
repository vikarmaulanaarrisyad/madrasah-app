<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Mengajar Guru</title>
    <style>
        @page {
            size: A4 portrait;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 100%;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid black;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer-table {
            width: 100%;
            margin-top: 40px;
            border: none;
        }
    </style>
</head>

<body>
    @php
        $institution = \App\Models\Institution::first();
    @endphp
    <div class="container">
        <h2>JURNAL MENGAJAR GURU</h2>
        <table style="width: 100%; border: none; border-collapse: collapse;">
            <tr style="border: none;">
                <td style="border: none;"><strong>NAMA SEKOLAH</strong></td>
                <td style="border: none;">: {{ $institution->name }}</td>
                <td style="border: none;"><strong>KURIKULUM</strong></td>
                <td style="border: none;">: {{ $journals->first()->learning_activity->curiculum->name ?? '-' }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>MATA PELAJARAN</strong></td>
                <td style="border: none;">: {{ $journals->first()->subject->name ?? '-' }}</td>
                <td style="border: none;"><strong>NAMA GURU</strong></td>
                <td style="border: none;">: {{ $journals->first()->teacher->full_name ?? '-' }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>KELAS / SEMESTER</strong></td>
                <td style="border: none;">: {{ $journals->first()->learning_activity->level->name ?? '-' }} /
                    {{ $journals->first()->learning_activity->academicYear->semester ?? '-' }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>TAHUN PELAJARAN</strong></td>
                <td style="border: none;">: {{ $journals->first()->learning_activity->academicYear->name ?? '-' }}</td>
            </tr>
        </table>


        <table>
            <tr>
                <th>NO</th>
                <th>HARI / TANGGAL</th>
                <th>KD / CP</th>
                <th>Materi</th>
                <th>PENUGASAN</th>
                <th>CATATAN</th>
            </tr>
            @foreach ($journals as $index => $journal)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ tanggal_indonesia($journal->date) }}</td>
                    <td>{{ $journal->cp ?? '-' }}</td>
                    <td>{{ $journal->material ?? '-' }}</td>
                    <td>{{ $journal->task ?? '-' }}</td>
                    <td>{{ $journal->notes ?? '-' }}</td>
                </tr>
            @endforeach
        </table>

        <table class="footer-table border-none">
            <tr>
                <td style="text-align: center; width: 50%; border:none;">
                    <p>Mengetahui,</p>
                    <p style="margin-bottom:70px">Kepala {{ $institution->name }}</p>
                    <p> {{ $institution->institution_head }}</p>
                </td>
                <td style="text-align: center; width: 50%; border:none;">
                    <p>Tarub, {{ tanggal_indonesia(now()) }}</p>
                    <p style="margin-bottom:70px">Guru
                        {{ $journals->first()->teacher->learningActivities->first()->level->name }}</p>
                    <p class="text-bold">{{ $journals->first()->teacher->full_name ?? '____________________' }}</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Script untuk menampilkan nomor halaman -->
    <script type="text/php">
    if (isset($pdf)) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $size = 10;
            $pageText = "Halaman " . $PAGE_NUM . " dari " . $PAGE_COUNT;
            $y = 820; // Posisi bawah (sesuaikan jika perlu)
            $x = ($pdf->get_width() - $fontMetrics->get_text_width($pageText, $font, $size)) / 2;
            $pdf->text($x, $y, $pageText, $font, $size);
        ');
    }
</script>

</body>

</html>
