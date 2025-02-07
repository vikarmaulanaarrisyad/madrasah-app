<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="date">Tanggal <span class="text-danger">*</span></label>
                <div class="input-group datepicker" id="date" data-target-input="nearest">
                    <input type="text" name="date" class="form-control datetimepicker-input" data-target="#date"
                        data-toggle="datetimepicker" autocomplete="off" placeholder="Masukkan tanggal lahir" />
                    <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group">
                <label for="learning_activity_id">Rombel <span class="text-danger">*</span></label>
                <select name="learning_activity_id" id="learning_activity_id" class="form-control select2"></select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group">
                <label for="name">Mata Pelajaran <span class="text-danger">*</span></label>
                <select name="subject_id" id="subject_id" class="form-control select2"></select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="cp">KD/CP</label>
                <textarea name="cp" id="cp" cols="5" rows="2" class="form-control summernote"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="material">Materi</label>
                <textarea name="material" id="material" cols="5" rows="2" class="form-control summernote"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="task">Tugas</label>
                <textarea name="task" id="task" cols="5" rows="2" class="form-control summernote"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="notes">Catatan</label>
                <textarea name="notes" id="notes" cols="5" rows="2" class="form-control summernote"></textarea>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-outline-primary" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>
