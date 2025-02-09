@extends('layouts.app')

@section('title', 'Daftar Guru')

@section('subtitle', 'Daftar Guru')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Guru</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm(`{{ route('teachers.store') }}`)" class="btn btn-sm btn-primary"><i
                            class="fas fa-plus-circle"></i> Tambah Data</button>

                    <button onclick="exportExcel()" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>

                    <button class="btn btn-sm btn-warning">
                        <i class="fas fa-upload"></i> Import Excel
                    </button>
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
    @include('admin.teacher.form')
@endsection

@include('includes.datatables')
@include('includes.datepicker')

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
                url: '{{ route('teachers.data') }}'
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
                    data: 'brith_place'
                },
                {
                    data: 'birth_date'
                },
                {
                    data: 'm_gender_id'
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

    <script>
        function addForm(url, title = 'Tambah Guru') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');

            resetForm(`${modal} form`);
        }

        function editForm(url, title = 'Edit Guru') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('put');

                    resetForm(`${modal} form`);
                    loopForm(response.data);

                    // Menampilkan username dan email jika ada
                    $(`${modal} [name=username]`).val(response.data.user.username);
                    $(`${modal} [name=email]`).val(response.data.user.email);
                })
                .fail(errors => {
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide();
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors);
                    }
                });
        }

        function submitForm(originalForm) {
            $(button).prop('disabled', true);
            $('#spinner-border').show();

            $.ajax({
                type: 'POST',
                url: $(originalForm).attr('action'),
                data: new FormData(originalForm),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'Menyimpan data...',
                        text: 'Mohon tunggu sebentar.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    Swal.close();
                    $(modal).modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 3000
                    }).then(() => {
                        $(button).prop('disabled', false);
                        $('#spinner-border').hide();
                        table.ajax.reload();
                    });
                },
                error: function(errors) {
                    Swal.close();
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops! Gagal',
                        text: errors.responseJSON?.message || 'Terjadi kesalahan!',
                        showConfirmButton: true,
                    });

                    if (errors.status === 422) {
                        loopErrors(errors.responseJSON.errors);
                    }
                }
            });

        }

        function updateStatus(id) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Status akan diperbarui!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, ubah!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/academicyears/${id}/update-status`,
                        type: "PUT",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                }).then(() => {
                                    table.ajax.reload();
                                })
                            }
                        },
                        error: function(xhr) {
                            // Menampilkan pesan error
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal',
                                text: xhr.responseJSON.message,
                                showConfirmButton: true,
                            });
                        }
                    });
                }
            });
        }

        function exportExcel() {
            Swal.fire({
                title: 'Export Data?',
                text: "Apakah Anda ingin mengunduh data guru dalam format Excel?",
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
                        window.location.href = "{{ route('teachers.export_excel') }}";
                        Swal.close();
                    }, 1000); // Delay 1 detik agar efek loading terlihat
                }
            });
        }
    </script>
@endpush
