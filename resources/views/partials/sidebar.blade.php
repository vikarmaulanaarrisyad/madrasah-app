<aside class="main-sidebar elevation-4 sidebar-light-primary">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link bg-primary">
        <img src="" alt="Logo" class="brand-image img-circle elevation-3 bg-light" style="opacity: .8">
        <span class="brand-text font-weight-light">Nama</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (!empty(auth()->user()->avatar) && Storage::disk('public')->exists(auth()->user()->avatar))
                    <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="logo" class="img-circle elevation-2"
                        style="width: 35px; height: 35px;">
                @else
                    <img src="{{ asset('AdminLTE/dist/img/user1-128x128.jpg') }}" alt="logo"
                        class="img-circle elevation-2" style="width: 35px; height: 35px;">
                @endif
            </div>
            <div class="info">
                <a href="{{ route('profile.show') }}" class="d-block" data-toggle="tooltip" data-placement="top"
                    title="Edit Profil">
                    {{ auth()->user()->name }}
                    <i class="fas fa-pencil-alt ml-2 text-sm text-primary"></i>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if (Auth::user()->hasRole('Admin'))
                    <li class="nav-header">MASTER DATA</li>
                    <li class="nav-item">
                        <a href="{{ route('academicyears.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>
                                Tahun Pelajaran
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('curiculums.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-book-open"></i>
                            <p>Kurikulum</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('subjects.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Mata Pelajaran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('teachers.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <p>
                                Guru
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('students.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-graduate"></i>
                            <p>
                                Data Siswa
                            </p>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Guru'))
                    <li class="nav-item">
                        <a href="{{ route('rombel.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Rombongan Belajar
                            </p>
                        </a>
                    </li>
                @endif

                {{--  <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>
                            Presensi Siswa
                        </p>
                    </a>
                </li>  --}}
                @if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Guru'))
                    <li class="nav-item">
                        <a href="{{ route('journals.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-book-reader"></i>
                            <p>
                                Jurnal Mengajar Guru
                            </p>
                        </a>
                    </li>
                @endif

                {{--  <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Cetak Raport</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Cetak Buku Induk Siswa</p>
                    </a>
                </li>  --}}

            </ul>
        </nav>
    </div>
</aside>
