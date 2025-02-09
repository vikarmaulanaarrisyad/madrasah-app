@extends('layouts.app')

@section('title', 'Presensi Rombel')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3>Presensi untuk Rombel: {{ $learningActivity->name }}</h3>

            <form id="attendance-form">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="academic_year_id">Tahun Ajaran</label>
                            <select name="academic_year_id" id="academic_year_id" class="form-control">
                                @foreach ($academicYears as $academicYear)
                                    <option value="{{ $academicYear->id }}"
                                        {{ old('academic_year_id') == $academicYear->id ? 'selected' : '' }}>
                                        {{ $academicYear->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="attendance_date">Pilih Tanggal</label>
                            <div class="input-group datepicker" id="attendance_date" data-target-input="nearest">
                                <input type="text" name="attendance_date" class="form-control datetimepicker-input"
                                    data-target="#attendance_date" data-toggle="datetimepicker" autocomplete="off"
                                    placeholder="Masukkan tanggal" value="{{ $date }}" />
                                <div class="input-group-append" data-target="#attendance_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Status Presensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($learningActivity->students as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $student->full_name }}</td>
                                        <td>
                                            <select name="attendance[{{ $student->id }}]" class="form-control">
                                                <option value=""
                                                    {{ !isset($attendances[$student->id]) ? 'selected' : '' }}>Pilih Absensi
                                                </option>
                                                <option value="Hadir"
                                                    {{ isset($attendances[$student->id]) && $attendances[$student->id]->status == 'Hadir' ? 'selected' : '' }}>
                                                    Hadir</option>
                                                <option value="Alpa"
                                                    {{ isset($attendances[$student->id]) && $attendances[$student->id]->status == 'Alpa' ? 'selected' : '' }}>
                                                    Alpa</option>
                                                <option value="Sakit"
                                                    {{ isset($attendances[$student->id]) && $attendances[$student->id]->status == 'Sakit' ? 'selected' : '' }}>
                                                    Sakit</option>
                                                <option value="Izin"
                                                    {{ isset($attendances[$student->id]) && $attendances[$student->id]->status == 'Izin' ? 'selected' : '' }}>
                                                    Izin</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan Presensi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@include('includes.datepicker')

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#attendance-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('attendance.store', $learningActivity->id) }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Presensi berhasil!',
                                text: response.message
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan!',
                            text: 'Terjadi kesalahan saat menyimpan data presensi.'
                        });
                    }
                });
            });

            // Handle date change for attendance filtering
            $('#attendance_date').on('change.datetimepicker', function() {
                let date = $(this).find('input').val();
                let academicYearId = $('#academic_year_id').val();
                let learningActivityId = '{{ $learningActivity->id }}';

                if (!date) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tanggal kosong!',
                        text: 'Silakan pilih tanggal terlebih dahulu.'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Loading...',
                    text: 'Sedang memuat data presensi...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });



                $.ajax({
                    url: '{{ route('attendance.filterAttendance') }}',
                    type: 'GET',
                    data: {
                        date: date,
                        academic_year_id: academicYearId,
                        learningActivity: learningActivityId
                    },
                    success: function(response) {
                        Swal.close();
                        var tbody = '';
                        $.each(response.students, function(index, student) {
                            var attendanceStatus = response.attendances[student.id] ?
                                response.attendances[student.id].status : '';
                            tbody += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${student.full_name}</td>
                                    <td>
                                        <select name="attendance[${student.id}]" class="form-control">
                                            <option value="" ${attendanceStatus == '' ? 'selected' : ''}>Pilih Absensi</option>
                                            <option value="Hadir" ${attendanceStatus == 'Hadir' ? 'selected' : ''}>Hadir</option>
                                            <option value="Alpa" ${attendanceStatus == 'Alpa' ? 'selected' : ''}>Alpa</option>
                                            <option value="Sakit" ${attendanceStatus == 'Sakit' ? 'selected' : ''}>Sakit</option>
                                            <option value="Izin" ${attendanceStatus == 'Izin' ? 'selected' : ''}>Izin</option>
                                        </select>
                                    </td>
                                </tr>
                            `;
                        });

                        $('tbody').html(tbody);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat mengambil data presensi.'
                        });
                    }
                });
            });
        });
    </script>
@endpush
