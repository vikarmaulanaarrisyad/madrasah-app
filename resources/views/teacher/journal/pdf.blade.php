<!DOCTYPE html>
<html>

<head>
    <title>Laporan Jurnal Guru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }

        /* Header */
        .kop {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        .kop img {
            width: 100px;
            height: auto;
            position: absolute;
            left: 50px;
            top: 10px;
        }

        .kop h2,
        .kop h3 {
            margin: 0;
            padding: 0;
        }

        .garis {
            border-bottom: 5px double black;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            background-color: #f4f4f4;
            color: black;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        td {
            padding: 8px;
            text-align: left;
        }

        /* Footer */
        .ttd {
            margin-top: 40px;
            width: 100%;
            text-align: right;
        }

        .ttd p {
            margin-bottom: 70px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="kop">
        <img src="{{ public_path('img/logo_sekolah.png') }}" alt="Logo Sekolah">
        <h2>SMK NEGERI 1 TEGAL</h2>
        <h3>Jl. Pendidikan No. 10, Kota Tegal</h3>
        <h3>Telp: (0283) 123456 | Email: smkn1tegal@gmail.com</h3>
    </div>
    <div class="garis"></div>

    <!-- Judul -->
    <h3 style="text-transform: uppercase; text-decoration: underline;">Laporan Jurnal Guru</h3>

    <!-- Tabel Data -->
    <table>
        <tr>
            <th>No</th>
            <th>Nama Guru</th>
            <th>Mata Pelajaran</th>
            <th>Isi Jurnal</th>
            <th>Tanggal</th>
        </tr>
        {{--  @foreach ($jurnals as $index => $jurnal)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $jurnal->guru->nama }}</td>
                <td>{{ $jurnal->mapel->nama }}</td>
                <td>{{ $jurnal->isi_jurnal }}</td>
                <td style="text-align: center;">{{ date('d-m-Y', strtotime($jurnal->tanggal)) }}</td>
            </tr>
        @endforeach  --}}
    </table>

    <!-- Tanda Tangan -->
    <div class="ttd">
        <p>Tegal, {{ date('d F Y') }}</p>
        <p><b>Kepala Sekolah</b></p>
        <p>_________________________</p>
    </div>

</body>

</html>
