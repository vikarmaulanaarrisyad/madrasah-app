@extends('layouts.app')

@section('title', 'Cetak Presensi Siswa')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Cetak Presensi Siswa</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <select id="filtermonth" class="form-control w-100">
                        <option value="">-- Pilih Bulan --</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                    <button id="downloadPdf" class="btn btn-danger mt-2 btn-sm w-100">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </button>
                </x-slot>
                <div id="presensiTableContainer" class="mt-4"></div>
            </x-card>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#filtermonth').change(function() {
                let selectedMonth = $(this).val();

                if (!selectedMonth) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Bulan!',
                        text: 'Silakan pilih bulan terlebih dahulu.',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Memuat Data...',
                    text: 'Silakan tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('presensi.filter') }}",
                    type: "GET",
                    data: {
                        bulan: selectedMonth
                    },
                    success: function(response) {
                        Swal.close();

                        if (response.data && Object.keys(response.data).length > 0) {
                            renderTable(response.data, response.namaBulan, response.count);
                        } else {
                            Swal.fire({
                                icon: 'info',
                                title: 'Tidak Ada Data!',
                                text: 'Tidak ditemukan data presensi untuk bulan ini.',
                            });
                            $('#presensiTableContainer').html("");
                        }
                    },
                    error: function() {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            text: 'Gagal mengambil data, coba lagi.',
                        });
                    }
                });
            });

            function renderTable(data, namaBulan, jumlahHari) {
                let tableHtml = `
    <div class="table-responsive">
        <h5 class="text-center">Presensi Bulan ${namaBulan}</h5>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nama Siswa</th>`;

                // Buat header tanggal (1 - jumlahHari dalam bulan)
                for (let i = 1; i <= jumlahHari; i++) {
                    tableHtml += `<th>${i}</th>`;
                }

                // Tambahkan header rekapitulasi total (H, I, S, A)
                tableHtml += `<th>H</th><th>I</th><th>S</th><th>A</th></tr></thead><tbody>`;

                // Isi data siswa dan hitung jumlah H, I, S, A
                for (let namaSiswa in data) {
                    let hadir = 0,
                        izin = 0,
                        sakit = 0,
                        alpha = 0;

                    tableHtml += `<tr><td>${namaSiswa}</td>`;

                    for (let i = 1; i <= jumlahHari; i++) {
                        let status = data[namaSiswa][i] || '-';

                        // Hitung jumlah kehadiran
                        if (status === 'H') hadir++;
                        else if (status === 'I') izin++;
                        else if (status === 'S') sakit++;
                        else if (status === 'A') alpha++;

                        tableHtml += `<td>${status}</td>`;
                    }

                    // Tambahkan kolom rekapitulasi di akhir baris
                    tableHtml += `<td>${hadir}</td><td>${izin}</td><td>${sakit}</td><td>${alpha}</td></tr>`;
                }

                tableHtml += `</tbody></table></div>`;

                $('#presensiTableContainer').html(tableHtml);
            }


            $('#downloadPdf').click(function() {
                let selectedMonth = $('#filtermonth').val();

                if (!selectedMonth) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Bulan!',
                        text: 'Silakan pilih bulan terlebih dahulu sebelum mendownload PDF.',
                    });
                    return;
                }

                window.location.href = "{{ route('presensi.download') }}?bulan=" + selectedMonth;
            });
        });
    </script>
@endpush
