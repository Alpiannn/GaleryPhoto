@extends('layout.main')

@section('content')

<div class="container mt-5">
    <div class="col-lg-10 mx-auto mb-5">
        <h3 class="mb-4">{{ $photo->nama }}</h3>
        <div class="row justify-content-between align-items-center">
            <div class="col">
                <div class="d-flex align-items-center gap-3">
                    <div style="width: 60px; height: 60px">
                        @if ($photo->user->avatar)
                            <img src="{{ asset('storage/'.$photo->user->avatar) }}" alt="{{ $photo->user->name }}" class="img-fluid rounded-circle">
                        @else
                        <img src="{{ asset('img/avatar.png') }}" alt="{{ $photo->user->name }}" class="img-fluid rounded-circle">
                        @endif
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="m-0 fw-bold">{{ $photo->user->name }}</h6>
                        <p class="m-0 text-secondary">{{ $photo->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                {{-- jika user belum menyukai photo ini --}}
                @if (!$likes->count())
                    {{-- maka tampilkan tombol like --}}
                    <form action="{{ route('like') }}" method="POST" class="float-end">
                        @csrf
                        <input type="hidden" name="photo_id" value="{{ $photo->id }}">
                        <button type="submit" class="btn btn-light text-danger rounded-pill">
                            <i class="bi bi-heart"></i><span class="fw-bold">{{ $likecount->count() }}</span>
                        </button>
                    </form>
                {{-- jika user sudah menyukai photo ini --}}
                @else
                    {{-- maka tampilkan tombol unlike --}}
                    <form action="{{ route('unlike', $likes[0]) }}" method="POST" class="float-end">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-light text-danger rounded-pill">
                            <i class="bi bi-heart-fill"></i><span class="fw-bold">{{ $likecount->count() }}</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    {{-- tampil foto  --}}
    <div class="col-lg-10 mx-auto mb-3">
        <img src="{{ asset($photo->photo) }}" alt=""{{ $photo->nama }} class="img-fluid rounded-4 w-100">
        <div class="mt-2">
            @if ($photo->publish == true)
                <p class="text-sucess"><i class="bi bi-eye"></i>Publik</p>
            @else
            <p class="text-secondary"><i class="bi bi-lock"></i> Pribadi</p>
            @endif
        </div>
    </div>

    {{-- tampil deskripsi photo jika ada --}}
@if ($photo->body)
    <div class="col-lg-8 mx-auto py-4">
        <p>{{ $photo->body }}</p>
    </div>
@endif

<div class="d-flex gap-2 justify-content-center my-4">
    {{-- tombol download --}}
    <a href="{{ route('photos.download', $photo) }}" class="btn btn-success rounded-pill"><i class="bi bi-download"></i> Download</a>

    {{-- jika photo yang dibuka adalah photo milik user yg login --}}
    {{-- maka tampilkan tombol edit dan hapus --}}
    @if ($photo->user_id == Auth()->user()->id)
        {{-- tombol edit --}}
        <a href="{{ route('photos.edit', $photo) }}" class="btn btn-warning rounded-pill"><i
                class="bi bi-pencil-square"></i> Edit</a>

        {{-- tombol hapus --}}
        <form action="{{ route('photos.destroy', $photo->id) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger rounded-pill"
                onclick="return confirm('Yakin ingin menghapus photo {{ $photo->nama }}?')"><i
                    class="bi bi-trash"></i> Hapus</button>
        </form>
    @endif
</div>

<hr>
{{-- Bagian komentar --}}
    <div class="col-lg-6 mx-auto mb-5">
        <form action="{{ route('comments.store') }}" method="POST" class="mb-4">
        @csrf
            {{-- kirimkan data id photo --}}
            <input type="hidden" name="photo_id" value="{{ $photo->id }}">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Tulis Komentar</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="body" required>{{ old('body') }}</textarea>
                @error('body')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-sm btn-dark"><i class="bi bi-send"></i> Kirim</button>
        </form>
        @if ($comments->count())
            @foreach ($comments as $comment)
                <div class="mb-4">
                    <div class="d-flex gap-2 align-items-center mb-1">
                        <div style="width: 25px; height: 25px;">
                            {{-- jika user sudah punya photo profil --}}
                            @if ($comment->user->avatar)
                                <img src="{{ asset('storage/' . $comment->user->avatar) }}" class="img-fluid rounded-circle">
                            @else
                                {{-- jika belum punya photo profil --}}
                                <img src="{{ asset('img/avatar.png') }}" class="img-fluid rounded-circle">
                            @endif
                        </div>
                        <h6>
                            {{-- tampilkan nama user dan kapan komentar dibuat --}}
                            {{ $comment->user->name }} <span class="text-secondary fw-normal ms-2">{{ $comment->created_at->diffForHumans() }}</span>
                        </h6>
                            {{-- jika komentar ini adalah milik user yg sedang login --}}
                            @if ($comment->user_id == Auth()->user()->id)
                                {{-- user bisa mengedit komentar --}}
                                <a href="#" class="btn btn-sm btn-outline-warning rounded-pill ms-auto me-1" data-bs-toggle="modal"
                                    data-bs-target="#editKomen{{ $comment->id }}"><i class="bi bi-pencil-fill"></i></a>

                                {{-- user bisa menghapus komentar --}}
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill" type="submit"
                                        onclick="return confirm('Yakin ingin menghapus komentar ini?')">
                                        <i class="bi bi-trash-fill"></i></button>
                                </form>
                            @endif
                    </div>

                    {{-- tampilkan isi komentar --}}
                    <p class="text-secondary">{{ $comment->body }}</p>
                </div>
                {{-- modal untuk edit komentar --}}
                <div class="modal fade" id="editKomen{{ $comment->id }}" tabindex="-1" aria-labelledby="editKomen{{ $comment->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Komentar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('comments.update') }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="photo_id" value="{{ $photo->id }}">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="body" value="{{ $comment->body }}">
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
            @endforeach
        @else
        <div class="mb-4">
            <p class="text-center">Belum ada komentar</p>
        </div>
        @endif
    </div>
</div>

@endsection