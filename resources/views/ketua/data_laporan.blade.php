<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | {{ Auth::user()->role }} | Data Laporan</title>

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
                <ul class="navbar-nav me-auto breadcrumb align-items-center my-2" style="--bs-breadcrumb-divider: '>';">
                    <a class="breadcrumb-item text-black text-decoration-none" href="{{ route('ketua.homepage') }}">Homepage</a>
                    <a class="breadcrumb-item active" aria-current="page" href="{{ route('ketua.show.data_laporan', ['tahun' => request('tahun'), 'nama' => request('nama')]) }}">Data Laporan</a>
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
    <main class="container-fluid ps-3 my-4">
        <section class="row g-2 justify-content-between">
            <button class="btn btn-primary mb-sm-3 ms-1 col-auto" data-bs-toggle="modal" data-bs-target="#modalTambahData"><i class="fa-solid fa-plus me-2"></i>Tambah Data</button>
            <form class="col-12 col-sm-auto" action="{{ route('ketua.search.data_laporan', ['tahun' => request('tahun'), 'nama' => request('nama')]) }}" method="GET">
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
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbahData{{ $dataLaporanKegiatan->id }}">Ubah</button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusData{{ $dataLaporanKegiatan->id }}">Hapus</button>
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

    {{-- Modal Tambah Data Laporan --}}
    <form action="{{ route('ketua.create.laporan_kegiatan', ['tahun' => request('tahun'), 'nama' => request('nama')]) }}" method="POST" enctype="multipart/form-data" class="form-card">
        @csrf
        <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content container-fluid p-0 container-md">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalTambahDataLabel">Tambah Data Laporan Kegiatan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-between text-left mb-2">
                            <div class="col-sm-12 flex-column d-flex">
                                <strong class="text-start"><label for="judul_laporan" class="form-label">Judul Laporan<span class="text-danger">*</span></label></strong>
                                <input type="text" name="judul_laporan" id="judul_laporan" maxlength="50" @if($errors->hasBag('tambah_data')) value="{{ old('judul_laporan') }}" @endif  class="form-control @error('judul_laporan', 'tambah_data') is-invalid @enderror" @required(true)>
                                @error('judul_laporan', 'tambah_data')
                                    <div class="text-danger"><small>{{ $errors->tambah_data->first('judul_laporan') }}</small></div>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-between text-left mb-2">
                            <div class="col-sm-12 flex-column d-flex">
                                <strong class="text-start"><label for="informasi_kegiatan" class="form-label">Informasi Kegiatan<span class="text-danger">*</span></label></strong>
                                <textarea name="informasi_kegiatan" id="informasi_kegiatan" maxlength="100"  class="form-control @error('informasi_kegiatan', 'tambah_data') is-invalid @enderror" @required(true)>@if($errors->hasBag('tambah_data')){{{ old('informasi_kegiatan') }}}@endif</textarea>
                                @error('informasi_kegiatan', 'tambah_data')
                                    <div class="text-danger"><small>{{ $errors->tambah_data->first('informasi_kegiatan') }}</small></div>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-between text-left mb-2">
                            <div class="col-12 flex-column d-flex">
                                <strong class="text-start"><label for="lampiran_kegiatan" class="form-label">Lampiran Kegiatan<span class="text-danger">*</span></label></strong>
                                <input type="file" name="lampiran_kegiatan" id="lampiran_kendaraan" class="form-control @error('lampiran_kegiatan', 'tambah_data') is-invalid @enderror" @required(true)>
                                @error('lampiran_kegiatan', 'tambah_data')
                                    <div class="text-danger text-start"><small>{{ $errors->tambah_data->first('lampiran_kegiatan') }}</small></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </form>  
    @foreach($data_laporan_kegiatan as $dataLaporanKegiatan)
        {{-- Modal Ubah Data Laporan --}}
        <form action="{{ route('ketua.edit.laporan_kegiatan', ['LaporanKegiatan' => $dataLaporanKegiatan]) }}" method="POST" enctype="multipart/form-data" class="form-card">
            @csrf
            @method('PUT')
            <div class="modal fade" id="modalUbahData{{ $dataLaporanKegiatan->id }}" tabindex="-1" aria-labelledby="modalUbahDataLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content container-fluid p-0">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalUbahDataLabel">Ubah Data Laporan Kegiatan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-between text-left mb-2">
                                <div class="col-sm-12 flex-column d-flex">
                                    <strong class="text-start"><label for="judul_laporan" class="form-label">Judul Laporan<span class="text-danger">*</span></label></strong>
                                    <input type="text" name="judul_laporan" id="judul_laporan" maxlength="50" @if($errors->hasBag($dataLaporanKegiatan->id)) value="{{ old('judul_laporan') }}" @else value="{{ $dataLaporanKegiatan->judul_laporan }}" @endif class="form-control @error('judul_laporan', $dataLaporanKegiatan->id) is-invalid @enderror" @required(true)>
                                    @error('judul_laporan', $dataLaporanKegiatan->id)
                                        <div class="text-danger"><small>{{ $errors->{$dataLaporanKegiatan->id}->first('judul_laporan') }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row justify-content-between text-left mb-2">
                                <div class="col-sm-12 flex-column d-flex">
                                    <strong class="text-start"><label for="informasi_kegiatan" class="form-label">Informasi Kegiatan<span class="text-danger">*</span></label></strong>
                                    <textarea name="informasi_kegiatan" id="informasi_kegiatan" maxlength="100" class="form-control @error('informasi_kegiatan', $dataLaporanKegiatan->id) is-invalid @enderror" @required(true)>@if($errors->hasBag($dataLaporanKegiatan->id)){{ old('informasi_kegiatan') }}@else{{ $dataLaporanKegiatan->informasi_kegiatan }}@endif</textarea>
                                    @error('informasi_kegiatan', $dataLaporanKegiatan->id)
                                        <div class="text-danger"><small>{{ $errors->{$dataLaporanKegiatan->id}->first('informasi_kegiatan') }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row justify-content-between text-left mb-2">
                                <div class="col-sm-12 flex-column d-flex">
                                    <strong class="text-start"><label for="lampiran_kegiatan" class="form-label">Lampiran Kegiatan</label></strong>
                                    <input type="file" name="lampiran_kegiatan" id="lampiran_kegiatan" class="form-control @error('lampiran_kegiatan', $dataLaporanKegiatan->id) is-invalid @enderror">
                                    @error('lampiran_kegiatan', $dataLaporanKegiatan->id)
                                        <div class="text-danger text-start"><small>{{ $errors->{$dataLaporanKegiatan->id}->first('lampiran_kegiatan') }}</small></div>
                                    @enderror
                                </div>
                            </div>            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        {{-- Modal Hapus Data Laporan --}}
        <div class="modal fade" id="modalHapusData{{ $dataLaporanKegiatan->id }}" tabindex="-1" aria-labelledby="modalHapusDataLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalHapusDataLabel">Hapus Data Laporan Kegiatan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        Apakah anda yakin ingin menghapus data ini?<br>
                        <b>Judul Laporan : {{ $dataLaporanKegiatan->judul_laporan }}</b>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('ketua.delete.laporan_kegiatan', ['LaporanKegiatan' => $dataLaporanKegiatan]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
                        
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if ($errors->hasBag('tambah_data'))
                $('#modalTambahData').modal('show');
            @endif
        });

        @foreach($data_laporan_kegiatan as $dataLaporanKegiatan)
            document.addEventListener('DOMContentLoaded', function () {
                @if ($errors->hasBag($dataLaporanKegiatan->id))
                    $("#modalUbahData{{ $dataLaporanKegiatan->id }}").modal('show');
                @endif
            });
        @endforeach
    </script>
</body>
</html>