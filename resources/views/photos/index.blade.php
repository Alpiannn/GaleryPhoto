@extends('layout.main')

@section('content')
    <div class="container">
        @if (session()->has('berhasil'))
            <div class="position-fixed end-0 top-0">
                <div class="alert alert-success alert-dismissible fade show rounded-pill mt-5 me-5" role="alert">
                    {{ session('berhasil') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="d-flex flex-column flex-lg-row gap-4 justify-content-center mb-5">
            <div class="ratio ratio-1x1 overflow-hidden rounded-circle" style="width: 120px; height: 120px;">
                @if (Auth()->user()->avatar)
                <img src="{{ asset('storage/'.Auth()->user()->avatar) }}" alt="avatar" class="object-fit-cover">
                @else
                <img src="{{ asset('img/avatar.png') }}" alt="avatar" class="object-fit-cover">
                @endif
            </div>
            <div class="d-flex flex-column">
                <h1>{{ Auth::user()->name }}</h1>
                <p>{{ Auth::user()->username }}</p>
                <a href="{{ route('users.edit', Auth::user()->username) }}" class="btn btn-outline-dark rounded-pill">Edit Profil</a>
            </div>
        </div>
        <div class="row align-items-center justify-content-between mb-4">
            <div class="col">
                <a href="{{ route('photos.index') }}" class="btn btn-sm btn-dark rounded-pill"><i class="bi bi-images"></i>Semua Photo</a>
                @if (request('cari'))
                    @if (request('album'))
                        <span class="text-secondary ms-2">Hasil Pencarian : <b>{{ request }}</b></span>
                    @endif
                @endif
            </div>
        </div>
    </div>