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
                <img src="{{ asset($user->avatar) }}" alt="avatar" class="object-fit-cover">
                @else
                <img src="{{ asset('img/avatar.png') }}" alt="avatar" class="object-fit-cover">
                @endif
            </div>
            <div class="d-flex flex-column">
                <h1>{{ Auth::user()->name }}</h1>
                <p>{{ Auth::user()->username }}</p>
                <a href="{{ route('users.edit', Auth::user()->id) }}" class="btn btn-outline-dark rounded-pill">Edit Profil</a>
            </div>
        </div>
        <div class="row align-items-center justify-content-between mb-4">
            <div class="col">
                <a href="{{ route('photos.index') }}" class="btn btn-sm btn-dark rounded-pill"><i class="bi bi-images"></i>Semua Photo</a>
                @if (request('cari'))
                    @if (request('album'))
                        <span class="text-secondary ms-2">Hasil Pencarian : <b>{{ request('cari') }}</b> di album : <b>{{ request('album') }}</b></span>
                    @else()
                        <span class="text-secondary ms-2">Hasil Pencarian : <b>{{ request('cari') }}</b> </span>
                    @endif
                @endif
            </div>
            <div class="col">
                <form action="{{ route('photos.index') }}">
                    @if (request('album'))
                        <input type="hidden" name="album" value="{{ request('album') }}">
                    @endif
                    <div class="input-group">
                        <input type="text" class="form-control rounded-start-pill" placeholder="Temukan Photo" aria-describedby="button-addon2" name="cari" value="{{ request('cari') }}">
                        <button type="submit" class="btn btn-outline-dark rounded-end-pill" id="button-addon2"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
        {{-- CRUD ALBUM --}}
        <div class="d-flex flex-wrap align-items-center gap-3 gap-lg-5 pb-5">
            <a href="/photos?arsip=true" class="text-decoration-none px-2 py-1 text-secondary @if(request('arsip')) text-dark fw-bold @endif"><i class="bi bi-archive"></i> Arsip @if(request('arsip')) | {{ $photos->count() }} @endif</a>
            @if ($albums->count())
                @foreach ($albums as $album)
                    @if (request('album') == $album->nama)
                        <div>
                            <a href="/photos?album={{ $album->nama }}" class="text-decoration-none text-dark fw-bold">{{ $album->nama }} | {{ $photos->count() }}</a>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-light rounded-pill" type="button" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a href="" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#album{{ $album->id }}">Edit Album</a></li>
                                    <li>
                                        <form action="{{ route('album.destroy', $album->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('Semua photo di album {{ $album->nama }} akan dihapus, yakin ingin menghapus?')">Hapus Album</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            {{-- modal edit album --}}
                            <div class="modal fade" id="album{{ $album->id }}" tabindex="-1" aria-labelledby="album{{ $album->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3>Edit Album</h3>
                                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('album.update', $album->id) }}" method="post" aria>
                                                @csrf
                                                @method('put')
                                                <div class="mb-3">
                                                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $album->nama }}">
                                                </div>
                                                <button type="submit" class="btn btn-dark">Update</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                    <a href="photos?album={{ $album->nama }}" class="text-decoration-none px-2 py-1 text-secondary">{{ $album->nama }}</a>
                    @endif
                @endforeach
            @endif
            <a href="" class="btn btn-sm btn-outline-dark rounded-pill" data-bs-toggle="modal" data-bs-target="#tambah-album">
                <i class="bi bi-plus-circle"></i> Album
            </a>
            <div class="modal fade" id="tambah-album" tab-index="-1" aria-labelledby="tambah-album" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Album Baru</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('album.store') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="nama" required autofocus>
                                </div>
                                <button type="submit" class="btn btn-dark">Simpan</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        {{-- List Photo --}}
        @if ($photos->count())
            <div class="row row-gap-5 pt-3 pb-5 justify-content-center">
                @foreach ($photos as $photo)
                    <div class="col-lg-4">
                      <a href="{{ route('photos.show', $photo->id) }}" class="ratio ratio-4x3 overflow-hidden">
                        <img src="{{ asset($photo->photo) }}" alt="{{ $photo->nama }}" class="rounded-3 object-fit-cover" alt="{{ $photo->nama }}">
                    </a>  
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center">
                {{ $photos->links() }}
            </div>

        @else
            <div class="row justify-content-center">
                <img src="{{ asset('img/gallery-kosong.png') }}" alt="Gallery kosong" class="img-fluid">
                <h4 class="text-center mb-4">Ups!! Photo Tidak Ditemukan</h4>
                <a href="" class="w-100 btn btn-dark rounded-pill py-2 px-4">Upload <i class="bi bi-cloud-arrow-up-fill"></i></a>
            </div>

        @endif
    </div>
    @endsection