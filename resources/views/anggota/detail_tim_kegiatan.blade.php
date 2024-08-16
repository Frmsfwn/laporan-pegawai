<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Anggota | Detail Tim Kegiatan</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header align-content-center">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Detail Tim Kegiatan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('ketua.homepage') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                </li>
              </form>
            </div>
          </div>
        </div>
    </nav>

    <div class="container-fluid pt-4 px-4">
        <div class="col-12">
            <div class="bg-light card text-center rounded p-3 mb-3">
                <div class="row align-items-center justify-content-between mb-4">
                    <div class="col-12 col-xxl-10">
                        <h3 class="mb-0">Data Anggota Tim Kegiatan</h3>
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
        <div class="col-12">
            <div class="bg-light card text-center rounded p-3 mb-3">
                <div class="row align-items-center justify-content-between mb-4">
                    <div class="col-12 col-xxl-10">
                        <h3 class="mb-0">Data Laporan Kegiatan</h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Judul Laporan</th>
                                <th>Nama Tim Kegiatan</th>
                                <th>Informasi Kegiatan</th>
                                <th>Lampiran</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data_tim_kegiatan->laporan_kegiatan as $dataLaporanKegiatan)
                                <tr>
                                    <td>{{ $dataLaporanKegiatan->judul_laporan }}</td>
                                    <td>{{ $dataLaporanKegiatan->nama_tim_kegiatan }}</td>
                                    <td>{{ $dataLaporanKegiatan->informasi_kegiatan }}</td>
                                    <td>{{ $dataLaporanKegiatan->lampiran }}</td>
                                    <td>
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbahData{{ $data_tim_kegiatan->laporan_kegiatan->id }}">Ubah</button>
                                    </td>
                                </tr>
                                {{-- Modal Ubah Data --}}
                                <form action="{{ route('anggota.edit.laporan_kegiatan', ['LaporanKegiatan' => $data_tim_kegiatan->laporan_kegiatan]) }}" method="POST" enctype="multipart/form-data" class="form-card">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal fade" id="modalUbahData{{ $data_tim_kegiatan->laporan_kegiatan->id }}" tabindex="-1" aria-labelledby="modalUbahDataLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content container-fluid p-0">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalUbahDataLabel">Ubah Data Laporan Kegiatan</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row justify-content-between text-left mb-2">
                                                        <div class="col-sm-12 flex-column d-flex">
                                                            <label for="judul_laporan" class="form-label">Judul Laporan<span class="text-danger">*</span></label>
                                                            <input type="text" id="judul_laporan" name="judul_laporan" @if($errors->hasBag($data_tim_kegiatan->laporan_kegiatan->id)) value="{{ old('judul_laporan') }}" @else value="{{ $data_tim_kegiatan->laporan_kegiatan->judul_laporan }}" @endif min="" max-length="25" class="form-control @error('judul_laporan', $data_tim_kegiatan->laporan_kegiatan->id) is-invalid @enderror" @required(true)>
                                                            @error('judul_laporan', $data_tim_kegiatan->laporan_kegiatan->id)
                                                                <div class="text-danger"><small>{{ $errors->{$data_tim_kegiatan->laporan_kegiatan->id}->first('judul_laporan') }}</small></div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-between text-left mb-2">
                                                        <div class="col-sm-12 flex-column d-flex ">
                                                            <label for="informasi_kegiatan" class="form-label">Informasi Kegiatan<span class="text-danger">*</span></label>
                                                            <input type="text" id="informasi_kegiatan" name="informasi_kegiatan" @if($errors->hasBag($data_tim_kegiatan->laporan_kegiatan->id)) value="{{ old('informasi_kegiatan') }}" @else value="{{ $data_tim_kegiatan->laporan_kegiatan->informasi_kegiatan }}" @endif min="" max-length="25" class="form-control @error('informasi_kegiatan', $data_tim_kegiatan->laporan_kegiatan->id) is-invalid @enderror" placeholder="" @required(true)>
                                                            @error('informasi_kegiatan', $data_tim_kegiatan->laporan_kegiatan->id)
                                                                <div class="text-danger"><small>{{ $errors->{$data_tim_kegiatan->laporan_kegiatan->id}->first('informasi_kegiatan') }}</small></div>
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
                                                @if ($errors->hasBag($data_tim_kegiatan->laporan_kegiatan->id))
                                                    $("#modalUbahData{{ $data_tim_kegiatan->laporan_kegiatan->id }}").modal('show');
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
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
</body>
</html>