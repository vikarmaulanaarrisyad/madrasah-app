@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('subtitle', 'Edit Siswa')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Kesiswaan</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#siswa" data-toggle="tab">Data Siswa</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#orangtua" data-toggle="tab">Data Orangtua</a></li>
                        <li class="nav-item"><a class="nav-link" href="#nilai" data-toggle="tab">Data Nilai</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="siswa">
                            @include('admin.student.form.siswa-edit-form')
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="orangtua">

                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="nilai">

                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection
