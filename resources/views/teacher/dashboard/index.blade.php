@extends('layouts.main')

@section('content')
    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section" id="user-section">
            <div id="user-detail">
                <div class="avatar">
                    <img src="{{ asset('templates') }}/assets/img/sample/avatar/avatar1.jpg" alt="avatar"
                        class="imaged w64 rounded">
                </div>
                <div id="user-info">
                    <h3 id="user-name">{{ Auth::user()->name }}</h3>
                    <span id="user-role">{{ Auth::user()->getRoleNames()->first() }}</span>
                </div>
            </div>
        </div>

        <div class="section" id="menu-section">
            <div class="card">
                <div class="card-body text-center">
                    <div class="list-menu">
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="green" style="font-size: 40px;">
                                    <ion-icon name="person-sharp"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Profil</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="danger" style="font-size: 40px;">
                                    <ion-icon name="calendar-number"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Cuti</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="warning" style="font-size: 40px;">
                                    <ion-icon name="document-text"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Histori</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="orange" style="font-size: 40px;">
                                    <ion-icon name="location"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Lokasi
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section mt-2" id="presence-section">
            <div class="todaypresence">
                <div class="row">
                    <div class="col-6">
                        <div class="card gradasigreen">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        @if ($presensiHariIni != null)
                                            <img src="{{ Storage::url($presensiHariIni->foto_in ?? '') }}" alt=""
                                                class="imaged w64 ">
                                        @else
                                            <ion-icon name="camera"></ion-icon>
                                        @endif
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Masuk</h4>
                                        <span>{{ $presensiHariIni != null ? $presensiHariIni->jam_in : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card gradasired">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        @if ($presensiHariIni != null && $presensiHariIni->jam_out != null)
                                            <img src="{{ Storage::url($presensiHariIni->foto_in ?? '') }}" alt=""
                                                class="imaged w64 ">
                                        @else
                                            <ion-icon name="camera"></ion-icon>
                                        @endif

                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Pulang</h4>
                                        <span>{{ $presensiHariIni != null && $presensiHariIni->jam_out != null ? $presensiHariIni->jam_out : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--
            <div class="rekappresence">
                <div id="chartdiv"></div>
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence primary">
                                        <ion-icon name="log-in"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Hadir</h4>
                                        <span class="rekappresencedetail">0 Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence green">
                                        <ion-icon name="document-text"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Izin</h4>
                                        <span class="rekappresencedetail">0 Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence warning">
                                        <ion-icon name="sad"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Sakit</h4>
                                        <span class="rekappresencedetail">0 Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence danger">
                                        <ion-icon name="alarm"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Terlambat</h4>
                                        <span class="rekappresencedetail">0 Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  --}}

            <div id="rekappresence">
                <h3>Rekap Absen Anda Bulan {{ $namaBulan[$bulanIni] }} Tahun {{ $tahunIni }}</h3>
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding:12px 12px !important; line-height: 0.8rem">
                                <span class="badge bg-danger"
                                    style="position:absolute; top:3px; right:10px; font-size: 0.6rem; z-index:999">{{ $jumlahHadir }}</span>
                                <ion-icon name="accessibility-outline" style="font-size: 1.6rem;"
                                    class="text-primary mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem">Hadir</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding:12px 12px !important; line-height: 0.8rem">
                                <span class="badge bg-danger"
                                    style="position:absolute; top:3px; right:10px; font-size: 0.6rem; z-index:999">10</span>
                                <ion-icon name="newspaper-outline" style="font-size: 1.6rem;"
                                    class="text-success mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem">Izin</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding:12px 12px !important; line-height: 0.8rem">
                                <span class="badge bg-danger"
                                    style="position:absolute; top:3px; right:10px; font-size: 0.6rem; z-index:999">10</span>
                                <ion-icon name="medkit-outline" style="font-size: 1.6rem;"
                                    class="text-warning mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem">Sakit</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding:12px 12px !important; line-height: 0.8rem">
                                <span class="badge bg-danger"
                                    style="position:absolute; top:3px; right:10px; font-size: 0.6rem; z-index:999">{{ $jumlahTerlambat }}</span>
                                <ion-icon name="alarm-outline" style="font-size: 1.6rem;"
                                    class="text-danger mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem">Telat</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div id="rekappresence">
                <h3 class="mt-2"> Absen Siswa Tanggal {{ tanggal_indonesia($tglIni) }}</h3>
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding:12px 12px !important; line-height: 0.8rem">
                                <span class="badge bg-danger"
                                    style="position:absolute; top:3px; right:10px; font-size: 0.6rem; z-index:999">{{ $studentsHadir }}</span>
                                <ion-icon name="checkmark-circle-outline" style="font-size: 1.6rem;"
                                    class="text-primary mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem">Hadir</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding:12px 12px !important; line-height: 0.8rem">
                                <span class="badge bg-danger"
                                    style="position:absolute; top:3px; right:10px; font-size: 0.6rem; z-index:999">{{ $studentsIzin }}</span>
                                <ion-icon name="time-outline" style="font-size: 1.6rem;"
                                    class="text-success mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem">Izin</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding:12px 12px !important; line-height: 0.8rem">
                                <span class="badge bg-danger"
                                    style="position:absolute; top:3px; right:10px; font-size: 0.6rem; z-index:999">{{ $studentsSakit }}</span>
                                <ion-icon name="medkit-outline" style="font-size: 1.6rem;"
                                    class="text-warning mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem">Sakit</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding:12px 12px !important; line-height: 0.8rem">
                                <span class="badge bg-danger"
                                    style="position:absolute; top:3px; right:10px; font-size: 0.6rem; z-index:999">{{ $studentsAlpa }}</span>
                                <ion-icon name="close-circle-outline" style="font-size: 1.6rem;"
                                    class="text-danger mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem">Alpa</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Daftar Siswa
                                <span class="badge bg-success ml-1">{{ $students->count() }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($historyBulanIni as $item)
                                <li>
                                    <div class="item">
                                        <div class="icon-box bg-primary">
                                            <ion-icon name="finger-print-outline"></ion-icon>
                                        </div>
                                        <div class="in">
                                            <div>{{ date('Y-m-d', strtotime($item->tgl_presensi)) }}</div>
                                            <span class="badge badge-success">{{ $item->jam_in }}</span>
                                            <span
                                                class="badge badge-danger">{{ $presensiHariIni != null && $item->jam_out != null ? $item->jam_out : 'Belum Absen' }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($students as $item)
                                <li>
                                    <div class="item">
                                        <img src="{{ Storage::url($item->upload_photo) }}" alt="image"
                                            class="image">
                                        <div class="in">
                                            <div>{{ $item->full_name }}</div>
                                            <span class="text-muted">{{ $item->learningActivities->first()->level->name }}
                                                {{ $item->learningActivities->first()->name }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
@endsection
