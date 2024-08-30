<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Admin | Data Laporan</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Custom CSS --}}
    <style>
        @media (max-width: 430px) {
            .w-s-100 {
                width: 100% !important;
            }
        } 
    </style>

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
                <a class="breadcrumb-item text-black text-decoration-none" href="{{ route('admin.homepage') }}">Homepage</a>
                <a class="breadcrumb-item text-black text-decoration-none" href="{{ route('admin.show.data_tim', ['tahun' => request('tahun')]) }}">Data Tim</a>
                <a class="breadcrumb-item active" aria-current="page" href="{{ route('admin.show.data_laporan', ['tahun' => request('tahun'), 'nama' => request('nama')]) }}">Data Laporan</a>
            </ul>
            <div class="nav-item dropdown nav-link w-s-100 text-end">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->role }}/<b>{{ Auth::user()->username }}</b></a>
                <ul class="dropdown-menu dropdown-menu-end bg-light border-1 rounded-2 m-0">
                    <li><a class="dropdown-item" href="{{ route('edit.password') }}"><i class="fa-solid fa-key"></i> Ubah Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container-fluid ps-3 my-4">
        <section class="row g-2 justify-content-between">
            <form class="col-12 col-sm-auto" action="{{ route('admin.search.data_laporan', ['tahun' => request('tahun'), 'nama' => request('nama')]) }}" method="GET">
                <div class="input-group mb-3">
                    <button type="submit" class="input-group-text shadow-sm" for="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input type="text" class="form-control shadow-sm" name="keyword" id="search" type="search" value="{{ $keyword }}" placeholder="Search" aria-label="Search">
                </div>
            </form>
        </section>
        <h2 class="m-auto text-black text-center mt-2 mb-4">{{ $data_tim_kegiatan->nama }}/Laporan</h2>
        <section class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-6 g-3 mb-3">
            @forelse ($data_laporan_kegiatan as $dataLaporanKegiatan)
            {{-- Card --}}
            <div class="col">
                <div class="card">
                    <div class="overflow-hidden rounded">
                        <ul class="list-group list-group-flush">                
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> Judul Laporan</h4>
                                <h5 class="card-text fw-normal">{{ $dataLaporanKegiatan->judul_laporan }}</h5>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> Informasi Kegiatan</h4>
                                <h5 class="card-text fw-normal">{{ $dataLaporanKegiatan->informasi_kegiatan }}</h5>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> Status</h4>
                                <h5 class="card-text fw-normal">
                                    @if($dataLaporanKegiatan->status_laporan == null)
                                        -
                                    @else
                                        {{ $dataLaporanKegiatan->status_laporan }}
                                    @endif
                                </h5>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> Lampiran</h4>
                                <h5 class="card-text fw-normal">{{ $dataLaporanKegiatan->lampiran }}</h5>
                            </li>
                            <li class="list-group-item ">
                                <a href="{{ route('download.laporan_kegiatan', ['LaporanKegiatan' => $dataLaporanKegiatan]) }}" class="btn btn-primary">Unduh</a>                            </li>                                                
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @empty
                <h3 class="m-auto text-secondary opacity-75 text-center mt-3">Data Kosong</h3>
            @endforelse
        </section>
    </main>
</body>
</html>