<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Admin | Data Tim Kegiatan</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
</head>
<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="text-center">Data Tim Kegiatan</h1><br>
          <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header align-content-center">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Tim Kegiatan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="{{ route('admin.dashboard') }}">Home</a>
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
            <div class="bg-light card text-center rounded p-3">
                <div class="row align-items-center justify-content-between mb-4">
                    <div class="col-12 col-md-8 col-xxl-10">
                        <h3 class="mb-0">Data Tim Kegiatan</h3>
                    </div>
                    <div class="col-7 col-md-4 col-xxl-2 mt-2">
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalTambahData">Tambah Data</button>
                    </div>
                </div>

                {{-- Modal Tambah Data --}}
                <form action="{{ route('admin.create.data_tim_kegiatan', ['tahun' => request('tahun')]) }}" method="POST" class="form-card">
                    @csrf
                    <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content container-fluid p-0 container-md">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modalTambahDataLabel">Tambah Data Tim Kegiatan</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row justify-content-between text-left mb-2">
                                        <div class="col-sm-12 flex-column d-flex">
                                            <label for="nama_tim" class="form-label">Nama Tim Kegiatan<span class="text-danger">*</span></label>
                                            <input type="text" id="nama_tim" name="nama_tim" @if($errors->hasBag('tambah_data')) value="{{ old('nama_tim') }}" @endif min="" max-length="25" value="" class="form-control @error('nama_tim', 'tambah_data') is-invalid @enderror" @required(true)>
                                            @error('nama_tim', 'tambah_data')
                                                <div class="text-danger"><small>{{ $errors->tambah_data->first('nama_tim') }}</small></div>
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
                                <th scope="col">Nama Tim</th>
                                <th scope="col">Jumlah Anggota</th>
                                <th scope="col">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data_tim_kegiatan as $dataTimKegiatan)
                                <tr class="align-middle">
                                    <td>{{ $dataTimKegiatan->nama }}</td>
                                    <td>
                                        @if($dataTimKegiatan->anggota_tim == null)
                                            -
                                        @else    
                                            {{ optional($dataTimKegiatan->anggota_tim)->count() }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.show.detail_tim_kegiatan', ['tahun' => request('tahun'), 'nama' => $dataTimKegiatan->nama]) }}" class="btn btn-primary">Detail</a> |
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbahData{{ $dataTimKegiatan->id }}">Ubah</button> |
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusData{{ $dataTimKegiatan->id }}">Hapus</button>
                                    </td>
                                </tr>

                                {{-- Modal Ubah Data --}}
                                <form action="{{ route('admin.edit.data_tim_kegiatan', ['TimKegiatan' => $dataTimKegiatan]) }}" method="POST" class="form-card">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal fade" id="modalUbahData{{ $dataTimKegiatan->id }}" tabindex="-1" aria-labelledby="modalUbahDataLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content container-fluid p-0">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalUbahDataLabel">Ubah Data Tim Kegiatan</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row justify-content-between text-left mb-2">
                                                        <div class="col-sm-12 flex-column d-flex">
                                                            <label for="nama_tim" class="form-label">Nama Tim Kegiatan<span class="text-danger">*</span></label>
                                                            <input type="text" id="nama_tim" name="nama_tim" @if($errors->hasBag($dataTimKegiatan->id)) value="{{ old('nama_tim') }}" @else value="{{ $dataTimKegiatan->nama }}" @endif min="" max-length="25" class="form-control @error('nama_tim', $dataTimKegiatan->id) is-invalid @enderror" @required(true)>
                                                            @error('nama_tim', $dataTimKegiatan->id)
                                                                <div class="text-danger"><small>{{ $errors->{$dataTimKegiatan->id}->first('nama_tim') }}</small></div>
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
                                                @if ($errors->hasBag($dataTimKegiatan->id))
                                                    $("#modalUbahData{{ $dataTimKegiatan->id }}").modal('show');
                                                @endif
                                            });
                                        </script>            
                                    </div>
                                </form>

                                {{-- Modal Konfirmasi Hapus Data --}}
                                <div class="modal fade" id="modalHapusData{{ $dataTimKegiatan->id }}" tabindex="-1" aria-labelledby="modalHapusDataLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="modalHapusDataLabel">Hapus Data Tim Kegiatan</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin ingin menghapus data ini?<br>
                                                <b>Nama Tim : {{ $dataTimKegiatan->nama }}</b>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.delete.data_tim_kegiatan', ['TimKegiatan' => $dataTimKegiatan]) }}" method="POST">
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
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
</body>
</html>