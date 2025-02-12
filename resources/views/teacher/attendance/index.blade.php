@extends('layouts.main')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top:60px">
        <div class="col">
            <div id="webcam-capture" class="webcam-capture">
                <video id="webcam-video" autoplay playsinline style="width: 100%; border-radius: 15px;"></video>
                <img id="preview" style="width: 100%; border-radius: 15px; display: none;">
            </div>
        </div>
    </div>

    <!-- Card Informasi Waktu Absen -->
    <div class="row mt-1">
        <div class="col">
            <div class="card border-info">
                <div class="card-body">
                    <h5 class="card-title text-info"><ion-icon name="information-circle-outline"></ion-icon> Informasi Absen
                    </h5>
                    <p class="card-text">
                        <strong>Absen Masuk</strong> hanya dapat dilakukan sampai pukul <strong>07:00</strong>. <br>
                        <strong>Absen Pulang</strong> dapat dilakukan setelah pukul <strong>13:30</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col">
            @if ($absenHariIni > 0)
                <button id="takeabsen" onclick="ambilGambar()" class="btn btn-danger btn-block">
                    <ion-icon name="camera-outline"></ion-icon> Absen Pulang
                </button>
            @else
                <button id="takeabsen" onclick="ambilGambar()" class="btn btn-primary btn-block">
                    <ion-icon name="camera-outline"></ion-icon> Absen Masuk
                </button>
            @endif

            <button id="takeNewPhoto" onclick="fotoUlang()" class="btn btn-warning btn-block" style="display: none;">
                <ion-icon name="refresh-outline"></ion-icon> Foto Ulang
            </button>
            <button id="submitAbsen" onclick="kirimDataKeServer()" class="btn btn-success btn-block mb-3" style="display: none;">
                <ion-icon name="send-outline"></ion-icon> Kirim Absen
            </button>
        </div>
    </div>

    <canvas id="canvas" style="display: none;"></canvas>
    <form id="form-absen" enctype="multipart/form-data">
        @csrf
        <input type="file" id="foto" name="foto" style="display: none;">
    </form>
@endsection


@push('css')
    <style>
        .webcam-capture {
            position: relative;
            width: 100%;
            border-radius: 15px;
        }

        .webcam-capture video,
        .webcam-capture img {
            width: 100%;
            border-radius: 15px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let webcamStream = null;

        document.addEventListener("DOMContentLoaded", function() {
            startWebcam();
        });

        function startWebcam() {
            let videoElement = document.getElementById('webcam-video');
            let previewImage = document.getElementById('preview');

            previewImage.style.display = "none"; // Sembunyikan preview jika ada
            videoElement.style.display = "block"; // Tampilkan kembali video

            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(function(stream) {
                    webcamStream = stream;
                    videoElement.srcObject = stream;
                })
                .catch(function(error) {
                    Swal.fire({
                        title: "Akses Kamera Gagal",
                        text: "Pastikan izin kamera diaktifkan di browser Anda.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                });
        }

        function ambilGambar() {
            let video = document.getElementById("webcam-video");
            let canvas = document.getElementById("canvas");
            let ctx = canvas.getContext("2d");
            let previewImage = document.getElementById("preview");

            // Ambil ukuran video dan simpan ke canvas
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Konversi ke Blob & File
            canvas.toBlob(blob => {
                let fileName = `absen_${new Date().getTime()}.png`;
                let file = new File([blob], fileName, {
                    type: "image/png"
                });

                // Masukkan ke input file
                let dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.getElementById('foto').files = dataTransfer.files;

                // Tampilkan preview gambar
                previewImage.src = URL.createObjectURL(file);
                previewImage.style.display = "block";
                video.style.display = "none"; // Sembunyikan video

                stopWebcam(); // Matikan kamera

                // Atur tombol
                document.getElementById('takeabsen').style.display = "none";
                document.getElementById('takeNewPhoto').style.display = "block";
                document.getElementById('submitAbsen').style.display = "block";
            }, 'image/png');
        }

        function fotoUlang() {
            startWebcam(); // Nyalakan kembali webcam

            document.getElementById('takeabsen').style.display = "block";
            document.getElementById('takeNewPhoto').style.display = "none";
            document.getElementById('submitAbsen').style.display = "none";
        }

        function stopWebcam() {
            if (webcamStream) {
                let tracks = webcamStream.getTracks();
                tracks.forEach(track => track.stop());
                webcamStream = null;
            }
        }


        function kirimDataKeServer() {
            let fotoInput = document.getElementById('foto');
            let submitButton = document.getElementById('submitAbsen');

            // Cek apakah ada file yang dipilih
            if (fotoInput.files.length === 0) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Silakan ambil gambar terlebih dahulu.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }

            // Disable tombol dan ubah teks tombol
            submitButton.disabled = true;
            submitButton.innerHTML = '<ion-icon name="hourglass-outline"></ion-icon> Mengirim...';

            let formData = new FormData();
            formData.append("foto", fotoInput.files[0]);
            formData.append("_token", $('input[name="_token"]').val()); // Ambil token CSRF dari input hidden

            // Tampilkan Swal Loading
            Swal.fire({
                title: "Mengirim...",
                text: "Mohon tunggu, sedang memproses data absensi.",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Kirim data dengan AJAX (jQuery)
            $.ajax({
                url: "{{ route('attendace.teacher_store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    stopWebcam(); // Matikan webcam jika digunakan

                    if (response.status == 400) {
                        Swal.fire({
                            title: "Gagal!",
                            text: response.message,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                        submitButton.disabled = false;
                        submitButton.innerHTML = '<ion-icon name="send-outline"></ion-icon> Kirim Absen';
                        return;
                    }

                    Swal.fire({
                        title: "Berhasil!",
                        text: response.message,
                        icon: "success",
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route('dashboard') }}';
                    });
                },
                error: function(errors) {
                    Swal.fire({
                        title: "Gagal!",
                        text: errors.responseJSON?.message || 'Terjadi kesalahan!',
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<ion-icon name="send-outline"></ion-icon> Kirim Absen';
                }
            });
        }

        function kirimDataKeServer1() {
            let fotoInput = document.getElementById('foto');
            let submitButton = document.getElementById('submitAbsen');

            if (fotoInput.files.length === 0) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Silakan ambil gambar terlebih dahulu.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                return;
            }

            submitButton.disabled = true;
            submitButton.innerHTML = '<ion-icon name="hourglass-outline"></ion-icon> Mengirim...';

            let formData = new FormData();
            formData.append("foto", fotoInput.files[0]);
            formData.append("_token", document.querySelector('input[name="_token"]').value);

            fetch("{{ route('attendace.teacher_store') }}", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    stopWebcam();
                    if (data.status == 400) {
                        Swal.fire({
                            title: "Gagal!",
                            text: data.message,
                            icon: "error",
                            confirmButtonText: "OK"
                        });

                        return;
                    }

                    Swal.fire({
                        title: "Berhasil!",
                        text: data.message,
                        icon: "success",
                        timer: 3000,
                    }).then(() => {
                        window.location.href = '{{ route('dashboard') }}';
                    });
                })
                .catch(error => {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi kesalahan saat mengirim data.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<ion-icon name="send-outline"></ion-icon> Kirim Absen';
                });
        }
    </script>
@endpush
