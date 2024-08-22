<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Ubah Password</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- FontAwesome --}}
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>
    
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <ul class="nav navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link pt-2 pb-1" href="{{ route('admin.homepage') }}">Homepage</a>
                    </li>
                </ul>
                <li class="nav-item dropdown nav-link">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->username }}</a>
                    <ul class="dropdown-menu dropdown-menu-end bg-light border-1 rounded-2 m-0">
                        <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                    </ul>
                </li>
            </div>
        </div>
    </nav>
    {{-- Card Table --}}    
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-11 col-sm-7 col-md-8 col-lg-9 col-xl-10 colxxl-11 mx-auto p-2">
                    <div class="bg-light card rounded p-3">
                        <div class="row align-items-center justify-content-between mb-4">
                            <div class="row">
                                <div class="d-flex">
                                    
                                </div>    
                            </div>
                        </div>
    <h2 class="text-center">Ubah Password</h2>
    <form action="{{ route('update.password', ['User' => Auth::user()]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row justify-content-between text-left mb-2">
        <div class="col-sm-12 flex-column d-flex">
            <strong class="text-start"><label for="password_lama" class="form-label">Password Saat Ini<span class="text-danger">*</span></label></strong>
            <input type="password" id="password_lama" name="password_lama" @if($errors->hasBag('ubah_password')) value="{{ old('password_lama') }}" @endif maxlength="50" class="form-control @error('password_lama', 'ubah_password') is-invalid @enderror" @required(true)>
            @error('password_lama', 'ubah_password')
                <div class="text-danger"><small>{{ $errors->ubah_password->first('password_lama') }}</small></div>
            @enderror
        </div>
    </div>
    <div class="row justify-content-between text-left mb-2">
        <div class="col-sm-12 flex-column d-flex ">
            <strong class="text-start"><label for="password_baru" class="form-label">Password Baru<span class="text-danger">*</span></label></strong>
            <input type="password" id="password_baru" name="password_baru" maxlength="50" class="form-control @error('password_baru', 'ubah_password') is-invalid @enderror" @required(true)>
            @error('password_baru', 'ubah_password')
                <div class="text-danger"><small>{{ $errors->ubah_password->first('password_baru') }}</small></div>
            @enderror
        </div>
    </div>
    <div class="row justify-content-between text-left mb-2">
        <div class="col-sm-12 flex-column d-flex">
            <strong class="text-start"><label for="konfirmasi_password" class="form-label">Konfirmasi Password<span class="text-danger">*</span></label></strong>
            <input type="password" id="konfirmasi_password" name="konfirmasi_password" maxlength="50" class="form-control @error('konfirmasi_password', 'ubah_password') is-invalid @enderror" @required(true)>
            @error('konfirmasi_password', 'ubah_password')
                <div class="text-danger"><small>{{ $errors->ubah_password->first('konfirmasi_password') }}</small></div>
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Ubah</button>
    </form>
</body>
</html>