@extends('layout.main')

@section('content')
    <div class="container">
        <div class="col-lg-6 mb-5">
            <h3 class="mb-5 fw-bold">Simpan Photo Terbaikmu</h3>
            <form action="{{ route('photos.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                {{-- Input Photo --}}
                <div class="mb-4">
                    <img src="" alt="" class="photo-preview img-fluid rounded-3 mb-3 col-sm-6 d-block" id="photoPreview" style="display: none;">
                    <div class="col-lg-6">
                        <input type="file" name="photo" id="photo" class="form-control p-3 @error('photo') is-invalid @enderror" onchange="previewImage()">
                        @error('photo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                {{-- Input nama Foto  --}}
                <div class="mb-5">
                    <label for="nama" class="form-label fw-bold">Judul Photo</label>
                    <input type="text" name="nama" id="nama" class="form-control p-3 @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- input album --}}
                <div class="mb-5">
                    <label for="album" class="form-label fw-bold">Simpan di Album</label>
                    @if ($albums->count())
                        <select name="album_id" id="album" class="form-select p-3 mt-2 @error('album_id') is-invalid @enderror" >
                            <option value="">Pilih Album</option>
                            {{-- looping album --}}
                            @foreach ($albums as $album)
                                @if (old('album_id') == $album->id)
                                    <option value="{{ $album->id }}" selected>{{ $album->nama }}</option>
                                @else
                                    <option value="{{ $album->id }}">{{ $album->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                    @else
                    <p>Ups.. Sepertinya kamu belum membuat album, <a href="{{ route('albums.create') }}">buat album</a> dulu?</p>
                    @endif
                    @error('album_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- input caption/deskripsi photo --}}
                <div class="mb-5">
                    <label for="body" class="form-label fw-bold">Deskripsi</label>
                    <input type="text" name="body" id="body" class="form-control p-3 @error('body') is-invalid @enderror" value="{{ old('body') }}">
                    @error('body')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- input publish --}}
                <div class="mb-5 form-check form-switch">
                    <label for="publish" class="form-label fw-bold">Terbitkan ke publik?</label>
                    <input type="checkbox" name="publish" id="publish" class="form-check-input p-3 @error('publish') is-invalid @enderror" value="1" @if(old('publish') == true) checked @endif>
                    <div class="text-secondary">
                        Jika diaktifkan, photo akan tampil di beranda <br>
                        Jika dinonaktifkan, photo akan diarsipkan
                    </div>
                </div>
                <button type="submit" class="w-100 btn btn-dark p-3 fw-bold rounded-pill">Simpan photo</button>
            </form>
        </div>
    </div>

    <script>
        function previewImage() {
            const input = document.querySelector('#photo');
            const preview = document.querySelector('#photoPreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection