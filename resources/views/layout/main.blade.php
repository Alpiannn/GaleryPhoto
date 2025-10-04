<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GaDosQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <main class="container-fluid px-lg-5">
        {{-- Navigasi --}}
        <nav class="navbar navbar-expand-lg mb-5 py-3">
            <div class="container-fluid p-0">
                <a href="/" class="navbar-brand">GaDosQ</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {{-- List meny sebelah kiri --}}
                    <ul class="navbar-nav me-auto">
                        {{-- menu beranda --}}
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link {{ Request::is('/') ? 'active fw-bold' : '' }}">Beranda</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('photos.index') }}" class="nav-link {{ Request::is('photos*') ? 'active fw-bold' : '' }}">Gallery</a>
                        </li> --}}
                    </ul>

                    <div class="d-flex gap-4 align-item-center">
                        {{-- tombol upload foto --}}
                        {{-- <a href="{{ route('photos.create') }}" class="text-decoration-none text-dark fw-bold">Upload <i class="bi bi-cloud-arrow-up-fill"></i></a> --}}
                        <div class="dropdown">
                            <span class="text-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }} <i class="bi bi-caret-down"></i>
                            </span>

                            <ul class="dropdown-menu">
                                {{-- <li>
                                    <a href="{{ route('photos.index') }}" class="dropdown-item"><i class="bi bi-image"></i> Gallery</a>
                                </li> --}}
                                <li>
                                    <a href="{{ route('users.edit', Auth()->user()->id) }}" class="dropdown-item"><i class="bi bi-pencil-square"></i> Edit Profil</a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf 
                                        <button type="submit" class="dropdown-item"><i class="bi bi-box arrow-right"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div>
            @yield('content')
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>


</body>
</html>