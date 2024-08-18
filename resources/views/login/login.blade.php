<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

{{-- Bootstrap --}}
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

{{-- Css --}}
<link rel="stylesheet" href="{{asset('css/login.css')}}" >

    <title>{{ config('app.name') }} | Login</title>
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
            <i class="fa-solid fa-arrow-right-long icon pt-xl-2 pt-md-2" style="font-size: 35px"></i>
            <div class="form-floating mb-4" >
                <input type="text" name="username" id="username" @if($errors->hasBag('login')) value="{{ old('username') }}" @endif maxlength="15" autocomplete="off" class="form-control form-control-lg border-2 border-warning @error('username', 'login') is-invalid @enderror" @required(true)>
                <label class="form-label" for="username">Username</label>
                @error('username', 'login')
                    <div class="text-danger"><small>{{ $errors->login->first('username') }}</small></div>
                @enderror
            </div>
            <div class="form-floating mb-4">
                <input type="password" name="password" id="password" maxlength="50" autocomplete="off" autocomplete="off" class="form-control form-control-lg border-2 border-warning @error('password', 'login') is-invalid @enderror" @required(true)>
                <label class="form-label" for="password">Password</label>
                @error('password', 'login')
                    <div class="text-danger"><small>{{ $errors->login->first('password') }}</small></div>
                @enderror
            </div>
        <div class="pt-1 mb-5">
            <input class="button shadow-sm btn w-100 fw-semibold" type="submit" value="Login">
        </div>
    </form>
</body>
</html>