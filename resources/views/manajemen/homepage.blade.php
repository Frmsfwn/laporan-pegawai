<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Manajemen | Homepage</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    {{-- FontAwesome --}}
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>
    
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('manajemen.homepage') }}">Homepage</a>
                    </li>
                </ul>
                <li class="nav-item dropdown nav-link">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->username }}</a>
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
                <div class="bg-light card text-center rounded p-3">
                    <div class="row align-items-center justify-content-between mb-4">
                        <div class="row">
                            <div class="col text-center">
                                <h3 class="mb-0">Data Laporan Kegiatan Terbaru</h3>
                            </div>
                            <div class="d-flex">
                                
                            </div>    
                            {{-- <form class="d-flex col-7 col-md-4 col-xxl-2 mt-2" role="search" action="{{ route('admin.search.data_tahun_kegiatan') }}" method="GET">
                                <input class="form-control w-100" name="keyword" id="search" type="search" value="{{ $keyword }}" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form> --}}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" style="width: 100%; ">
                            <thead>
                                <tr>
                                    <th scope="col">Status</th>
                                    <th scope="col">Tahun Kegiatan</th>
                                    <th scope="col">Nama Kegiatan</th>
                                    <th scope="col">Judul Laporan</th>
                                    <th scope="col">Nama Tim</th>
                                    <th scope="col">Informasi Kegiatan</th>
                                    <th scope="col">Lampiran</th>
                                    <th scope="col">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data_laporan_kegiatan_terbaru as $dataLaporanKegiatanTerbaru)
                                    <tr class="align-middle">
                                        @if($dataLaporanKegiatanTerbaru->status_laporan == null)
                                            <td>-</td>
                                        @else
                                            <td>{{ $dataLaporanKegiatanTerbaru->status_laporan }}</td>
                                        @endif
                                        <td>{{ $dataLaporanKegiatanTerbaru->tahun_kegiatan->tahun }}</td>
                                        <td>{{ $dataLaporanKegiatanTerbaru->tahun_kegiatan->nama }}</td>
                                        <td>{{ $dataLaporanKegiatanTerbaru->judul_laporan }}</td>
                                        <td>{{ $dataLaporanKegiatanTerbaru->nama_tim_kegiatan }}</td>
                                        <td><textarea disabled>{{ $dataLaporanKegiatanTerbaru->informasi_kegiatan }}</textarea></td>
                                        <td>{{ $dataLaporanKegiatanTerbaru->lampiran }}</td>
                                        <td>
                                            <a href="{{ route('download.laporan_kegiatan', ['LaporanKegiatan' => $dataLaporanKegiatanTerbaru]) }}" class="btn btn-primary" >Unduh</a>
                                            <form action="{{ route('manajemen.accept.laporan_kegiatan', ['LaporanKegiatan' => $dataLaporanKegiatanTerbaru]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Terima</button>
                                            </form>
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalTolakLaporan{{ $dataLaporanKegiatanTerbaru->id }}">Tolak</button>
                                        </td>
                                    </tr>
                                    {{-- Modal Tambah Data --}}
                                    <form action="{{ route('manajemen.decline.laporan_kegiatan', ['LaporanKegiatan' => $dataLaporanKegiatanTerbaru]) }}" method="POST" class="form-card">
                                        @csrf
                                        <div class="modal fade" id="modalTolakLaporan{{ $dataLaporanKegiatanTerbaru->id }}" tabindex="-1" aria-labelledby="modalTolakLaporanLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content container-fluid p-0 container-md">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modalTolakLaporanLabel">Tolak Laporan</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah anda yakin ingin menolak laporan kegiatan ini?<br>
                                                        <b>Judul Laporan : {{ $dataLaporanKegiatanTerbaru->judul_laporan }} | Tim Kegiatan : {{ $dataLaporanKegiatanTerbaru->nama_tim_kegiatan }}</b>
                                                        <div class="row justify-content-between text-left mb-2 mt-3">
                                                            <div class="col-sm-12 flex-column d-flex ">
                                                                <strong class="text-start"><label for="alasan" class="form-label">Alasan<span class="text-danger">*</span></label></strong>
                                                                <textarea id="alasan" name="alasan" maxlength="100" class="form-control @error('alasan', $dataLaporanKegiatanTerbaru->id) is-invalid @enderror" @required(true)>@if($errors->hasBag($dataLaporanKegiatanTerbaru->id)){{ old('alasan') }}@endif</textarea>
                                                                @error('alasan', $dataLaporanKegiatanTerbaru->id)
                                                                    <div class="text-danger"><small>{{ $errors->{$dataLaporanKegiatanTerbaru->id}->first('alasan') }}</small></div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">Simpan</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    @if ($errors->hasBag($dataLaporanKegiatanTerbaru->id))
                                                        $('#modalTolakLaporan{{ $dataLaporanKegiatanTerbaru->id }}').modal('show');
                                                    @endif
                                                });
                                            </script>
                                        </div>
                                    </form>
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
            <div class="col-11 col-sm-7 col-md-8 col-lg-9 col-xl-10 colxxl-11 mx-auto p-2">
                <div class="bg-light card text-center rounded p-3">
                    <div class="row align-items-center justify-content-between mb-4">
                        <div class="row">
                            <div class="col text-center">
                                <h3 class="mb-0">Data Laporan Kegiatan Diterima</h3>
                            </div>
                            <div class="d-flex">
                                
                            </div>    
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table " style="width: 100%; ">
                            <thead>
                                <tr>
                                    <th scope="col">Status</th>
                                    <th scope="col">Tahun Kegiatan</th>
                                    <th scope="col">Nama Kegiatan</th>
                                    <th scope="col">Judul Laporan</th>
                                    <th scope="col">Nama Tim</th>
                                    <th scope="col">Informasi Kegiatan</th>
                                    <th scope="col">Lampiran</th>
                                    <th scope="col">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data_laporan_kegiatan_diterima as $dataLaporanKegiatanDiterima)
                                    <tr class="align-middle">
                                        @if($dataLaporanKegiatanDiterima->status_laporan == null)
                                            <td>-</td>
                                        @else
                                            <td>{{ $dataLaporanKegiatanDiterima->status_laporan }}</td>
                                        @endif
                                        <td>{{ $dataLaporanKegiatanDiterima->tahun_kegiatan->tahun }}</td>
                                        <td>{{ $dataLaporanKegiatanDiterima->tahun_kegiatan->nama }}</td>
                                        <td>{{ $dataLaporanKegiatanDiterima->judul_laporan }}</td>
                                        <td>{{ $dataLaporanKegiatanDiterima->nama_tim_kegiatan }}</td>
                                        <td><textarea disabled>{{ $dataLaporanKegiatanDiterima->informasi_kegiatan }}</textarea></td>
                                        <td role="button" data-bs-toggle="modal" data-bs-target="#modalLampiran{{ $dataLaporanKegiatanDiterima->id }}">{{ $dataLaporanKegiatanDiterima->lampiran }}</td>
                                        <td>
                                            <a href="{{ route('download.laporan_kegiatan', ['LaporanKegiatan' => $dataLaporanKegiatanDiterima]) }}" class="btn btn-primary" >Unduh</a>
                                        </td>
                                    </tr>
                                    {{-- Modal Detail Riwayat Peminjaman --}}
                                    <div class="modal fade" id="modalLampiran{{ $dataLaporanKegiatanDiterima->id }}">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content">
                                                <div class="card text-center">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item ">Judul Laporan : {{ File::size($dataLaporanKegiatanDiterima->lampiran) }}</li>
                                                        <li class="list-group-item ">Jumlah Supir : {{ File::name($dataLaporanKegiatanDiterima->lampiran) }}</li>
                                                        <li class="list-group-item ">Kendaraan : {{ File::extension($dataLaporanKegiatanDiterima->lampiran) }}</li>
                                                        <li class="list-group-item ">Jumlah Kendaraan : Test</li>
                                                        <li class="list-group-item ">Status : Test</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
            <div class="col-11 col-sm-7 col-md-8 col-lg-9 col-xl-10 colxxl-11 mx-auto p-2">
                <div class="bg-light card text-center rounded p-3">
                    <div class="row align-items-center justify-content-between mb-4">
                        <div class="row">
                            <div class="col text-center">
                                <h3 class="mb-0">Data Laporan Kegiatan Ditolak</h3>
                            </div>
                            <div class="d-flex">
                                
                            </div>    
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table" style="width: 100%; ">
                            <thead>
                                <tr>
                                    <th scope="col">Status</th>
                                    <th scope="col">Tahun Kegiatan</th>
                                    <th scope="col">Nama Kegiatan</th>
                                    <th scope="col">Judul Laporan</th>
                                    <th scope="col">Nama Tim</th>
                                    <th scope="col">Informasi Kegiatan</th>
                                    <th scope="col">Lampiran</th>
                                    <th scope="col">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data_laporan_kegiatan_ditolak as $dataLaporanKegiatanDitolak)
                                    <tr class="align-middle">
                                        @if($dataLaporanKegiatanDitolak->status_laporan == null)
                                            <td>-</td>
                                        @else
                                            <td>{{ $dataLaporanKegiatanDitolak->status_laporan }}</td>
                                        @endif
                                        <td>{{ $dataLaporanKegiatanDitolak->tahun_kegiatan->tahun }}</td>
                                        <td>{{ $dataLaporanKegiatanDitolak->tahun_kegiatan->nama }}</td>
                                        <td>{{ $dataLaporanKegiatanDitolak->judul_laporan }}</td>
                                        <td>{{ $dataLaporanKegiatanDitolak->nama_tim_kegiatan }}</td>
                                        <td><textarea disabled>{{ $dataLaporanKegiatanDitolak->informasi_kegiatan }}</textarea></td>
                                        <td>{{ $dataLaporanKegiatanDitolak->lampiran }}</td>
                                        <td>
                                            <a href="{{ route('download.laporan_kegiatan', ['LaporanKegiatan' => $dataLaporanKegiatanDitolak]) }}" class="btn btn-primary" >Unduh</a>
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