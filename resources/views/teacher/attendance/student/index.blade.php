@extends('layouts.main')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="section full mt-2">
        <div class="section-title">Title</div>
        <div class="wide-block pt-2 pb-2">
            Daftar Presensi Siswa
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="pt-2 pb-2">
                <ul class="listview image-listview">
                    @foreach ($students as $student)
                        @php
                            $status = optional($student->attendance->first())->status;
                            $badgeClass = 'bg-secondary'; // Default warna

                            if ($status == 'Hadir') {
                                $badgeClass = 'bg-success';
                            } elseif ($status == 'Izin') {
                                $badgeClass = 'bg-warning';
                            } elseif ($status == 'Sakit') {
                                $badgeClass = 'bg-info';
                            } elseif ($status == 'Alpa') {
                                $badgeClass = 'bg-danger';
                            }
                        @endphp

                        <li>
                            <a href="#" class="item" data-bs-toggle="modal"
                                data-bs-target="#modalAbsensi{{ $student->id }}">
                                <img src="{{ Storage::url($student->upload_photo) }}" alt="image" class="image">
                                <div class="in">
                                    <div>{{ $student->full_name }}</div>
                                    <span class="badge {{ $badgeClass }}" id="badge-{{ $student->id }}">
                                        {{ $status ?? 'Belum Absen' }}
                                    </span>
                                </div>
                            </a>
                        </li>

                        <!-- Modal Absensi -->
                        <div class="modal fade" id="modalAbsensi{{ $student->id }}" tabindex="-1"
                            aria-labelledby="modalAbsensiLabel{{ $student->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalAbsensiLabel{{ $student->id }}">
                                            Absensi - {{ $student->full_name }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formAbsensi{{ $student->id }}"
                                            action="{{ route('attandance.student_store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                                            <div class="mb-3">
                                                <label class="form-label">Status Kehadiran</label>
                                                <select class="form-select status-select" name="status" required>
                                                    <option disabled
                                                        {{ !isset($student->attendance->first()->status) ? 'selected' : '' }}>
                                                        Pilih Presensi</option>
                                                    <option value="Hadir"
                                                        {{ isset($student->attendance->first()->status) && $student->attendance->first()->status == 'Hadir' ? 'selected' : '' }}>
                                                        Hadir</option>
                                                    <option value="Izin"
                                                        {{ isset($student->attendance->first()->status) && $student->attendance->first()->status == 'Izin' ? 'selected' : '' }}>
                                                        Izin</option>
                                                    <option value="Sakit"
                                                        {{ isset($student->attendance->first()->status) && $student->attendance->first()->status == 'Sakit' ? 'selected' : '' }}>
                                                        Sakit</option>
                                                    <option value="Alpa"
                                                        {{ isset($student->attendance->first()->status) && $student->attendance->first()->status == 'Alpa' ? 'selected' : '' }}>
                                                        Alpa</option>
                                                </select>

                                            </div>
                                            <button type="button" class="btn btn-primary w-100 btn-submit"
                                                data-id="{{ $student->id }}">
                                                <span class="btn-text">Simpan Absensi</span>
                                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                                    aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal -->
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('css_vendor')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@push('scripts_vendor')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.btn-submit').on('click', function(e) {
                e.preventDefault();

                let btn = $(this);
                let studentId = btn.data('id');
                let formId = "#formAbsensi" + studentId;
                let formData = $(formId).serialize();
                let selectedStatus = $(formId + ' select[name="status"]').val();
                let badge = $("#badge-" + studentId);

                // Mapping warna badge berdasarkan status
                let badgeClasses = {
                    "Hadir": "bg-success",
                    "Izin": "bg-warning",
                    "Sakit": "bg-info",
                    "Alpa": "bg-danger"
                };

                // Ubah tombol jadi loading
                btn.prop('disabled', true);
                btn.find('.btn-text').addClass('d-none');
                btn.find('.spinner-border').removeClass('d-none');

                $.ajax({
                    url: $(formId).attr('action'),
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Presensi berhasil disimpan.',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Update status di tampilan
                        badge.text(selectedStatus);
                        badge.removeClass(
                            "bg-secondary bg-success bg-warning bg-info bg-danger");
                        badge.addClass(badgeClasses[selectedStatus]);

                        // Tutup modal setelah sukses
                        setTimeout(() => {
                            $('#modalAbsensi' + studentId).modal('hide');
                        }, 1000);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan! Coba lagi nanti.',
                        });
                    },
                    complete: function() {
                        // Kembalikan tombol ke keadaan awal
                        btn.prop('disabled', false);
                        btn.find('.btn-text').removeClass('d-none');
                        btn.find('.spinner-border').addClass('d-none');
                    }
                });
            });
        });
    </script>
@endpush
