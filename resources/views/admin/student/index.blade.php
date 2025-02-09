@extends('layouts.app')

@section('title', 'Daftar Siswa')

@section('subtitle', 'Daftar Siswa')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Siswa</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <div class="">
                        <!-- Tombol Tambah Data -->
                        <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus-circle"></i> Tambah Data
                        </a>

                        <button onclick="exportExcel()" class="btn btn-sm btn-success">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>

                        <button onclick="importExcel()" class="btn btn-sm btn-warning">
                            <i class="fas fa-upload"></i> Import Excel
                        </button>
                    </div>

                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('admin.student.import-modal')
@endsection

@include('includes.datatables')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let statusModal = '#statusModal';
        let modalImport = '#importExcelModal'
        let button = '#submitBtn';

        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('students.data') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'full_name'
                },
                {
                    data: 'birth_place'
                },
                {
                    data: 'birth_date'
                },
                {
                    data: 'gender.name'
                },

                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
            ]
        })

        function exportExcel() {
            Swal.fire({
                title: 'Export Data?',
                text: "Apakah Anda ingin mengunduh data siswa dalam format Excel?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Export!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sedang Memproses...',
                        text: 'Mohon tunggu, file sedang diproses.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Tunggu sebentar sebelum mengalihkan ke halaman export
                    setTimeout(() => {
                        window.location.href = "{{ route('students.export_excel') }}";
                        Swal.close();
                    }, 1000); // Delay 1 detik agar efek loading terlihat
                }
            });
        }

        function importExcel() {
            $(modalImport).modal('show');
        }
    </script>
@endpush
