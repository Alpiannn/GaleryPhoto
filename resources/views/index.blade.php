@extends('layout.main')

@section('content')

<div class="text-center py-2 py-lg-5">
    <h1 class="mb-3">Temukan photo menarik dan kreatif</h1>
    <p><b>GaDosQ</b> adalah tempat terbaik untuk menyimpan kenangan indah yang terabadikan</p>
</div>

<div class="col-lg-5 mx-auto py-4">
    <form action="{{ route('home') }}">
        <div class="input-group mb-3">
            <input type="text" class="form-control p-3 rounded-start-pill" placeholder="Temukan Photo" aria-describedby="button-addon2" name="cari"
            value="{{ request('cari') }}">
            <button class="btn btn-outline-dark rounded-end-pill p-3" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
        </div>
    </form>
</div>

@if ($photos->count() == 0)
<div class="row justify-content-center mb-5">
    <div class="col-lg-4 justify-content-center">
        <img src="{{ asset('img/gallery-kosong.png') }}" alt="Gallery Kosong" class="img-fluid">
        <h4 class="text-center mb-4">Ups!! Photo tidak ditemukan.</h4>
        <a href="" class="w-100 btn btn-dark rounded-pill py-2 px-4 ">Upload <i class="bi bi-cloud-arrow-up-fill"></i></a>
    </div>
</div>

@else
<div class="row row-gap-5 pb-5 justify-content-center">
    @foreach ($photos as $photo)
    <div class="col-lg-3 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <a href="{{ route('photos.show', $photo->id) }}" class="ratio ratio-4x3 overflow-hidden rounded-top">
                <img src="{{ asset($photo->photo) }}" class="object-fit-cover w-100 h-100" alt="{{ $photo->nama }}">
            </a>
            
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="flex-shrink-0 bg-secondary rounded-circle overflow-hidden" style="width: 30px; height: 30px;">
                        @if ($photo->user->avatar)
                        <img src="{{ asset($photo->user->avatar) }}" alt="Photo Profil" class="object-fit-cover w-100 h-100">
                        @else
                        <img src="{{ asset('img/avatar.png') }}" alt="Photo Profil" class="object-fit-cover w-100 h-100">
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <span class="fw-bold d-block">{{ $photo->user->name }}</span>
                        <small class="text-muted">{{ $photo->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $photos->links() }}
</div>
@endif

@endsection