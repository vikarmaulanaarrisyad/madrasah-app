<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group">
                <label for="name">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                <input id="name" class="form-control" type="text" name="name"
                    placeholder="Masukkan nama pelajaran">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group">
                <label for="curiculum_id">Kurikulum <span class="text-danger">*</span></label>
                <select name="curiculum_id" id="curiculum_id" class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($curiculums as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group">
                <label for="group">Kelompok Mapel <span class="text-danger">*</span></label>
                <select name="group" id="group" class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                </select>
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
