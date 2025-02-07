@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Form Input -->
        <div class="col-lg-8">
            <x-card>
                <form id="settingsForm">
                    @csrf
                    <div class="mb-3">
                        <label for="application_name" class="form-label">Nama Aplikasi</label>
                        <input type="text" class="form-control" id="application_name" name="application_name"
                            value="{{ $setting->application_name ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="favicon" class="form-label">Favicon</label>
                        <input type="file" class="form-control" id="favicon" name="favicon">
                        <img src="{{ asset('storage/' . ($setting->favicon ?? 'favicon.png')) }}" alt="Favicon"
                            width="50" class="mt-2">
                    </div>
                    <div class="mb-3">
                        <label for="logo_login" class="form-label">Logo Login</label>
                        <input type="file" class="form-control" id="logo_login" name="logo_login">
                        <img src="{{ asset('storage/' . ($setting->logo_login ?? 'logo_login.png')) }}" alt="Logo Login"
                            width="100" class="mt-2">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </x-card>
        </div>

        <!-- Preview Gambar di Samping Kanan -->
        <div class="col-lg-4">
            <x-card>
                <div class="text-center">
                    <label class="form-label"><strong>Favicon</strong></label>
                    <img class="img-thumbnail" src="{{ Storage::url($setting->favicon ?? 'favicon.png') }}" alt="Favicon"
                        width="100">
                </div>
            </x-card>

            <x-card class="mt-3">
                <div class="text-center">
                    <label class="form-label"><strong>Logo Login</strong></label>
                    <img class="img-thumbnail" src="{{ Storage::url($setting->logo_login ?? 'logo_login.png') }}"
                        alt="Logo Login" width="150">
                </div>
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#settingsForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('settings.store') }}",
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
