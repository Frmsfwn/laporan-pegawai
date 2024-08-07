<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Admin | Dashboard</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary ">
        <div class="container-fluid">
            
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
    </div>
    </div>
</nav>
<h1>Dashboard Admin.</h1><br>
    <a href="{{ route('logout') }}">Logout</a><br>
    <a href="{{ route('admin.show.data_tahun_kegiatan') }}">Data Tahun Kegiatan</a><br>
</body>
</html>