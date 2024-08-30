<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Ketua | Detail Tim Kegiatan</title>

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
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha506-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    {{-- FontAwesome --}}
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>

</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <ul class="breadcrumb align-items-center my-2" style="--bs-breadcrumb-divider: '>';">
                <a class="breadcrumb-item text-black text-decoration-none" href="{{ route('ketua.homepage') }}">Homepage</a>
                <a class="breadcrumb-item active" aria-current="page" href="{{ route('ketua.show.detail_tim_kegiatan', ['tahun' => request('tahun'), 'nama' => request('nama')]) }}">Detail Tim Kegiatan</a>
            </ul>
            <div class="w-s-100 text-end">
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
                        @forelse(Auth::user()->notifikasi->slice(0, 3) as $notification)
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
                <div class="nav-item dropdown nav-link">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->username }}</a>
                    <ul class="dropdown-menu dropdown-menu-end bg-light border-1 rounded-2 m-0">
                        <li><a class="dropdown-item" href="{{ route('edit.password') }}"><i class="fa-solid fa-key"></i> Ubah Password</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-11 col-sm-7 col-md-8 col-lg-9 col-xl-10 colxxl-11 mx-auto p-2">
                <div class="bg-light card text-center rounded p-3">
                    <div class="row align-items-center justify-content-between mb-4">
                        <div class="row">
                            <div class="col text-center">
                                <h3 class="mb-0">Data Anggota Tim Kegiatan</h3>
                            </div>
                            <div class="d-flex">
                                
                            </div>    
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data_tim_kegiatan->anggota_tim as $dataAnggotaTim)
                                    @foreach($dataAnggotaTim->user as $dataAnggota)
                                        <tr>
                                            <td>{{ $dataAnggota->nip }}</td>
                                            <td>{{ $dataAnggota->nama }}</td>
                                            <td>{{ $dataAnggota->username }}</td>
                                            <td>{{ $dataAnggota->role }}</td>
                                        </tr>
                                    @endforeach
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
                                <h3 class="mb-0">Data Laporan Tim Kegiatan</h3>
                            </div>
                            <div class="d-flex">
                                
                            </div>
                            <div class="col-7 col-md-4 col-xxl-2 mt-2">
                                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalTambahData">Tambah Data</button>
                            </div>  
                        </div>
                    </div>
                    {{-- Modal Tambah Data --}}
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
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    @if ($errors->hasBag('tambah_data'))
                                        $('#modalTambahData').modal('show');
                                    @endif
                                });
                            </script>
                        </div>
                    </form>    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Judul Laporan</th>
                                    <th>Nama Tim Kegiatan</th>
                                    <th>Informasi Kegiatan</th>
                                    <th>Lampiran</th>
                                    <th></th>
                                    <th>Opsi</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_tim_kegiatan->laporan_kegiatan->sortBy('created_at') as $dataLaporanKegiatan)
                                    <tr>
                                        <td>
                                            @if($dataLaporanKegiatan->status_laporan == null)
                                                -
                                            @else
                                                {{ $dataLaporanKegiatan->status_laporan }}
                                            @endif
                                        </td>
                                        <td>{{ $dataLaporanKegiatan->judul_laporan }}</td>
                                        <td>{{ $dataLaporanKegiatan->nama_tim_kegiatan }}</td>
                                        <td><textarea disabled>{{ $dataLaporanKegiatan->informasi_kegiatan }}</textarea></td>
                                        <td>{{ $dataLaporanKegiatan->lampiran }}</td>
                                        <td>
                                            <a href="{{ route('download.laporan_kegiatan', ['LaporanKegiatan' => $dataLaporanKegiatan]) }}" class="btn btn-primary">Unduh</a> 
                                        </td>
                                        <td>
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbahData{{ $dataLaporanKegiatan->id }}">Ubah</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusData{{ $dataLaporanKegiatan->id }}">Hapus</button>
                                        </td>
                                    </tr>
                                    {{-- Modal Ubah Data --}}
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
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    @if ($errors->hasBag($dataLaporanKegiatan->id))
                                                        $("#modalUbahData{{ $dataLaporanKegiatan->id }}").modal('show');
                                                    @endif
                                                });
                                            </script>            
                                        </div>
                                    </form>
                                    {{-- Modal Konfirmasi Hapus Data --}}
                                    <div class="modal fade" id="modalHapusData{{ $dataLaporanKegiatan->id }}" tabindex="-1" aria-labelledby="modalHapusDataLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalHapusDataLabel">Hapus Data Laporan Kegiatan</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
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