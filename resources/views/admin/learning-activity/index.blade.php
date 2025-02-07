@extends('layouts.app')

@section('title', 'Daftar Rombel')

@section('subtitle', 'Daftar Rombel')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Rombel</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                @if (Auth::user()->hasRole('Admin'))
                    <x-slot name="header">
                        <button onclick="addForm(`{{ route('rombel.store') }}`)" class="btn btn-sm btn-primary"><i
                                class="fas fa-plus-circle"></i> Tambah Data</button>
                    </x-slot>
                @endif
                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Nama Rombel</th>
                        <th>Tingkat</th>
                        <th>Wali Kelas</th>
                        <th>Kurikulum</th>
                        <th>Jumlah Siswa</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('admin.learning-activity.form')
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
                url: '{{ route('rombel.data') }}'
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
                    data: 'level.level'
                },
                {
                    data: 'teacher_id'
                },
                {
                    data: 'curiculum_id'
                },
                {
                    data: 'number_of_student'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
            ]
        })

        function addForm(url, title = 'Tambah Rombel') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');

            resetForm(`${modal} form`);
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
    </script>
@endpush
