@extends('layout.main')

@section('content')

<div class="text-center py-2 py-lg-5">
    <h1 class="mb-3">Temukan photo menarik dan kreatif</h1>
    <p><b>GaDosQ</b>adalah tempat terbaik untuk menyimpan kenangan indah yang terabadikan</p>
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
    <div class="col-lg-3">
        <a href="{{ route('photos.show', $photo->id) }}" class="rati ratio-4x3 overflow-hidden">
            <img src="{{ asset( $photo->photo) }}" class="rounded-3 object-fit-cover" alt="{{ $photo->nama }}">
        </a>

        <div class="p-2">
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex align-blick bg-secondary rounded-circle overflow-hidden" style="width: 30px; height: 30px;">
                    @if ($photo->user->avatar)
                    <img src="{{ asset($photo->user->avatar) }}" alt="Photo Profil" class="object-fit-cover w-100 h-100">
                    @else
                    <img src="{{ asset('img/avatar.png') }}" alt="Photo Profil" class="object-fit-cover w-100 h-100">
                    @endif
                </div>
                <span class="fw-bold">{{ $photo->user->name }}</span>
            </div>
            <span class="text-secondary" style="font-size: 12px;">{{ $photo->created_at->diffForHumans() }}</span>
        </div>
    </div>
</div>
@endforeach

<div class="d-flex justify-content-center">
    {{ $photos->links() }}
</div>
@endif

@endsection