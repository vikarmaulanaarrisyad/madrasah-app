<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group">
                <label for="full_name">Nama Lengkap <span class="text-danger">*</span></label>
                <input id="full_name" class="form-control" type="text" name="full_name"
                    placeholder="Masukkan nama lengkap">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="brith_place">Tempat Lahir <span class="text-danger">*</span></label>
                <input id="brith_place" class="form-control" type="text" name="brith_place"
                    placeholder="Masukkan tempat lahir">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="birth_date">Tanggal Mulai <span class="text-danger">*</span></label>
                <div class="input-group datepicker" id="birth_date" data-target-input="nearest">
                    <input type="text" name="birth_date" class="form-control datetimepicker-input"
                        data-target="#birth_date" data-toggle="datetimepicker" autocomplete="off"
                        placeholder="Masukkan tanggal lahir" />
                    <div class="input-group-append" data-target="#birth_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="m_gender_id">Jenis Kelamin</label>
                <select name="m_gender_id" id="m_gender_id" class="form-control">
                    <option selected disabled>Pilih salah satu</option>
                    @foreach ($genders as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="m_religion_id">Agama</label>
                <select name="m_religion_id" id="m_religion_id" class="form-control">
                    <option selected disabled>Pilih salah satu</option>
                    @foreach ($religions as $label => $value)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <label for="rt">Rt</label>
                <input id="rt" class="form-control" type="text" name="rt">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="rw">Rw</label>
                <input id="rw" class="form-control" type="text" name="rw">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="postal_code_num">Kode Pos</label>
                <input id="postal_code_num" class="form-control" type="text" name="postal_code_num">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea name="address" id="address" cols="3" rows="3" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="tmt_teacher">TMT Guru <span class="text-danger">*</span></label>
                <div class="input-group datepicker" id="tmt_teacher" data-target-input="nearest">
                    <input type="text" name="tmt_teacher" class="form-control datetimepicker-input"
                        data-target="#tmt_teacher" data-toggle="datetimepicker" autocomplete="off"
                        placeholder="Masukkan tmt guru" />
                    <div class="input-group-append" data-target="#tmt_teacher" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="tmt_employe">TMT Pegawai <span class="text-danger">*</span></label>
                <div class="input-group datepicker" id="tmt_employe" data-target-input="nearest">
                    <input type="text" name="tmt_employe" class="form-control datetimepicker-input"
                        data-target="#tmt_employe" data-toggle="datetimepicker" autocomplete="off"
                        placeholder="Masukkan tmt pegawai" />
                    <div class="input-group-append" data-target="#tmt_employe" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" class="form-control" type="text" name="email">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" class="form-control" type="text" name="username">
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-outline-primary"
            id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status"
                aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>
