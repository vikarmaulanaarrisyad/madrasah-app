<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Presensi Harian Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .info {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
        }

        .signature-table {
            width: 100%;
            margin-top: 30px;
            text-align: center;
            border: none;
        }

        .signature-table td {
            width: 50%;
            padding-top: 10px;
            vertical-align: top;
            border: none;
        }
    </style>
</head>

<body>
    @php
        $academicYear = \App\Models\AcademicYear::where('is_active', '1')->first();
    @endphp
    <div class="title">
        BUKU PRESENSI HARIAN SISWA<br>
        TAHUN PELAJARAN {{ $academicYear->name }}
    </div>
    <br><br>

    <table style="margin-top: 10px; width: 100%; border: none;">
        <tr style="border: none">
            <td style="text-align: left; border:none;"><strong>Kelas/Semester :</strong> {{ $kelas->level->name }} /
                {{ $academicYear->semester }}</td>
            <td style="text-align: right; border:none;"><strong>Bulan:</strong> {{ $namaBulan }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">NIS</th>
                <th rowspan="2">NISN</th>
                <th rowspan="2">Nama</th>
                <th colspan="{{ $data[array_key_first($data)]['jumlahHari'] }}">Tanggal</th>
                <th colspan="4">Jumlah</th>
            </tr>
            <tr>
                @for ($i = 1; $i <= $data[array_key_first($data)]['jumlahHari']; $i++)
                    <th>{{ $i }}</th>
                @endfor
                <th>H</th>
                <th>S</th>
                <th>I</th>
                <th>A</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalHadir = $totalSakit = $totalIzin = $totalAlpha = 0;
                $totalHari = $data[array_key_first($data)]['jumlahHari'] * count($data);
            @endphp

            @foreach ($data as $nisn => $siswa)
                @php
                    $hadir = $izin = $sakit = $alpha = 0;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $siswa['nis'] }}</td>
                    <td>{{ $siswa['nisn'] }}</td>
                    <td>{{ $siswa['nama'] }}</td>

                    @for ($i = 1; $i <= $siswa['jumlahHari']; $i++)
                        @php
                            $status = $siswa['kehadiran'][$i] ?? '-';
                            if ($status === 'H') {
                                $hadir++;
                                $totalHadir++;
                            } elseif ($status === 'I') {
                                $izin++;
                                $totalIzin++;
                            } elseif ($status === 'S') {
                                $sakit++;
                                $totalSakit++;
                            } elseif ($status === 'A') {
                                $alpha++;
                                $totalAlpha++;
                            }
                        @endphp
                        <td>{{ $status }}</td>
                    @endfor

                    <td>{{ $hadir }}</td>
                    <td>{{ $sakit }}</td>
                    <td>{{ $izin }}</td>
                    <td>{{ $alpha }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @php
        $persenSakit = $totalHari ? ($totalSakit / $totalHari) * 100 : 0;
        $persenIzin = $totalHari ? ($totalIzin / $totalHari) * 100 : 0;
        $persenAlpha = $totalHari ? ($totalAlpha / $totalHari) * 100 : 0;
        $totalPersen = $persenSakit + $persenIzin + $persenAlpha;
    @endphp

    <div class="footer">
        <p>
            (S) Sakit = <strong>{{ number_format($persenSakit, 2) }}%</strong> |
            (I) Izin = <strong>{{ number_format($persenIzin, 2) }}%</strong> |
            (A) Alpha = <strong>{{ number_format($persenAlpha, 2) }}%</strong> |
            Jumlah = <strong>{{ number_format($totalPersen, 2) }}%</strong>
        </p>
    </div>

    @php
        use Carbon\Carbon;
        $tanggalAkhirBulan = Carbon::now()->endOfMonth()->translatedFormat('d F Y');
        $institution = \App\Models\Institution::first();
    @endphp
    <table class="signature-table">
        <tr>
            <td>
                <p>Mengetahui,</p>
                <p>Kepala {{ $institution->name }}</p>
                <br><br><br><br>
                <p><strong>{{ $institution->institution_head }}</strong></p>
            </td>
            <td>
                <p>Kemanggungan, {{ $tanggalAkhirBulan }}</p>
                <p>Guru {{ $kelas->level->name }} {{ $kelas->name }}</p>
                <br><br><br><br>
                <p><strong>{{ $teacher->full_name }}</strong></p>
            </td>
        </tr>
    </table>

</body>

</html>
