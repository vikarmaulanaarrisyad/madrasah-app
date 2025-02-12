@extends('layouts.main')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right">
            <a href="javascript:" onclick="addForm(`{{ route('journals.store') }}`)" class="headerButton"
                data-bs-toggle="modal" data-bs-target="#addJournalModal">
                <ion-icon name="add-outline"></ion-icon>
            </a>
        </div>
    </div>
@endsection

@include('includes.select2')

@section('content')
    <div class="section full mt-2">
        <div class="section-title">Daftar Jurnal Mengajar</div>
        <div class="wide-block pt-2 pb-2 text-center">
            Daftar Jurnal Mengajar
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="pt-2 pb-2">
                <ul class="list-group">
                    @foreach ($journals as $journal)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                {{--  <span onclick="editForm('{{ route('journals.show', $journal->id) }}')"
                                    class="badge bg-info flex-grow-1">{{ $journal->subject->name }}</span>  --}}
                                <span onclick="editForm('{{ route('journals.show', $journal->id) }}')"
                                    class="badge bg-info flex-grow-1 p-2"
                                    style="word-wrap: break-word;padding:3px 2px !important; white-space: normal;">
                                    {{ $journal->subject->name }}
                                </span>

                                <span class="badge bg-primary mx-3">
                                    {{ \Carbon\Carbon::parse($journal->date)->format('d-m-Y') }}
                                </span>
                                <button onclick="deleteJournal('{{ route('journals.destroy', $journal->id) }}')"
                                    class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </div>
                            <small class="text-muted d-block mt-1">{{ $journal->material }}</small>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Jurnal -->
    <div class="modal fade" id="addJournalModal" tabindex="-1" aria-labelledby="addJournalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addJournalModalLabel">Tambah Jurnal Mengajar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="journalForm" action="{{ route('journals.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="date">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="date" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="learning_activity_id">Rombel <span class="text-danger">*</span></label>
                            <select name="learning_activity_id" id="learning_activity_id"
                                class="form-control select2"></select>
                        </div>

                        <div class="form-group">
                            <label for="subject_id">Mata Pelajaran <span class="text-danger">*</span></label>
                            <select name="subject_id" id="subject_id" class="form-control select2"></select>
                        </div>

                        <div class="form-group">
                            <label for="cp">KD/CP</label>
                            <textarea name="cp" id="cp" cols="5" rows="2" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="material">Materi</label>
                            <textarea name="material" id="material" cols="5" rows="2" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="task">Tugas</label>
                            <textarea name="task" id="task" cols="5" rows="2" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="notes">Catatan</label>
                            <textarea name="notes" id="notes" cols="5" rows="2" class="form-control"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-times"></i>
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

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
        $(document).ready(function() {
            $('#journalForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = form.serialize();
                let url = form.attr('action');
                let method = form.find('input[name="_method"]').val() || 'POST';

                Swal.fire({
                    title: 'Menyimpan data...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message || 'Data berhasil disimpan!',
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops! Gagal',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan',
                        });
                    }
                });
            });
        });

        function addForm(url, title = 'Tambah Jurnal Mengajar') {
            let modal = '#addJournalModal';
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');

            resetForm(`${modal} form`);
        }

        function editForm(url) {
            Swal.fire({
                title: 'Menunggu...',
                text: 'Sedang mengambil data, mohon tunggu',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.get(url)
                .done(response => {
                    Swal.close(); // Tutup loading saat data berhasil diambil

                    let modal = '#addJournalModal';

                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text('Edit Jurnal Mengajar');
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} form`).append('<input type="hidden" name="_method" value="PUT">');

                    $(`${modal} form`)[0].reset();

                    $('#date').val(response.data.date);
                    $('#material').val(response.data.material);
                    $('#cp').val(response.data.cp);
                    $('#task').val(response.data.task);
                    $('#notes').val(response.data.notes);

                    $('#learning_activity_id').empty().append(new Option(
                        response.data.learning_activity.level.name + ' - ' + response.data.learning_activity
                        .name,
                        response.data.learning_activity.id,
                        true, true
                    )).trigger('change');

                    $('#subject_id').empty().append(new Option(
                        response.data.subject.name,
                        response.data.subject.id,
                        true, true
                    )).trigger('change');
                })
                .fail(errors => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops! Gagal',
                        text: errors.responseJSON?.message || 'Terjadi kesalahan',
                    });
                });
        }

        function deleteJournal(id, url) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data jurnal ini akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            _method: "DELETE",
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: response.message || "Jurnal berhasil dihapus!",
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops! Gagal",
                                text: xhr.responseJSON?.message ||
                                    "Terjadi kesalahan saat menghapus!",
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush
