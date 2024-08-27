<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Admin | Data Laporan</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    {{-- FontAwesome --}}
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>    

</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-white shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.homepage') }}">Homepage</a>
                <ul class="navbar-nav me-auto flex-row">
                    <li class="nav-item me-2">
                        <a class="nav-link active pt-2 pb-1" aria-current="page" href="{{ route('admin.show.detail_tim_kegiatan', ['tahun' => request('tahun'), 'nama' => request('nama')]) }}">Data Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.show.data_tim_kegiatan', ['tahun' => request('tahun')]) }}">Data Anggota</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.show.data_tim_kegiatan', ['tahun' => request('tahun')]) }}">Data Tahun</a>
                    </li>
                </ul>
                <li class="nav-item dropdown nav-link">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->role }}, <b>{{ Auth::user()->username }}</b></a>
                    <ul class="dropdown-menu dropdown-menu-end bg-light border-1 rounded-2 m-0">
                        <li><a class="dropdown-item" href="{{ route('edit.password') }}"><i class="fa-solid fa-key"></i> Ubah Password</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                    </ul>
                </li>
            </div>
        </div>
    </nav>
    
</body>
</html>