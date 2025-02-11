<form id="form-siswa" action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- This indicates that the form is for updating (PUT method) -->

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="full_name" class="form-label">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name" class="form-control"
                    value="{{ old('full_name', $student->full_name) }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="local_nis" class="form-label">NIS</label>
                <input type="text" name="local_nis" class="form-control"
                    value="{{ old('local_nis', $student->local_nis) }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="nisn" class="form-label">NISN</label>
                <input type="text" id="nisn" name="nisn" class="form-control"
                    value="{{ old('nisn', $student->nisn) }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="m_gender_id" class="form-label">Jenis Kelamin</label>
                <select name="m_gender_id" class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    @foreach ($genders as $item => $id)
                        <option value="{{ $id }}" {{ $student->m_gender_id == $id ? 'selected' : '' }}>
                            {{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="birth_place" class="form-label">Tempat Lahir</label>
                <input type="text" name="birth_place" class="form-control"
                    value="{{ old('birth_place', $student->birth_place) }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="birth_date">Tanggal Lahir <span class="text-danger">*</span></label>
                <div class="input-group datepicker" id="birth_date" data-target-input="nearest">
                    <input type="text" name="birth_date" class="form-control datetimepicker-input"
                        data-target="#birth_date" data-toggle="datetimepicker" autocomplete="off"
                        placeholder="Masukkan tanggal lahir" value="{{ old('birth_date', $student->birth_date) }}" />
                    <div class="input-group-append" data-target="#birth_date" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                    <option disabled selected>Pilih salah satu</option>
                    <option value="1" {{ $student->status == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $student->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="kk_num">Nomor KK</label>
                <input id="kk_num" class="form-control" type="text" name="kk_num"
                    value="{{ old('kk_num', $student->kk_num) }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="nik_siswa" class="form-label">NIK</label>
                <input type="text" name="nik_siswa" class="form-control"
                    value="{{ old('nik_siswa', $student->nik) }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="siblings_num" class="form-label">Jumlah Saudara</label>
                <input type="number" name="siblings_num" class="form-control"
                    value="{{ old('siblings_num', $student->siblings_num) }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="child_of_num" class="form-label">Anak Ke</label>
                <input type="number" name="child_of_num" class="form-control"
                    value="{{ old('child_of_num', $student->child_of_num) }}">
            </div>
        </div>
    </div>

    <!-- Repeat the same for other fields as shown above -->

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="m_religion_id" class="form-label">Agama</label>
                <select name="m_religion_id" class="form-control">
                    <option disabled>Pilih salah satu</option>
                    @foreach ($religions as $item => $id)
                        <option value="{{ $id }}" {{ $student->religion_id == $id ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="m_hobby_id" class="form-label">Hobi</label>
                <select name="m_hobby_id" class="form-control">
                    <option disabled>Pilih salah satu</option>
                    @foreach ($hobbies as $item => $id)
                        <option value="{{ $id }}" {{ $student->hobby_id == $id ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="m_life_goal_id" class="form-label">Cita-Cita</label>
                <select name="m_life_goal_id" class="form-control">
                    <option disabled>Pilih salah satu</option>
                    @foreach ($lifeGoals as $item => $id)
                        <option value="{{ $id }}" {{ $student->life_goal_id == $id ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="m_residence_status_id" class="form-label">Status Tempat Tinggal</label>
                <select name="m_residence_status_id" class="form-control">
                    <option disabled>Pilih salah satu</option>
                    @foreach ($residenceStatus as $item => $id)
                        <option value="{{ $id }}"
                            {{ $student->residence_status_id == $id ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="m_residence_distance_id" class="form-label">Jarak</label>
                <select name="m_residence_distance_id" class="form-control">
                    <option disabled>Pilih salah satu</option>
                    @foreach ($residenceDistance as $item => $id)
                        <option value="{{ $id }}"
                            {{ $student->residence_distance_id == $id ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="m_interval_time_id" class="form-label">Waktu Tempuh</label>
                <select name="m_interval_time_id" class="form-control">
                    <option disabled>Pilih salah satu</option>
                    @foreach ($times as $item => $id)
                        <option value="{{ $id }}"
                            {{ $student->interval_time_id == $id ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="m_transportation_id" class="form-label">Transportasi</label>
                <select name="m_transportation_id" class="form-control">
                    <option disabled>Pilih salah satu</option>
                    @foreach ($transportations as $item => $id)
                        <option value="{{ $id }}"
                            {{ $student->transportation_id == $id ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="rt" class="form-label">RT</label>
                <input type="text" name="rt" class="form-control" id="rt"
                    value="{{ old('rt', $student->rt) }}">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="rw" class="form-label">RW</label>
                <input type="text" name="rw" class="form-control" id="rw"
                    value="{{ old('rw', $student->rw) }}">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="address" class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address', $student->address) }}</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="height" class="form-label">Tinggi Badan (Cm)</label>
                <input type="number" name="height" class="form-control"
                    value="{{ old('height', $student->height) }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="weight" class="form-label">Berat Badan (Kg)</label>
                <input type="number" name="weight" class="form-control"
                    value="{{ old('weight', $student->weight) }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="postal_code_num" class="form-label">Kode Pos</label>
                <input type="number" name="postal_code_num" class="form-control"
                    value="{{ old('postal_code_num', $student->postal_code_num) }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="sekolah_sebelumnya" class="form-label">Sekolah Sebelumnya</label>
                <div class="form-check">
                    <input type="checkbox" name="entered_tk_ra" value="1" id="entered_tk_ra"
                        class="form-check-input"
                        {{ old('entered_tk_ra', $student->entered_tk_ra) == 1 ? 'checked' : '' }}
                        onclick="toggleCheckbox(this, 'entered_paud')">
                    <label for="entered_tk_ra" class="form-check-label">TK</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="entered_paud" value="1" id="entered_paud"
                        class="form-check-input"
                        {{ old('entered_paud', $student->entered_paud) == 1 ? 'checked' : '' }}
                        onclick="toggleCheckbox(this, 'entered_tk_ra')">
                    <label for="entered_paud" class="form-check-label">PAUD</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" id="foto" name="foto" class="form-control" accept="image/*"
                    onchange="previewGambar(event)">
                <button type="button" class="btn btn-secondary mt-2" onclick="bukaWebcam()">Ambil dari
                    Webcam</button>
                <video id="webcam" width="320" height="240" autoplay style="display: none;"></video>
                <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
                <button type="button" class="btn btn-success mt-2 mb-2" id="capture-btn" style="display: none;"
                    onclick="ambilGambar()">Ambil Foto</button>
                <input type="hidden" id="webcam-photo" name="webcam_photo">
            </div>
        </div>

        <div class="col-md-6 text-center">
            <div class="form-group">
                <label class="form-label">Preview</label>
                <div class="rounded p-2">
                    <img id="preview"
                        src="{{ Storage::url($student->upload_photo) ?: 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg' }}"
                        class="img-fluid rounded" width="150" height="150">
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('students.index') }}" class="btn btn-warning">Kembali</a>
    <button type="submit" id="btn-simpan" class="btn btn-primary float-right">Simpan</button>
</form>


@include('includes.datepicker')


@push('scripts')
    <script>
        let webcamStream = null;
        let webcamButton = document.querySelector('button[onclick="bukaWebcam()"]'); // Ambil tombol 'Ambil dari Webcam'

        function previewGambar(event) {
            var reader = new FileReader();
            reader.onload = function() {
                document.getElementById('preview').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function bukaWebcam() {
            let video = document.getElementById('webcam');
            let captureBtn = document.getElementById('capture-btn');

            // Sembunyikan tombol "Ambil dari Webcam" saat webcam dimulai
            webcamButton.style.display = "none";

            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    webcamStream = stream;
                    video.style.display = "block";
                    video.style.display = "mt-2";
                    captureBtn.style.display = "block";
                    video.srcObject = stream;
                })
                .catch(err => {
                    Swal.fire("Gagal!", "Tidak dapat mengakses webcam!", "error");
                });
        }

        function ambilGambar() {
            let nisnSiswa = document.getElementById('nisn').value.trim();
            if (!nisnSiswa) {
                Swal.fire("Peringatan!", "Silakan masukkan nisn siswa terlebih dahulu.", "warning");
                return;
            }

            let video = document.getElementById('webcam');
            let canvas = document.getElementById('canvas');
            let ctx = canvas.getContext('2d');

            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(blob => {
                let sanitizedNisnSiswa = nisnSiswa.replace(/\s+/g, '_')
                    .toLowerCase(); // Ganti spasi dengan underscore
                let fileName = `${sanitizedNisnSiswa}.png`; // Nama file sesuai nama siswa

                let file = new File([blob], fileName, {
                    type: "image/png"
                });

                // Masukkan file ke dalam input file agar bisa dikirim ke backend
                let dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.getElementById('foto').files = dataTransfer.files;

                // Update tampilan preview
                let reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                };
                reader.readAsDataURL(file);

                // Tampilkan SweetAlert
                Swal.fire({
                    title: "Foto Berhasil Diambil!",
                    text: `Foto disimpan dengan nama: ${fileName}`,
                    icon: "success",
                    confirmButtonText: "OK"
                });

                // Matikan webcam setelah ambil gambar
                if (webcamStream) {
                    webcamStream.getTracks().forEach(track => track.stop());

                }
                video.style.display = "none";
                document.getElementById('capture-btn').style.display = "none";
                // Tampilkan kembali tombol "Ambil dari Webcam"
                webcamButton.style.display = "inline-block";

            }, 'image/png');
        }
    </script>

    <script>
        function toggleCheckbox(checkbox, otherCheckboxId) {
            if (checkbox.checked) {
                document.getElementById(otherCheckboxId).checked = false;
            }
        }

        $(document).ready(function() {
            // Event saat form disubmit
            $('#form-siswa').submit(function(e) {
                e.preventDefault(); // Mencegah reload halaman
                simpanSiswa(); // Panggil function
            });
        });

        // Function untuk menyimpan data siswa dengan SweetAlert2
        function simpanSiswa() {
            let form = $('#form-siswa')[0]; // Ambil elemen form
            let formData = new FormData(form); // Buat FormData
            let btn = $('#btn-simpan');

            btn.prop('disabled', true).text('Menyimpan...'); // Nonaktifkan tombol submit

            $.ajax({
                url: $('#form-siswa').attr('action'), // Ambil URL dari atribut action form
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val() // Tambahkan token CSRF
                },
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
                    btn.prop('disabled', false).text('Simpan');

                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data berhasil disimpan!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#form-siswa')[0].reset(); // Reset form
                    } else {

                    }
                },
                error: function(errors) {
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
        }
    </script>
@endpush
