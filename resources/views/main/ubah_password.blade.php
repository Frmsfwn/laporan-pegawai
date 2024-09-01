<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Ubah Password</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    {{-- FontAwesome --}}
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>

    {{-- Custom CSS --}}
    <style>
        .end-reveal {
            right: 1.3rem;
        }

        .top-reveal {
            top: 1.85rem;
        }

        :root {
            --light: #f3f6f9;
            --primary: #0d6efd;
            --primary-hover: blue;
            --black: #000000;
            --white: #fff;
        }

        .button {
            background-color: var(--primary);
        }

        .button:hover {
            background-color: blue;
            color: var(--white);
        }

        .form-control:focus {
            box-shadow: 0 0 0 .2rem var(--primary);
        }
    </style>
    
</head>
<body class="bg-body-secondary">
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-white shadow" aria-label="breadcrumb">
        <div class="container-fluid">
            <ul class="breadcrumb align-items-center my-2" style="--bs-breadcrumb-divider: '>';">
                <a class="breadcrumb-item text-black text-decoration-none" href="{{ route('admin.homepage') }}">Homepage</a>
                <a class="breadcrumb-item active" aria-current="page" href="{{ route('edit.password') }}">Ubah Password</a>
            </ul>
            <div class="nav-item dropdown nav-link">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->role }}/<b>{{ Auth::user()->username }}</b></a>
                <ul class="dropdown-menu dropdown-menu-end bg-light border-1 rounded-2 m-0">
                    <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    {{-- Card Table --}}    
    <div class="d-flex align-items-center justify-content-center px-2 pb-2 mt-5">
        <form action="{{ route('update.password', ['User' => Auth::user()]) }}" method="POST" style="width: 460px;" class="shadow-lg mt-5 px-4 pt-4 card bg-white" style="border-radius: 1rem;">
        @csrf
        @method('PUT')
            <h3 class="fw-semibold fs-3 pb-2 text-black align-self-center text-center">Ubah Password</h3>
            <div class="form-floating mb-4">
                <input type="password" name="password_lama" @if($errors->hasBag('ubah_password')) value="{{ old('password_lama') }}" @endif id="password_lama" maxlength="50" autocomplete="off" autocapitalize="off" class="password form-control form-control-lg border-2 @if($errors->ubah_password->has('password_lama')) border-danger @else border-primary @endif  @error('password_lama', 'ubah_password') is-invalid @enderror" @required(true)>
                <label class="form-label" for="password_lama"><i class="fa-solid fa-key"></i> Password saat ini</label>
                <span id="togglePassword" class="toggle-password-icon position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;">
                    <i class="fa-regular fa-eye fa-lg" id="reveal-password"></i>
                </span>
                @error('password_lama', 'ubah_password')
                    <div class="text-danger"><small>{{ $errors->ubah_password->first('password_lama') }}</small></div>
                @enderror
            </div>
            <div class="form-floating mb-4">
                <input type="password" name="password_baru" @if($errors->hasBag('ubah_password')) value="{{ old('password_baru') }}" @endif id="password_baru" maxlength="50" autocomplete="off" autocapitalize="off" class="password form-control form-control-lg border-2 @if($errors->ubah_password->has('password_baru')) border-danger @else border-primary @endif  @error('password_baru', 'ubah_password') is-invalid @enderror" @required(true)>
                <label class="form-label" for="password_baru"><i class="fa-solid fa-key"></i> Password baru</label>
                <span id="togglePassword" class="toggle-password-icon position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;">
                    <i class="fa-regular fa-eye fa-lg" id="reveal-password"></i>
                </span>
                @error('password_baru', 'ubah_password')
                    <div class="text-danger"><small>{{ $errors->ubah_password->first('password_baru') }}</small></div>
                @enderror
            </div>
            <div class="form-floating mb-4">
                <input type="password" name="konfirmasi_password" id="konfirmasi_password" maxlength="50" autocomplete="off" autocapitalize="off" class="password form-control form-control-lg border-2 @if($errors->ubah_password->has('konfirmasi_password')) border-danger @else border-primary @endif  @error('konfirmasi_password', 'ubah_password') is-invalid @enderror" @required(true)>
                <label class="form-label" for="konfirmasi_password"><i class="fa-solid fa-key"></i> Konfirmasi password</label>
                <span id="togglePassword" class="toggle-password-icon position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;">
                    <i class="fa-regular fa-eye fa-lg" id="reveal-password"></i>
                </span>
                @error('konfirmasi_password', 'ubah_password')
                    <div class="text-danger"><small>{{ $errors->ubah_password->first('konfirmasi_password') }}</small></div>
                @enderror
            </div>
            <div class="pt-1 mb-5">
                <button type="submit" class="button shadow-sm btn w-100 fw-semibold">Ubah</button>
            </div>
        </form>
    </div>
    {{-- JQuery Script --}}
    <script>
        $(document).ready(function() {
            $('.toggle-password-icon').on('click', function() {
                let passwordField = $(this).siblings('.form-control');
                let passwordFieldType = passwordField.attr('type');
                
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).children('.fa-eye').removeClass('fa-regular').addClass('fa-solid');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).children('.fa-eye').removeClass('fa-solid').addClass('fa-regular');
                }
            });

            $('.form-control').each(function() {
                if($(this).hasClass('is-invalid')) {
                    $(this).siblings('.toggle-password-icon').removeClass('end-0 top-50').addClass('end-reveal top-reveal');
                }
            })
        });
    </script>    
</body>
</html>