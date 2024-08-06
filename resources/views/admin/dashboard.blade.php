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
    <h1>Dashboard Admin.</h1><br>
    <a href="{{ route('logout') }}">Logout</a><br>
    <a href="{{ route('admin.show.data_tahun_kegiatan') }}">Data Tahun Kegiatan</a><br>
</body>
</html>