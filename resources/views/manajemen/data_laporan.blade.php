<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | {{ Auth::user()->role }} | Data Laporan</title>

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
            <a class="navbar-brand" href="{{ route('manajemen.homepage') }}">Homepage <i class="fa-solid fa-chevron-right fs-6"></i></a>
            <ul class="navbar-nav me-auto flex-row">
                <li class="nav-item">
                    <a class="nav-link pt-2 pb-1" href="{{ route('manajemen.show.data_tim', ['tahun' => request('tahun')]) }}">Data Tim <i class="fa-solid fa-chevron-right fs-6"></i></a>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link active pt-2 pb-1 ms-2" aria-current="page" href="{{ route('manajemen.show.data_laporan', ['tahun' => request('tahun'), 'nama' => request('nama')]) }}">Data Laporan</a>
                </li>
            </ul>
            <li class="nav-item dropdown nav-link">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->role }}/<b>{{ Auth::user()->username }}</b></a>
                <ul class="dropdown-menu dropdown-menu-end bg-light border-1 rounded-2 m-0">
                    <li><a class="dropdown-item" href="{{ route('edit.password') }}"><i class="fa-solid fa-key"></i> Ubah Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </li>
        </div>
    </nav>
    <main class="container-fluid ps-3 my-4">
        <section class="row g-2 justify-content-between">
            <form class="col-12 col-sm-auto" action="{{ route('manajemen.search.data_laporan', ['tahun' => request('tahun'), 'nama' => request('nama')]) }}" method="GET">
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
                                <a href="{{ route('download.laporan_kegiatan', ['LaporanKegiatan' => $dataLaporanKegiatan]) }}" class="btn btn-primary">Unduh</a>
                                <a href="{{ route('manajemen.accept.laporan_kegiatan', ['LaporanKegiatan' => $dataLaporanKegiatan]) }}" class="btn btn-success">Terima</a>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalKonfirmasi{{ $dataLaporanKegiatan->id }}">Tolak</button>
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
    @foreach($data_laporan_kegiatan as $dataLaporanKegiatan)
        {{-- Modal Konfirmasi Tolak Laporan --}}
        <div class="modal fade" id="modalKonfirmasi{{ $dataLaporanKegiatan->id }}" tabindex="-1" aria-labelledby="modalKonfirmasiLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalKonfirmasiLabel">Tolak Laporan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        Apakah anda yakin ingin menolak laporan ini?<br>
                        <b>
                            Judul Laporan : {{ $dataLaporanKegiatan->judul_laporan }}<br>
                        </b>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalTolakLaporan{{ $dataLaporanKegiatan->id }}">Tolak</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Tolak Laporan --}}
        <form action="{{ route('manajemen.decline.laporan_kegiatan', ['LaporanKegiatan' => $dataLaporanKegiatan]) }}" method="POST" class="form-card">
            @csrf
            <div class="modal fade" id="modalTolakLaporan{{ $dataLaporanKegiatan->id }}" tabindex="-1" aria-labelledby="modalTolakLaporanLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content container-fluid p-0 container-md">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalTolakLaporanLabel">Tolak Laporan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-between text-left mb-2">
                                <div class="col-sm-12 flex-column d-flex ">
                                    <strong class="text-start"><label for="alasan" class="form-label">Alasan<span class="text-danger">*</span></label></strong>
                                    <textarea id="alasan" name="alasan" maxlength="100" class="form-control @error('alasan', $dataLaporanKegiatan->id) is-invalid @enderror" @required(true)>@if($errors->hasBag('tolak_laporan')){{ old('alasan') }}@endif</textarea>
                                    @error('alasan', $dataLaporanKegiatan->id)
                                        <div class="text-danger"><small>{{ $errors->{$dataLaporanKegiatan->id}->first('alasan') }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Kirim</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>        
    @endforeach
</body>
</html>