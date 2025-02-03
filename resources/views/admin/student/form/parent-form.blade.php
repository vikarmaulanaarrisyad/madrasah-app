<form id="parentForm" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="student_id" value="{{ $student->id }}">

    <div class="row">
        <div class="col-lg-5">
            <div class="form-group">
                <label for="father_m_life_status_id">Status Kehidupan Ayah</label>
                <select name="father_m_life_status_id" id="father_m_life_status_id" class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($lifeStatus as $item => $id)
                        <option value="{{ $id }}"
                            {{ $parent->father_m_life_status_id == $id ? 'selected' : '' }}>
                            {{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="form-group">
                <label for="father_full_name">Nama Lengkap Ayah</label>
                <input id="father_full_name" class="form-control" type="text" name="father_full_name"
                    value="{{ old('father_full_name', $parent->father_full_name) }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="father_nik">NIK Ayah</label>
                <input value="{{ old('father_nik', $parent->father_nik) }}" id="father_nik" class="form-control"
                    type="text" name="father_nik">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="father_birth_place">Tempat Lahir Ayah</label>
                <input value="{{ old('father_birth_place', $parent->father_birth_place) }}" id="father_birth_place"
                    class="form-control" type="text" name="father_birth_place">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="father_birth_date">Tanggal Lahir <span class="text-danger">*</span></label>
                <div class="input-group datepicker" id="father_birth_date" data-target-input="nearest">
                    <input value="{{ old('father_birth_date', $parent->father_birth_date) }}" type="text"
                        name="father_birth_date" class="form-control datetimepicker-input"
                        data-target="#father_birth_date" data-toggle="datetimepicker" autocomplete="off"
                        placeholder="Masukkan tanggal lahir" value="{{ old('father_birth_date') }}" />
                    <div class="input-group-append" data-target="#father_birth_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="father_m_last_education_id">Pendidikan Terakhir Ayah</label>
                <select name="father_m_last_education_id" id="father_m_last_education_id" class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($educations as $item => $id)
                        <option value="{{ $id }}"
                            {{ $parent->father_m_last_education_id == $id ? 'selected' : '' }}>
                            {{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="father_m_job_id">Pekerjaan Ayah</label>
                <select name="father_m_job_id" id="father_m_job_id" class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($jobs as $item => $id)
                        <option value="{{ $id }}" {{ $parent->father_m_job_id == $id ? 'selected' : '' }}>
                            {{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="father_m_average_income_per_month_id">Pendapatan Ayah</label>
                <select name="father_m_average_income_per_month_id" id="father_m_average_income_per_month_id"
                    class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($averageIncome as $item => $id)
                        <option value="{{ $id }}"
                            {{ $parent->father_m_average_income_per_month_id == $id ? 'selected' : '' }}>
                            {{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="father_phone_number">Nomor Telepon Ayah</label>
                <input id="father_phone_number" class="form-control" type="text" name="father_phone_number"
                    value="{{ old('father_phone_number', $parent->father_phone_number) }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="father_rt">RT Ayah</label>
                <input id="father_rt" class="form-control" type="text" name="father_rt"
                    value="{{ $parent->father_rt }}">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="father_rw">RW Ayah</label>
                <input id="father_rw" class="form-control" type="text" name="father_rw"
                    value="{{ $parent->father_rw }}">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="father_postal_code">Kode Pos Ayah</label>
                <input id="father_postal_code" class="form-control" type="number" name="father_postal_code"
                    value="{{ old('father_postal_code', $parent->father_postal_code) }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="father_address">Alamat Ayah</label>
                <textarea id="father_address" class="form-control" name="father_address">{{ $parent->father_address }}</textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="father_kk_file" class="form-label">Upload File KK Ayah</label>
                <input type="file" id="father_kk_file" name="father_kk_file" class="form-control"
                    accept="image/*" onchange="previewGambar(event)">
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-5">
            <div class="form-group">
                <label for="mother_m_life_status_id">Status Kehidupan Ibu</label>
                <select name="mother_m_life_status_id" id="mother_m_life_status_id" class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($lifeStatus as $item => $id)
                        <option value="{{ $id }}"
                            {{ $parent->mother_m_life_status_id == $id ? 'selected' : '' }}>
                            {{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="form-group">
                <label for="mother_full_name">Nama Lengkap Ibu</label>
                <input id="mother_full_name" class="form-control" type="text" name="mother_full_name"
                    value="{{ $parent->mother_full_name }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="mother_nik">NIK Ibu</label>
                <input id="mother_nik" class="form-control" type="text" name="mother_nik"
                    value="{{ $parent->mother_nik }}">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="mother_birth_place">Tempat Lahir Ibu</label>
                <input id="mother_birth_place" class="form-control" type="text" name="mother_birth_place"
                    value="{{ $parent->mother_birth_place }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="mother_birth_date">Tanggal Lahir <span class="text-danger">*</span></label>
                <div class="input-group datepicker" id="mother_birth_date" data-target-input="nearest">
                    <input type="text" name="mother_birth_date" class="form-control datetimepicker-input"
                        data-target="#mother_birth_date" data-toggle="datetimepicker" autocomplete="off"
                        placeholder="Masukkan tanggal lahir"
                        value="{{ old('mother_birth_date', $parent->mother_birth_date) }}" />
                    <div class="input-group-append" data-target="#mother_birth_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="mother_m_last_education_id">Pendidikan Terakhir Ibu</label>
                <select name="mother_m_last_education_id" id="mother_m_last_education_id" class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($educations as $item => $id)
                        <option value="{{ $id }}"
                            {{ $parent->mother_m_last_education_id == $id ? 'selected' : '' }}>
                            {{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="mother_m_job_id">Pekerjaan Ibu</label>
                <select name="mother_m_job_id" id="mother_m_job_id" class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($jobs as $item => $id)
                        <option value="{{ $id }}" {{ $parent->mother_m_job_id == $id ? 'selected' : '' }}>
                            {{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="mother_m_average_income_per_month_id">Pendapatan Ibu</label>
                <select name="mother_m_average_income_per_month_id" id="mother_m_average_income_per_month_id"
                    class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($averageIncome as $item => $id)
                        <option value="{{ $id }}"
                            {{ $parent->mother_m_average_income_per_month_id == $id ? 'selected' : '' }}>
                            {{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="mother_phone_number">Nomor Telepon Ibu</label>
                <input id="mother_phone_number" class="form-control" type="text" name="mother_phone_number"
                    value="{{ $parent->mother_phone_number }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="mother_rt">RT Ibu</label>
                <input id="mother_rt" class="form-control" type="text" name="mother_rt"
                    value="{{ $parent->mother_rt }}">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="mother_rw">RW Ibu</label>
                <input id="mother_rw" class="form-control" type="text" name="mother_rw"
                    value="{{ $parent->mother_rw }}">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="mother_postal_code">Kode Pos Ibu</label>
                <input id="mother_postal_code" class="form-control" type="number" name="mother_postal_code"
                    value="{{ $parent->mother_postal_code }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="mother_address">Alamat Ibu</label>
                <textarea id="mother_address" class="form-control" name="mother_address">{{ $parent->mother_address }}</textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="mother_kk_file" class="form-label">Upload File KK Ibu</label>
                <input type="file" id="mother_kk_file" name="mother_kk_file" class="form-control"
                    accept="image/*" onchange="previewGambar(event)">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="form-group">
                <label for="wali_m_life_status_id">Status Kehidupan Wali</label>
                <select name="wali_m_life_status_id" id="wali_m_life_status_id" class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($lifeStatus as $item => $id)
                        <option value="{{ $id }}"
                            {{ $parent->wali_m_life_status_id == $id ? 'selected' : '' }}>
                            {{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="form-group">
                <label for="wali_full_name">Nama Lengkap Wali</label>
                <input id="wali_full_name" class="form-control" type="text" name="wali_full_name"
                    value="{{ $parent->wali_full_name }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="wali_nik">NIK Wali</label>
                <input id="wali_nik" class="form-control" type="text" name="wali_nik"
                    value="{{ $parent->wali_nik }}">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="wali_birth_place">Tempat Lahir Wali</label>
                <input id="wali_birth_place" class="form-control" type="text" name="wali_birth_place"
                    value="{{ $parent->wali_birth_place }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="wali_birth_date">Tanggal Lahir <span class="text-danger">*</span></label>
                <div class="input-group datepicker" id="wali_birth_date" data-target-input="nearest">
                    <input type="text" name="wali_birth_date" class="form-control datetimepicker-input"
                        data-target="#wali_birth_date" data-toggle="datetimepicker" autocomplete="off"
                        placeholder="Masukkan tanggal lahir"
                        value="{{ old('wali_birth_date', $parent->wali_birth_date) }}" />
                    <div class="input-group-append" data-target="#wali_birth_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="wali_m_last_education_id">Pendidikan Terakhir Wali</label>
                <select name="wali_m_last_education_id" id="wali_m_last_education_id" class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($educations as $item => $id)
                        <option value="{{ $id }}"
                            {{ $parent->wali_m_last_education_id == $id ? 'selected' : '' }}>
                            {{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="wali_m_job_id">Pekerjaan Wali</label>
                <select name="wali_m_job_id" id="wali_m_job_id" class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($jobs as $item => $id)
                        <option value="{{ $id }}" {{ $parent->wali_m_job_id == $id ? 'selected' : '' }}>
                            {{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="wali_m_average_income_per_month_id">Pendapatan Wali</label>
                <select name="wali_m_average_income_per_month_id" id="wali_m_average_income_per_month_id"
                    class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($averageIncome as $item => $id)
                        <option value="{{ $id }}"
                            {{ $parent->wali_m_average_income_per_month_id == $id ? 'selected' : '' }}>
                            {{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="wali_phone_number">Nomor Telepon Wali</label>
                <input id="wali_phone_number" class="form-control" type="text" name="wali_phone_number"
                    value="{{ $parent->wali_phone_number }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="wali_rt">RT Wali</label>
                <input id="wali_rt" class="form-control" type="text" name="wali_rt"
                    value="{{ $parent->wali_rt }}">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="wali_rw">RW Wali</label>
                <input id="wali_rw" class="form-control" type="text" name="wali_rw"
                    value="{{ $parent->wali_rw }}">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="wali_postal_code">Kode Pos Wali</label>
                <input id="wali_postal_code" class="form-control" type="number" name="wali_postal_code"
                    value="{{ $parent->wali_postal_code }}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="wali_address">Alamat Wali</label>
                <textarea id="wali_address" class="form-control" name="wali_address">{{ $parent->wali_address }}</textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="wali_kk_file" class="form-label">Upload File KK Wali</label>
                <input type="file" id="wali_kk_file" name="wali_kk_file" class="form-control" accept="image/*"
                    onchange="previewGambar(event)">
            </div>
        </div>
    </div>

    <button type="submit" id="btn-simpan" class="btn btn-primary">Simpan Data</button>
</form>

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#parentForm").submit(function(e) {
                e.preventDefault();
                let btn = $('#btn-simpan');

                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('parents.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data berhasil disimpan.',
                        }).then(() => {
                            $("#parentForm")[0]
                                .reset(); // Reset form setelah berhasil disimpan
                            window.location.reload()
                        });
                    },
                    error: function(errors) {
                        Swal.close();

                        Swal.fire({
                            icon: 'error',
                            title: 'Opps! Gagal',
                            text: errors.responseJSON.message,
                            showConfirmButton: true,
                        }).then(() => {
                            btn.prop('disabled', false).text('Simpan');
                        });

                        if (errors.status == 422) {
                            $('#spinner-border').hide()
                            btn.prop('disabled', false).text('Simpan');

                            loopErrors(errors.responseJSON.errors);
                        }
                    }
                });
            });
        });
    </script>
@endpush
