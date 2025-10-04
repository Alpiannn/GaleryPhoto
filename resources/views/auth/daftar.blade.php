    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>

    <body>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <div class="m-2 m-lg-5 p-2 p-lg-5 text-center">
                        <h6 class="text-primary mb-3 fw-bold">GaDosQ</h6>
                        <h4 class="mb-3">Selamat Datang</h4>
                        <h2>Senang bertemu denganmu</h2>
                    </div>
                </div>

                <div class="col-lg-9 border-start">
                    <div class="p-2 p-lg-5 m-lg-5 col-lg-6">
                        <!-- Title  -->
                         <h3 class="mb-5 fw-bold">Daftar ke GaDosQ</h3>

                         <form action="{{ route('daftar.store') }}" method="post">
                            @csrf
                            <div class="mb-4 row">
                                <div class="col-lg-6">
                                    <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" name="name" id="name" class="form-control p-3 @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus required>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-lg-6">
                                    <label for="username" class="form-label fw-bold">Username</label>
                                    <input type="text" name="username" id="username" class="form-control p-3 @error('username') is-invalid @enderror" value="{{ old('username') }}" autofocus required>
                                    @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" name="email" id="email" class="form-control p-3 @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <input type="password" name="password" id="password" class="form-control p-3 @error('password') is-invalid @enderror"  required>
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="repassword" class="form-label fw-bold">Konfirmasi Password</label>
                                <input type="password" name="repassword" id="repassword" class="form-control p-3 @error('repassword') is-invalid @enderror"  required>
                                @error('repassword')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="w-100 btn btn-dark p-3 fw-bold rounded-pill">Buat Akun</button>

                         </form>

                         <div class="my-4 text-center">Sudah punya akun? <a href="{{ route('login') }}">Login Disini</a></div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>

    </html>