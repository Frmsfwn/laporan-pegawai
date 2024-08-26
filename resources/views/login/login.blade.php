<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Login</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    {{-- FontAwesome --}}
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>

    {{-- Css --}}
    <link rel="stylesheet" href="{{asset('css/login.css')}}">

    {{-- Custom CSS --}}
    <style>
        .end-reveal {
            right: 1.3rem;
        }

        .top-reveal {
            top: 1.85rem;
        }
    </style>    

</head>
<body class="overflow-hidden">
    <div class="row">
        <div class="col-sm-7 width-xxl px-0 d-none d-sm-block ">
            <img src="{{asset('img/bglog.jpg')}}"
            alt="Login image" class="w-100  vh-100" style="object-fit: cover; object-position: left;">
        </div>
    <div class="col-sm-5 bg-log " style="height: 100vh"> 
    <div class="mx-auto mt-3 pb-xxl-5" style="width: 140px;">
        <img src="{{asset('img/logo.png')}}" class="logo img-fluid" >
    </div>
    <div class="d-flex align-items-center justify-content-center px-2 pb-2 mt-2">
        <form action="" method="POST" style="width: 460px;" class="shadow-lg  mt-4 px-4 pt-4 card bg-white" style="border-radius: 1rem;">
        @csrf
            <h3 class="fw-semibold fs-1 pb-2 text-black align-self-center text-center">Laporan Pegawai</h3>
            <div class="form-floating mb-4" >
                <input type="text" name="username" id="username" @if($errors->hasBag('login')) value="{{ old('username') }}" @endif maxlength="15" autocomplete="off" autocapitalize="off" class="form-control form-control-lg border-2 @if($errors->login->has('username')) border-danger @else border-primary @endif @error('username', 'login') is-invalid @enderror" @required(true)>
                <label class="form-label" for="username"><i class="fa-solid fa-user"></i> Username</label>
                @error('username', 'login')
                    <div class="text-danger"><small>{{ $errors->login->first('username') }}</small></div>
                @enderror
            </div>
            <div class="form-floating mb-4">
                <input type="password" name="password" id="password" maxlength="50" autocomplete="off" autocapitalize="off" class="password form-control form-control-lg border-2 @if($errors->login->has('password')) border-danger @else border-primary @endif  @error('password', 'login') is-invalid @enderror" @required(true)>
                <label class="form-label" for="password"><i class="fa-solid fa-key"></i> Password</label>
                <span id="togglePassword" class="toggle-password-icon position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;">
                    <i class="fa-regular fa-eye fa-lg" id="reveal-password"></i>
                </span>
                @error('password', 'login')
                    <div class="text-danger"><small>{{ $errors->login->first('password') }}</small></div>
                @enderror
            </div>
            <div class="pt-1 mb-5">
                <input class="button shadow-sm btn w-100 fw-semibold" type="submit" value="Login">
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#togglePassword').on('click', function() {
                let passwordField = $('#password');
                let passwordFieldType = passwordField.attr('type');
                
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $('#reveal-password').removeClass('fa-regular').addClass('fa-solid');
                } else {
                    passwordField.attr('type', 'password');
                    $('#reveal-password').removeClass('fa-solid').addClass('fa-regular');
                }
            });

            if($('.password').hasClass('is-invalid')) {
                $('#togglePassword').removeClass('end-0 top-50').addClass('end-reveal top-reveal');
            }
        });
    </script>             
</body>
</html>