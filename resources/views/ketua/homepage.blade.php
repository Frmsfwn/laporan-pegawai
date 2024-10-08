<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Ketua | Homepage</title>

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
                <ul class="navbar-nav me-auto breadcrumb align-items-center my-2" style="--bs-breadcrumb-divider: '>';">
                    <li class="nav-item">
                        <a class="breadcrumb-item text-black text-decoration-none" href="{{ route('ketua.homepage') }}">Homepage</a>
                    </li>
                </ul>
                <div class="dropdown me-3">
                    <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->notifikasi)
                            <i class="fa-solid fa-bell fa-xl">
                                <span class="position-absolute top-0 start-60 translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                                <span class="visually-hidden">New alerts</span>
                            </i>
                        @else
                            <i class="fa-solid fa-bell fa-xl"></i>
                        @endif
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end p-2">
                        @forelse(Auth::user()->notifikasi->sortByDesc('created_at')->slice(0, 3) as $notification)
                            <li class="dropdown-item" data-bs-toggle="modal" role="button" data-bs-target="#lightbox{{ $notification->id }}">
                                <h6 class="fw-normal mb-0">{{ $notification->pesan }}</h6>
                                <small>{{ $notification->created_at->setTimezone(new \DateTimeZone('Asia/Jakarta'))->format('Y-m-d H:i') }}</small>
                            </li>
                            <hr class="dropdown-divider">
                        @empty
                            <h6 class="fw-normal mb-0">Tidak ada notifikasi terbaru!</h6>
                        @endforelse
                    </ul>
                </div>
                <li class="nav-item dropdown nav-link">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->role }}/<b>{{ Auth::user()->username }}</b></a>
                    <ul class="dropdown-menu dropdown-menu-end bg-light border-1 rounded-2 m-0">
                        <li><a class="dropdown-item" href="{{ route('edit.password') }}"><i class="fa-solid fa-key"></i> Ubah Password</a></li>
                        <li><hr class="dropdown-divider"></li>
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
                <div class="shadow-lg bg-light card text-center rounded p-3">
                    <div class="row align-items-center justify-content-between mb-4">
                        <div class="row">
                            <div class="col text-center">
                                <h3 class="mb-0">Tim Kegiatan</h3>
                            </div>
                            <div class="d-flex">
                                
                            </div>    
                            {{-- <form class="d-flex col-7 col-md-4 col-xxl-2 mt-2" role="search" action="{{ route('manajemen.search.data_tim', ['tahun' => $data_tahun_kegiatan]) }}" method="GET">
                                <input class="form-control w-100" name="keyword" id="search" type="search" value="{{ $keyword }}" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form> --}}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Tim</th>
                                    <th scope="col" colspan="2">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data_tim_kegiatan as $dataTimKegiatan)
                                    <tr class="align-middle">
                                        <td>{{ $dataTimKegiatan->nama }}</td>
                                        <td>
                                            <a href="{{ route('ketua.show.data_anggota', ['tahun' => $dataTimKegiatan->tahun_kegiatan->tahun, 'nama' => $dataTimKegiatan->nama]) }}" class="btn btn-primary">Anggota</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('ketua.show.data_laporan', ['tahun' => $dataTimKegiatan->tahun_kegiatan->tahun, 'nama' => $dataTimKegiatan->nama]) }}" class="btn btn-primary">Laporan</a>
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