@extends('layouts.app')

@section('title', 'Daftar Tahun Pelajaran')

{{--  @section('subtitle', 'Daftar Tahun Pelajaran')  --}}

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Tahun Pelajaran</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    Daftar Tahun Pelajaran

                    <button onclick="addForm(`{{ route('academicyears.store') }}`)"
                        class="btn btn-sm btn-primary float-right"><i class="fas fa-plus-circle"></i> Tambah Data</button>
                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Tahun Pelajaran</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('admin.academic-year.form')
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
                url: '{{ route('academicyears.data') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name'
                },
                {
                    data: 'semester'
                },
                {
                    data: 'status'
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
        function addForm(url, title = 'Tambah Tahun Pelajaran') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');

            resetForm(`${modal} form`);
        }

        function editForm(url, title = 'Edit Tahun Pelajaran') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('put');

                    resetForm(`${modal} form`);
                    loopForm(response.data);
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

            $.post({
                    url: $(originalForm).attr('action'),
                    data: new FormData(originalForm),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(response => {
                    $(modal).modal('hide');
                    if (response.status = 200) {
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
                        })
                    }
                })
                .fail(errors => {
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide()
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors);
                        return;
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
    </script>
@endpush
