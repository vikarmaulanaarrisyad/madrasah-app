@extends('layouts.app')

@section('title', 'Daftar Jurnal Mengajar')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Jurnal Mengajar</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <x-card>
                @if (Auth::user()->hasRole('Guru'))
                    <x-slot name="header">
                        <button onclick="addForm(`{{ route('journals.store') }}`)" class="btn btn-sm btn-primary ">
                            <i class="fas fa-plus-circle"></i> Tambah Data
                        </button>

                    </x-slot>
                @endif

                <div class="table-responsive">
                    <x-table>
                        <x-slot name="thead">
                            <th>No</th>
                            <th>Tanggal</th>
                            @if (Auth::user()->hasRole('Admin'))
                                <th>Nama Guru</th>
                            @endif
                            <th>Rombel</th>
                            <th>Mata Pelajaran</th>
                            <th>KD/CP</th>
                            <th>Materi</th>
                            <th>Catatan</th>
                            @if (Auth::user()->hasRole('Guru'))
                                <th>Aksi</th>
                            @endif
                        </x-slot>
                    </x-table>
                </div>
            </x-card>
        </div>
    </div>
    @include('admin.teaching-journal.form')
@endsection

@include('includes.datatables')
@include('includes.datepicker')
@include('includes.select2')

@push('css')
    <style>
        .table td,
        .table th {
            white-space: normal !important;
            word-wrap: break-word !important;
            max-width: 100px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk Learning Activity (Rombel)
            $('#learning_activity_id').select2({
                ajax: {
                    url: '{{ route('journals.get_learning_activity') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term || ''
                        }; // Pencarian berdasarkan input
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.level_name + ' - ' + item
                                        .name, // Format tampilan
                                    curiculum_id: item.curiculum_id // Simpan curiculum_id
                                };
                            })
                        };
                    },
                    cache: true
                },
                placeholder: "Pilih Rombel",
                allowClear: true,
            }).on('select2:select', function(e) {
                let data = e.params.data;
                let curiculumId = data.curiculum_id;

                if (curiculumId) {
                    $('#subject_id').prop('disabled', false);
                    getSubjectsByCuriculum(curiculumId);
                } else {
                    $('#subject_id').prop('disabled', true).val(null).trigger('change');
                }
            });

            // Inisialisasi Select2 untuk Subject (Mata Pelajaran)
            function getSubjectsByCuriculum(curiculumId) {
                $('#subject_id').select2({
                    ajax: {
                        url: '{{ route('journals.get_subject') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                curiculum_id: curiculumId,
                                search: params.term || '' // Kirim parameter pencarian
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item.id,
                                        text: item.name
                                    };
                                })
                            };
                        },
                        cache: true
                    },
                    placeholder: "Pilih Mata Pelajaran",
                    allowClear: true
                });
            }
        });
    </script>

    <script>
        let table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('journals.data') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'date'
                },
                @if (Auth::user()->hasRole('Admin'))
                    {
                        data: 'teacher.full_name'
                    },
                @endif {
                    data: 'learning_activity'
                },
                {
                    data: 'subject.name',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'cp',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'material',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'notes',
                    orderable: false,
                    searchable: false
                },
                @if (Auth::user()->hasRole('Guru'))
                    {
                        data: 'aksi',
                        orderable: false,
                        searchable: false
                    },
                @endif
            ]
        });
    </script>

    <script>
        let modal = '#modal-form';
        let statusModal = '#statusModal';
        let button = '#submitBtn';

        function addForm(url, title = 'Tambah Jurnal Mengajar') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');

            resetForm(`${modal} form`);
        }

        function editForm(url, title = 'Edit Jurnal Mengajar') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('put');

                    resetForm(`${modal} form`);
                    loopForm(response.data);

                    var optionText1 = response.data.learning_activity.level.name + ' - ' + response.data
                        .learning_activity.name;
                    var option1 = new Option(optionText1, response.data.learning_activity.id, true, true);

                    $('#learning_activity_id').append(option1).trigger('change');

                    var optionText2 = response.data.subject.name;
                    var option2 = new Option(optionText2, response.data.subject.id, true, true);

                    $('#subject_id').append(option2).trigger('change');
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

        function deleteData(url, name) {
            Swal.fire({
                title: 'Hapus Data!',
                text: 'Apakah Anda yakin ingin menghapus ' + name + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false,
                            });
                            table.ajax.reload(); // Refresh tabel
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: xhr.responseJSON?.message || 'Terjadi kesalahan.',
                            });
                        }
                    });
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
