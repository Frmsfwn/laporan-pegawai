<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Admin | Detail Tim Kegiatan</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="text-center">Detail Tim Kegiatan</h1><br>
          <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header align-content-center">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Tim Kegiatan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('admin.dashboard') }}">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('admin.show.data_tahun_kegiatan') }}">Data Tahun Kegiatan</a>
                </li>
                <a class="nav-link" href="{{ route('logout') }}">Logout</a>
              </form>
            </div>
          </div>
        </div>
    </nav>

    <div class="container-fluid pt-4 px-4">
        <div class="col-12">
            <div class="bg-light card text-center rounded p-3 mb-3">
                <div class="row align-items-center justify-content-between mb-4">
                    <div class="col-12 col-md-8 col-xxl-10">
                        <h3 class="mb-0">Data Anggota Tim Kegiatan</h3>
                    </div>
                    <div class="col-7 col-md-4 col-xxl-2 mt-2">
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalTambahData">Tambah Data</button>
                    </div>
                </div>
                {{-- Modal Tambah Data --}}
                <form action="{{ route('admin.create.anggota_tim', ['tahun' => request('tahun'), 'nama' => request('nama')]) }}" method="POST" class="form-card">
                    @csrf
                    <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content container-fluid p-0 container-md">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modalTambahDataLabel">Tambah Data Anggota Tim</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row justify-content-between text-left mb-2">
                                        <div class="col-sm-12 flex-column d-flex">
                                            <label for="nip_anggota" class="form-label">NIP<span class="text-danger">*</span></label>
                                            <input type="text" id="nip_anggota" name="nip_anggota" @if($errors->hasBag('tambah_data')) value="{{ old('nip_anggota') }}" @endif min="" max-length="25" value="" class="form-control @error('nip_anggota', 'tambah_data') is-invalid @enderror" @required(true)>
                                            @error('nip_anggota', 'tambah_data')
                                                <div class="text-danger"><small>{{ $errors->tambah_data->first('nip_anggota') }}</small></div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 flex-column d-flex">
                                            <label for="nama_anggota" class="form-label">Nama<span class="text-danger">*</span></label>
                                            <input type="text" id="nama_anggota" name="nama_anggota" @if($errors->hasBag('tambah_data')) value="{{ old('nama_anggota') }}" @endif min="" max-length="25" value="" class="form-control @error('nama_anggota', 'tambah_data') is-invalid @enderror" @required(true)>
                                            @error('nama_anggota', 'tambah_data')
                                                <div class="text-danger"><small>{{ $errors->tambah_data->first('nama_anggota') }}</small></div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 flex-column d-flex">
                                            <label for="username_anggota" class="form-label">Username<span class="text-danger">*</span></label>
                                            <input type="text" id="username_anggota" name="username_anggota" @if($errors->hasBag('tambah_data')) value="{{ old('username_anggota') }}" @endif min="" max-length="25" value="" class="form-control @error('username_anggota', 'tambah_data') is-invalid @enderror" @required(true)>
                                            @error('username_anggota', 'tambah_data')
                                                <div class="text-danger"><small>{{ $errors->tambah_data->first('username_anggota') }}</small></div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 flex-column d-flex">
                                            <label for="password_anggota" class="form-label">Password<span class="text-danger">*</span></label>
                                            <input type="password" id="password_anggota" name="password_anggota" @if($errors->hasBag('tambah_data')) value="{{ old('password_anggota') }}" @endif min="" max-length="25" value="" class="form-control @error('password_anggota', 'tambah_data') is-invalid @enderror" @required(true)>
                                            @error('password_anggota', 'tambah_data')
                                                <div class="text-danger"><small>{{ $errors->tambah_data->first('password_anggota') }}</small></div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12 flex-column d-flex">
                                            <label for="role_anggota" class="form-label">Role<span class="text-danger">*</span></label>
                                            <select id="role_anggota" name="role_anggota" class="form-select @error('role_anggota', 'tambah_data') is-invalid @enderror" @required(true)>
                                                <option value="Anggota" default selected>Anggota</option>
                                                <option value="Ketua" >Ketua</option>
                                            </select>
                                            @error('role_anggota', 'tambah_data')
                                                <div class="text-danger text-start"><small>{{ $message }}</small></div>
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
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Opsi</th>
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
                                        <td>
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbahData{{ $dataAnggota->id }}">Ubah</button> |
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusData{{ $dataAnggota->id }}">Hapus</button>
                                        </td>
                                    </tr>
                                    {{-- Modal Ubah Data --}}
                                    <form action="{{ route('admin.edit.data_anggota_tim', ['AnggotaTim' => $dataAnggota]) }}" method="POST" class="form-card">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal fade" id="modalUbahData{{ $dataAnggota->id }}" tabindex="-1" aria-labelledby="modalUbahDataLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content container-fluid p-0">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modalUbahDataLabel">Ubah Data Anggota Tim</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row justify-content-between text-left mb-2">
                                                            <div class="col-sm-12 flex-column d-flex">
                                                                <label for="nip_anggota" class="form-label">NIP<span class="text-danger">*</span></label>
                                                                <input type="text" id="nip_anggota" name="nip_anggota" @if($errors->hasBag($dataAnggota->id)) value="{{ old('nip_anggota') }}" @else value="{{ $dataAnggota->nip }}" @endif min="" max-length="25" value="" class="form-control @error('nip_anggota', $dataAnggota->id) is-invalid @enderror" @required(true)>
                                                                @error('nip_anggota', $dataAnggota->id)
                                                                    <div class="text-danger"><small>{{ $errors->{$dataAnggota->id}->first('nip_anggota') }}</small></div>
                                                                @enderror
                                                            </div>
                                                            <div class="col-sm-12 flex-column d-flex">
                                                                <label for="nama_anggota" class="form-label">Nama<span class="text-danger">*</span></label>
                                                                <input type="text" id="nama_anggota" name="nama_anggota" @if($errors->hasBag($dataAnggota->id)) value="{{ old('nama_anggota') }}" @else value="{{ $dataAnggota->nama }}" @endif min="" max-length="25" value="" class="form-control @error('nama_anggota', $dataAnggota->id) is-invalid @enderror" @required(true)>
                                                                @error('nama_anggota', $dataAnggota->id)
                                                                    <div class="text-danger"><small>{{ $errors->{$dataAnggota->id}->first('nama_anggota') }}</small></div>
                                                                @enderror
                                                            </div>
                                                            <div class="col-sm-12 flex-column d-flex">
                                                                <label for="username_anggota" class="form-label">Username<span class="text-danger">*</span></label>
                                                                <input type="text" id="username_anggota" name="username_anggota" @if($errors->hasBag($dataAnggota->id)) value="{{ old('username_anggota') }}" @else value="{{ $dataAnggota->username }}" @endif min="" max-length="25" value="" class="form-control @error('username_anggota', $dataAnggota->id) is-invalid @enderror" @required(true)>
                                                                @error('username_anggota', $dataAnggota->id)
                                                                    <div class="text-danger"><small>{{ $errors->{$dataAnggota->id}->first('username_anggota') }}</small></div>
                                                                @enderror
                                                            </div>
                                                            <div class="col-sm-12 flex-column d-flex">
                                                                <label for="password_anggota" class="form-label">Password<span class="text-danger">*</span></label>
                                                                <input type="password" id="password_anggota" name="password_anggota" @if($errors->hasBag($dataAnggota->id)) value="{{ old('password_anggota') }}" @endif min="" max-length="25" value="" class="form-control @error('password_anggota', $dataAnggota->id) is-invalid @enderror" @required(true)>
                                                                @error('password_anggota', $dataAnggota->id)
                                                                    <div class="text-danger"><small>{{ $errors->{$dataAnggota->id}->first('password_anggota') }}</small></div>
                                                                @enderror
                                                            </div>
                                                            <div class="col-sm-12 flex-column d-flex">
                                                                <label for="role_anggota" class="form-label">Role<span class="text-danger">*</span></label>
                                                                <select id="role_anggota" name="role_anggota" class="form-select @error('role_anggota', $dataAnggota->id) is-invalid @enderror" @required(true)>
                                                                    @if($errors->hasBag($dataAnggota->id))
                                                                        <option value="{{ old('role_anggota') }}" selected hidden>{{ old('role_anggota') }}</option>
                                                                    @else
                                                                        <option value="{{ $dataAnggota->role }}" selected hidden>{{ $dataAnggota->role }}</option>
                                                                    @endif
                                                                    <option value="Anggota">Anggota</option>
                                                                    <option value="Ketua" >Ketua</option>
                                                                </select>
                                                                @error('role_anggota', $dataAnggota->id)
                                                                    <div class="text-danger text-start"><small>{{ $message }}</small></div>
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
                                                    @if ($errors->hasBag($dataAnggota->id))
                                                        $("#modalUbahData{{ $dataAnggota->id }}").modal('show');
                                                    @endif
                                                });
                                            </script>            
                                        </div>
                                    </form>
                                    {{-- Modal Konfirmasi Hapus Data --}}
                                    <div class="modal fade" id="modalHapusData{{ $dataAnggota->id }}" tabindex="-1" aria-labelledby="modalHapusDataLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalHapusDataLabel">Hapus Data Anggota Tim</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus data ini?<br>
                                                    <b>NIP : {{ $dataAnggota->nip }} | Nama : {{ $dataAnggota->nama }}</b>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('admin.delete.data_anggota_tim', ['AnggotaTim' => $dataAnggota]) }}" method="POST">
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
            <div class="bg-light card text-center rounded p-3">
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
                                        <a href="{{ route('download.laporan_kegiatan', ['LaporanKegiatan' => $dataLaporanKegiatan]) }}" class="btn btn-primary" >Download</a>
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
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
</body>
</html>