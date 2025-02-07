@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg border-0 p-4 text-center bg-primary text-white">
            <div class="card-body">
                <h1 class="fw-bold fade-in">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h1>
                <p class="lead fade-in delay-100">
                    Semoga harimu menyenangkan dan penuh inspirasi untuk mengajar. 📚✨
                </p>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fade-in 1s ease-in-out;
        }

        .delay-100 {
            animation-delay: 0.5s;
        }

        .min-vh-100 {
            min-height: 100vh;
        }
    </style>
@endpush
