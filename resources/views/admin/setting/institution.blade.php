@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Form Input -->
        <div class="col-lg-8">
            <x-card>
                <form id="institutionForm">
                    @csrf
                    <input type="hidden" id="id" name="id"> {{-- Hidden ID untuk update --}}

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Madrasah</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $institution->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="institution_head" class="form-label">Kepala Madrasah</label>
                        <input type="text" class="form-control" id="institution_head" name="institution_head"
                            value="{{ $institution->institution_head }}">
                    </div>
                    <div class="mb-3">
                        <label for="institution_status" class="form-label">Status</label>
                        <input type="text" class="form-control" id="institution_status" name="institution_status"
                            value="{{ $institution->institution_status }}">
                    </div>
                    <div class="mb-3">
                        <label for="npsn" class="form-label">NPSN</label>
                        <input type="text" class="form-control" id="npsn" name="npsn"
                            value="{{ $institution->npsn }}">
                    </div>
                    <div class="mb-3">
                        <label for="nsm" class="form-label">NSM</label>
                        <input type="text" class="form-control" id="nsm" name="nsm"
                            value="{{ $institution->nsm }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#institutionForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                Swal.fire({
                    title: "Menyimpan...",
                    text: "Mohon tunggu sebentar.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('institution.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.message,
                            icon: "success"
                        }).then(() => location.reload()); // Refresh halaman setelah sukses
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: xhr.responseJSON.message,
                            icon: "error"
                        });
                    }
                });
            });
        });
    </script>
@endpush
