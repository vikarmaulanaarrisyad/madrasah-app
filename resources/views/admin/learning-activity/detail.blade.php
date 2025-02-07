@extends('layouts.app')

@section('title', 'Detail Rombongan Belajar')

@section('subtitle', 'Detail Rombongan Belajar')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Detail Rombongan Belajar</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    Detail Rombongan Belajar
                    @if (Auth::user()->hasRole('Admin'))
                        <a href="{{ route('rombel.edit', $learningActivity->id) }}"
                            class="btn btn-sm btn-primary float-right"><i class="fas fa-pencil-alt"></i> Edit Rombel</a>
                    @endif

                </x-slot>
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Tahun Pelajaran</span>
                                <span class="info-box-number text-center text-muted mb-0">
                                    {{ $learningActivity->academicYear->name }}
                                    {{ $learningActivity->academicYear->semester }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Wali Kelas</span>
                                <span class="info-box-number text-center text-muted mb-0">
                                    {{ $learningActivity->teacher->full_name }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Tingkat Kelas</span>
                                <span class="info-box-number text-center text-muted mb-0">
                                    {{ $learningActivity->level->name }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Nama Rombel</span>
                                <span class="info-box-number text-center text-muted mb-0">
                                    {{ $learningActivity->name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Garis Pemisah -->
                <hr>

                {{--  <!-- Header Daftar Siswa dengan Button Tambah -->
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mt-4">Daftar Siswa</h5>
                    <a href="{{ route('students.create', $learningActivity->id) }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Siswa
                    </a>
                </div>  --}}

                <!-- Tabel Daftar Siswa -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>NISN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($learningActivity->students as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->full_name }}</td>
                                    <td>{{ $student->nisn }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
@endsection
