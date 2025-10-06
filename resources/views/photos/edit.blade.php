@extends('layout.main')

@section('content')
    <div class="container">
        <div class="col-lg-6 mb-5">
            <h3 class="mb-5 fw-bold">Edit Photo</h3>
            <form action="{{ route('photos.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                {{-- Input Photo --}}

                <div class="mb-4">

                    <img src="{{ asset('photos.update', $photo) }}" alt="" class="photo-preview img-fluid rounded-3 mb-3 col-sm-6 d-block">
                    <div class="col-lg-6">
                        <input type="hidden" name="photolama" value="{{ $photo->photo }}"> 
                        <input type="file" name="photo" id="photo" class="form-control p-3 @error('photo') is-invalid @enderror" onchange="photoPreview()">
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
                    <input type="text" name="nama" id="nama" class="form-control p-3 @error('nama') is-invalid @enderror" value="{{ old('nama', $photo) }}">
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- input album --}}
                <div class="mb-5">
                    <label for="album" class="form-label fw-bold">Simpan di Album</label>
                    
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
                   
                    <p>Ups.. Sepertinya kamu belum membuat album, <a href="{{ route('photos.index') }}">buat album</a> di gallery?</p>
                    
                    @error('album_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- input caption/deskripsi photo --}}
                <div class="mb-5">
                    <label for="body" class="form-label fw-bold">Deskripsi</label>
                    <input type="text" name="body" id="body" class="form-control p-3 @error('body') is-invalid @enderror" value="{{ old('body', $photo) }}">
                    @error('body')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- input publish --}}
                <div class="mb-5 form-check form-switch">
                    <label for="publish" class="form-label fw-bold">Terbitkan ke publik?</label>
                    <input type="checkbox" name="publish" id="publish" class="form-check-input p-3 @error('publish') is-invalid @enderror" @if(old('publish', $photo->publish) == true) checked @endif>
                    
                    <div class="text-secondary">
                        Jika diaktifkan, photo akan tampil di beranda <br>
                        Jika dinonaktifkan, photo akan diarsipkan
                    </div>
                </div>
                <button type="submit" class="w-100 btn btn-dark p-3 fw-bold rounded-pill">Update photo</button>
            </form>
        </div>
    </div>

    <script>
        function photoPreview() {
            const photo = document.querySelector('#photo');
            const imgPreview = document.querySelector('.photo-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(photo.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection