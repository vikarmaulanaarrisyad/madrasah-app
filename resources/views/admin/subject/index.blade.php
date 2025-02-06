@extends('layouts.app')

@section('title', 'Daftar Mata Pelajaran')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Mata Pelajaran</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm(`{{ route('subjects.store') }}`)" class="btn btn-sm btn-primary ">
                        <i class="fas fa-plus-circle"></i> Tambah Data
                    </button>
                </x-slot>

                <div class="mb-5 align-items-center">
                    <label for="">Filter Kurikulum</label>
                    <select id="filter-curiculum" class="form-control w-auto">
                        <option value="">Semua</option>
                        @foreach ($curiculums as $curiculum)
                            <option value="{{ $curiculum->id }}">{{ $curiculum->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="table-responsive">
                    <x-table>
                        <x-slot name="thead">
                            <th>No</th>
                            <th>Nama Mapel</th>
                            <th>Kurikulum</th>
                            <th>Kelompok</th>
                            <th>Aksi</th>
                        </x-slot>
                    </x-table>
                </div>
            </x-card>
        </div>
    </div>
    @include('admin.subject.form')
@endsection

@include('includes.datatables')

@push('scripts')
    <script>
        let table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('subjects.data') }}',
                data: function(d) {
                    d.curiculum_id = $('#filter-curiculum').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name'
                },
                {
                    data: 'curiculum.name'
                },
                {
                    data: 'group'
                },
                {
                    data: 'aksi',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#filter-curiculum').change(function() {
            table.ajax.reload();
        });
    </script>

    <script>
        let modal = '#modal-form';
        let statusModal = '#statusModal';
        let button = '#submitBtn';

        function addForm(url, title = 'Tambah Mata Pelajaran') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');

            resetForm(`${modal} form`);
        }

        function editForm(url, title = 'Edit Mata Pelajaran') {
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
    </script>
@endpush
