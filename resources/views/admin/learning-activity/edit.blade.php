@extends('layouts.app')

@section('title', 'Edit Rombongan Belajar')

@section('subtitle', 'Edit Rombongan Belajar')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Edit Rombongan Belajar</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form id="updateForm" action="{{ route('rombel.update', $learningActivity->id) }}" method="POST">
                @csrf
                @method('PUT')

                <x-card>
                    <x-slot name="header">
                        Edit Rombongan Belajar
                    </x-slot>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $learningActivity->name }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="teacher_id" class="form-label">Guru</label>
                                <select name="teacher_id" id="teacher_id" class="form-control" required>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                            {{ isset($learningActivity->teacher_id) && $learningActivity->teacher_id == $teacher->id ? 'selected' : '' }}>
                                            {{ $learningActivity->teacher->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Menampilkan Siswa yang Terdaftar -->
                    <div class="form-group">
                        <label for="students" class="form-label">Siswa yang Terdaftar</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($learningActivity->students as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $student->full_name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-student"
                                                data-student-id="{{ $student->id }}"
                                                data-learning-activity-id="{{ $learningActivity->id }}">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada siswa yang terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addStudentModal">
                            Tambah Siswa
                        </button>
                    </div>
                    <x-slot name="footer">
                        <button type="submit" class="btn btn-primary float-right">Simpan</button>
                    </x-slot>
                </x-card>
            </form>
        </div>
    </div>

    <!-- Modal for Adding Student -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Tambah Siswa ke Rombel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addStudentForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="student_id" class="form-label">Pilih Siswa</label>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Pilih</th>
                                        <th>Nama Siswa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="student_id[]" value="{{ $student->id }}">
                                            </td>
                                            <td>{{ $student->full_name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $("#updateForm").on("submit", function(e) {
                e.preventDefault();

                let form = $(this);
                let url = form.attr("action");
                let formData = form.serialize();

                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: url,
                    type: "PUT",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: response.message || "Data berhasil diperbarui.",
                        }).then(function() {
                            location.reload(); // Reload page to update the list
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: xhr.responseJSON.message || "Terjadi kesalahan."
                        });
                    }
                });
            });

            // Handle add student form submission
            $("#addStudentForm").on("submit", function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = form.serialize();

                $.ajax({
                    url: "{{ route('rombel.addStudent', $learningActivity->id) }}", // Adjust this route as needed
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Siswa berhasil ditambahkan!",
                            text: response.message ||
                                "Siswa berhasil ditambahkan ke rombel."
                        }).then(function() {
                            location.reload(); // Reload page to update the list
                        });
                        $('#addStudentModal').modal('hide');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: xhr.responseJSON.message ||
                                "Terjadi kesalahan saat menambahkan siswa."
                        }).then(function() {
                            location.reload(); // Reload page to update the list
                        });
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Handle remove student using AJAX
            $(document).on('click', '.remove-student', function() {
                let studentId = $(this).data('student-id');
                let learningActivityId = $(this).data('learning-activity-id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Siswa ini akan dihapus dari rombongan belajar.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // AJAX request to remove student
                        $.ajax({
                            url: `/rombel/${learningActivityId}/removeStudent/${studentId}`, // Make sure this is the correct route
                            type: "DELETE", // Ensure DELETE method is used
                            data: {
                                _token: '{{ csrf_token() }}', // Include CSRF token for security
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Siswa berhasil dihapus!',
                                    text: response.message ||
                                        'Siswa telah berhasil dihapus dari rombongan belajar.',
                                }).then(function() {
                                    location
                                        .reload(); // Reload page to update the list
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: xhr.responseJSON.message ||
                                        'Terjadi kesalahan saat menghapus siswa.',
                                });
                            }
                        });

                    }
                });
            });
        });
    </script>
@endpush
