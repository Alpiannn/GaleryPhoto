@extends('layout.main')

@section('content')
<div class="container">
    {{-- Alert pesan konfirmasi  --}}
    @if (session()->has('berhasil'))
    <div class="position-fixed end-0 top-0">
        <div class="alert alert-success alert-dismissible fade show rounded-pill mt-5 me-5" role="alert">
            {{ session('berhasil') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <div class="col-lg-6 mb-5">
        <h3 class="mb-5 fw-bold">Edit Profil</h3>

        {{-- Form Edit User --}}
        {{-- PERBAIKAN 1: Ganti parameter menjadi username --}}
        <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            
            {{-- Input avatar / photo profil --}}
            <div class="mb-4">
                <div class="ratio ratio-1x1 overflow-hidden rounded-circle mb-3" style="width: 120px">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/'.$user->avatar) }}" alt="Avatar" class="avatar-preview object-fit-cover">
                        <input type="hidden" name="old_avatar" value="{{ $user->avatar }}">
                    @else
                        <img src="{{ asset('img/avatar.png') }}" alt="Avatar" class="avatar-preview object-fit-cover">
                    @endif
                </div>
                <div class="col-lg-6">
                    <input type="file" name="avatar" id="avatar" class="form-control p-3 @error('avatar')is-invalid @enderror" onchange="avatarPreview()">
                    @error('avatar')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="mb-4 row">
                <div class="col-lg-6">
                    <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                    {{-- PERBAIKAN 2: Ganti value menjadi $user->name --}}
                    <input type="text" class="form-control p-3 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-lg-6">
                    <label for="username" class="form-label fw-bold">Username</label>
                    {{-- PERBAIKAN 3: Ganti value menjadi $user->username --}}
                    <input type="text" class="form-control p-3 @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-5">
                <label for="email" class="form-label fw-bold">Email</label>
                {{-- PERBAIKAN 4: Ganti value menjadi $user->email --}}
                <input type="email" name="email" id="email" class="form-control p-3 @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="w-100 btn btn-dark p-3 fw-bold rounded-pill">Update</button>
        </form>
    </div>
</div>

<script>
    function avatarPreview(){
        const photo = document.querySelector('#avatar');
        const imgPreview = document.querySelector('.avatar-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(photo.files[0]);
        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result
        }
    }
</script>
@endsection