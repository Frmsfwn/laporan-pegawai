<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Manajemen | Data Tim</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    {{-- FontAwesome --}}
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>
    
</head>
<body class="bg-body-secondary">
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-white shadow">
        <div class="container-fluid">
            <ul class="breadcrumb align-items-center my-2" style="--bs-breadcrumb-divider: '>';">
                <a class="navbar-brand" href="{{ route('manajemen.homepage') }}">Homepage</a>
                <a class="nav-link active pt-2 pb-1" aria-current="page" href="{{ route('manajemen.show.data_tim', ['tahun' => request('tahun')]) }}">Data Tim</a>
            </ul>
            <div class="nav-item dropdown nav-link">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->role }}/<b>{{ Auth::user()->username }}</b></a>
                <ul class="dropdown-menu dropdown-menu-end bg-light border-1 rounded-2 m-0">
                    <li><a class="dropdown-item" href="{{ route('edit.password') }}"><i class="fa-solid fa-key"></i> Ubah Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </div>
            </div>
        </div>
    </nav>
    {{-- Card Table --}}    
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-11 col-sm-7 col-md-8 col-lg-9 col-xl-10 colxxl-11 mx-auto p-2">
                <div class="shadow-lg bg-light card text-center rounded p-3">
                    <div class="row align-items-center justify-content-between mb-4">
                        <div class="row">
                            <div class="col text-center">
                                <h3 class="mb-0">{{ $data_tahun_kegiatan->nama }}/Tim Kerja</h3>
                            </div>
                            <div class="d-flex">
                                
                            </div>    
                            <form class="d-flex col-7 col-md-4 col-xxl-2 mt-2" role="search" action="{{ route('manajemen.search.data_tim', ['tahun' => request('tahun')]) }}" method="GET">
                                <input class="form-control w-100" name="keyword" id="search" type="search" value="{{ $keyword }}" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Tim</th>
                                    <th scope="col" colspan="4">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data_tim_kegiatan as $dataTimKegiatan)
                                    <tr class="align-middle">
                                        <td>{{ $dataTimKegiatan->nama }}</td>
                                        <td>
                                            <a href="{{ route('manajemen.show.data_laporan', ['tahun' => request('tahun'), 'nama' => $dataTimKegiatan->nama]) }}" class="btn btn-primary">Laporan</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td><a>Data Kosong!</a></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>