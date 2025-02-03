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
                    <div class="d-flex flex-wrap justify-content-start">
                        <!-- Tombol Tambah Data -->
                        <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary mb-2 mr-2 ">
                            <i class="fas fa-plus-circle"></i> Tambah Data
                        </a>

                        <!-- Tombol Download Template Excel -->
                        <a href="#" class="btn btn-sm btn-success mb-2 mr-2 ">
                            <i class="fas fa-file-excel"></i> Download Template
                        </a>

                        <!-- Tombol Upload Excel -->
                        <button data-toggle="modal" data-target="#uploadExcelModal"
                            class="btn btn-sm btn-warning mb-2 mr-2 ">
                            <i class="fas fa-upload"></i> Upload Excel
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

@endsection

@include('includes.datatables')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let statusModal = '#statusModal';
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
    </script>
@endpush
