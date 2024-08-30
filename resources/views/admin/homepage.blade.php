<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | {{ Auth::user()->role }} | Homepage</title>

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
            <a class="navbar-brand" href="{{ route('admin.homepage') }}">Homepage</a>
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
                <div class="bg-light card text-center rounded p-3">
                    <div class="row align-items-center justify-content-between mb-4">
                        <div class="row">
                            <div class="col text-center">
                                <h3 class="mb-0">Data Tahun Kegiatan</h3>
                            </div>
                            <div class="d-flex">
                                
                            </div>    
                            <div class="col-7 col-md-4 col-xxl-2 mt-2">
                                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalTambahData">Tambah Data</button>
                            </div>
                            <form class="d-flex col-7 col-md-4 col-xxl-2 mt-2" role="search" action="{{ route('admin.search.data_tahun') }}" method="GET">
                                <input class="form-control w-100" name="keyword" id="search" type="search" value="{{ $keyword }}" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                    {{-- Modal Tambah Data --}}
                    <form action="{{ route('admin.create.data_tahun') }}" method="POST" class="form-card">
                        @csrf
                        <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content container-fluid p-0 container-md">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="modalTambahDataLabel">Tambah Data Tahun</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row justify-content-between text-left mb-2">
                                            <div class="col-sm-12 flex-column d-flex">
                                                <strong class="text-start"><label for="tahun_kegiatan" class="form-label">Tahun Kegiatan<span class="text-danger">*</span></label></strong>
                                                <input type="number" id="tahun_kegiatan" name="tahun_kegiatan" @if($errors->hasBag('tambah_data')) value="{{ old('tahun_kegiatan') }}" @endif min="1901" max="2099" step="1" value="{{ date("Y") }}" class="form-control @error('tahun_kegiatan', 'tambah_data') is-invalid @enderror" @required(true)>
                                                @error('tahun_kegiatan', 'tambah_data')
                                                    <div class="text-danger"><small>{{ $errors->tambah_data->first('tahun_kegiatan') }}</small></div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row justify-content-between text-left mb-2">
                                            <div class="col-sm-12 flex-column d-flex ">
                                                <strong class="text-start"><label for="nama_kegiatan" class="form-label">Nama Kegiatan<span class="text-danger">*</span></label></strong>
                                                <input type="text" id="nama_kegiatan" name="nama_kegiatan" @if($errors->hasBag('tambah_data')) value="{{ old('nama_kegiatan') }}" @endif maxlength="50" class="form-control @error('nama_kegiatan', 'tambah_data') is-invalid @enderror" @required(true)>
                                                @error('nama_kegiatan', 'tambah_data')
                                                    <div class="text-danger"><small>{{ $errors->tambah_data->first('nama_kegiatan') }}</small></div>
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
                    <div class="table-responsive">
                        <table class="table" style="width: 100%; ">
                            <thead>
                                <tr>
                                    <th scope="col">Tahun</th>
                                    <th scope="col">Kegiatan</th>
                                    <th scope="col" colspan="3">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data_tahun_kegiatan as $dataTahunKegiatan)
                                    <tr class="align-middle">
                                        <td>{{ $dataTahunKegiatan->tahun }}</td>
                                        <td>{{ $dataTahunKegiatan->nama }}</td>
                                        <td>
                                            <a href="{{ route('admin.show.data_tim', ['tahun' => $dataTahunKegiatan->tahun]) }}" class="btn btn-primary">Data Tim</a>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbahData{{ $dataTahunKegiatan->id }}">Ubah</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusData{{ $dataTahunKegiatan->id }}">Hapus</button>
                                        </td> 
                                    </tr>
                                    {{-- Modal Ubah Data --}}
                                    <form action="{{ route('admin.edit.data_tahun', ['TahunKegiatan' => $dataTahunKegiatan]) }}" method="POST" class="form-card">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal fade" id="modalUbahData{{ $dataTahunKegiatan->id }}" tabindex="-1" aria-labelledby="modalUbahDataLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content container-fluid p-0">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modalUbahDataLabel">Ubah Data Tahun Kegiatan</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row justify-content-between text-left mb-2">
                                                            <div class="col-sm-12 flex-column d-flex">
                                                                <strong class="text-start"><label for="tahun_kegiatan" class="form-label">Tahun Kegiatan<span class="text-danger">*</span></label></strong>
                                                                <input type="number" id="tahun_kegiatan" name="tahun_kegiatan" @if($errors->hasBag($dataTahunKegiatan->id)) value="{{ old('tahun_kegiatan') }}" @else value="{{ $dataTahunKegiatan->tahun }}" @endif min="1901" max="2099" step="1" class="form-control @error('tahun_kegiatan', $dataTahunKegiatan->id) is-invalid @enderror" @required(true)>
                                                                @error('tahun_kegiatan', $dataTahunKegiatan->id)
                                                                    <div class="text-danger text-start"><small>{{ $errors->{$dataTahunKegiatan->id}->first('tahun_kegiatan') }}</small></div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row justify-content-between text-left mb-2">
                                                            <div class="col-sm-12 flex-column d-flex ">
                                                                <strong class="text-start"><label for="nama_kegiatan" class="form-label">Nama Kegiatan<span class="text-danger">*</span></label></strong>
                                                                <input type="text" id="nama_kegiatan" name="nama_kegiatan" @if($errors->hasBag($dataTahunKegiatan->id)) value="{{ old('nama_kegiatan') }}" @else value="{{ $dataTahunKegiatan->nama }}" @endif min="" maxlength="50" class="form-control @error('nama_kegiatan', $dataTahunKegiatan->id) is-invalid @enderror" placeholder="" @required(true)>
                                                                @error('nama_kegiatan', $dataTahunKegiatan->id)
                                                                    <div class="text-danger text-start"><small>{{ $errors->{$dataTahunKegiatan->id}->first('nama_kegiatan') }}</small></div>
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
                                    {{-- Modal Konfirmasi Hapus Data --}}
                                    <div class="modal fade" id="modalHapusData{{ $dataTahunKegiatan->id }}" tabindex="-1" aria-labelledby="modalHapusDataLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modalHapusDataLabel">Hapus Data Tahun Kegiatan</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah anda yakin ingin menghapus data ini?<br>
                                                    <b>
                                                        Tahun : {{ $dataTahunKegiatan->tahun }}<br>
                                                        Kegiatan : {{ $dataTahunKegiatan->nama }}
                                                    </b>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('admin.delete.data_tahun', ['TahunKegiatan' => $dataTahunKegiatan]) }}" method="POST">
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if ($errors->hasBag('tambah_data'))
                $('#modalTambahData').modal('show');
            @endif
        });

        @foreach($data_tahun_kegiatan as $dataTahunKegiatan)
            document.addEventListener('DOMContentLoaded', function () {
                @if ($errors->hasBag($dataTahunKegiatan->id))
                    $("#modalUbahData{{ $dataTahunKegiatan->id }}").modal('show');
                @endif
            });
        @endforeach

    </script>
</body>
</html>