<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body>
    <div class="container-fluid">
        @if(session()->has('berhasil'))
        <div class="position-fixed end-0 top-0">
            <div class="alert alert-succeess alert-dismissible fade show rounded-pill mt-5 me-5">
                {{ session('berhasil') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
        @if(session()->has('gagal'))
        <div class="position-fixed end-0 top-0">
            <div class="alert alert-danger alert-dismissible fade show rounded-pill mt-5 me-5">
                {{ session('gagal') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif

        <div class="row align-items-center">
            <div class="col-lg-3">
                <div class="m-2 m-lg-5 p-2 p-lg-5 text-center">
                    <h6 class="text-primary mb-3 fw-bold">GaDosQ</h6>
                    <h4 class="mb-3">Selamat Datang</h4>
                    <h2>Senang melihatmu kembali</h2>
                </div>
            </div>

            <div class="col-lg-9 border-start">
                <div class="p-2 p-lg-5 m-lg-5 col-lg-6">
                    {{--TTILE--}}
                    <h3 class="mb-5 fw-bold">Login ke GaDOsQ</h3>

                    <form action="{{ route('login.auth') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control p-3 @error('email') is-invalid @enderror" id="email" name="email" 
                            value="{{ old('email') }}" autofocus required>
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control p-3 @error('email') is-invalid @enderror" id="password" name="password" 
                            value="{{ old('password') }}" autofocus required>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="w-100 btn btn-dark p-3 fw-bold rounded-pill">Masuk</button>
                    </form>

                    <div class="my-4 text-center">Belum punya akun? <a href="{{ route('daftar.index') }}">Daftar Disini!</a></div>
                </div>
            </div>
        </div>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>