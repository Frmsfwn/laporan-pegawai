<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Admin | Data Anggota</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

    {{-- FontAwesome --}}
    <script src="https://kit.fontawesome.com/e814145206.js" crossorigin="anonymous"></script>

    {{-- Custom CSS --}}
    <style>
        .end-reveal {
            right: 1.3rem;
        }

        .top-reveal {
            top: 1.85rem;
        }
    </style>        

</head>
<body class="bg-body-secondary">
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-white shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.homepage') }}">Homepage</a>
                <ul class="navbar-nav me-auto flex-row">
                    <li class="nav-item me-2">
                        <a class="nav-link active pt-2 pb-1" aria-current="page" href="{{ route('admin.show.data_anggota', ['tahun' => request('tahun'), 'nama' => request('nama')]) }}">Data Anggota</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.show.data_laporan', ['tahun' => request('tahun'), 'nama' => request('nama')]) }}">Data Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.show.data_tim', ['tahun' => request('tahun')]) }}">Data Tim</a>
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
        </div>
    </nav>
    <main class="container-fluid ps-3 my-4">
        <section class="row g-2 justify-content-between">
            <button class="btn btn-primary mb-sm-3 ms-1 col-auto" data-bs-toggle="modal" data-bs-target="#modalTambahData"><i class="fa-solid fa-plus me-2"></i>Tambah Data</button>
            {{-- Modal Tambah Data --}}
            <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content container-fluid p-0 container-md">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalTambahDataLabel">Tambah Data Anggota Tim</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.create.data_anggota', ['tahun' => request('tahun'), 'nama' => request('nama')]) }}" method="POST" class="form-card">
                                @csrf
                                <div class="row justify-content-between text-left mb-2">
                                    <div class="col-sm-12 flex-column d-flex">
                                        <strong class="text-start"><label for="nip_anggota" class="form-label">NIP<span class="text-danger">*</span></label></strong>
                                        <input type="number" id="nip_anggota" name="nip_anggota" @if($errors->hasBag('tambah_data')) value="{{ old('nip_anggota') }}" @endif maxlength="25" class="form-control @error('nip_anggota', 'tambah_data') is-invalid @enderror" @required(true)>
                                        @error('nip_anggota', 'tambah_data')
                                            <div class="text-danger"><small>{{ $errors->tambah_data->first('nip_anggota') }}</small></div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 flex-column d-flex">
                                        <strong class="text-start"><label for="nama_anggota" class="form-label">Nama<span class="text-danger">*</span></label></strong>
                                        <input type="text" id="nama_anggota" name="nama_anggota" @if($errors->hasBag('tambah_data')) value="{{ old('nama_anggota') }}" @endif maxlength="25" class="form-control @error('nama_anggota', 'tambah_data') is-invalid @enderror" @required(true)>
                                        @error('nama_anggota', 'tambah_data')
                                            <div class="text-danger"><small>{{ $errors->tambah_data->first('nama_anggota') }}</small></div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 flex-column d-flex">
                                        <strong class="text-start"><label for="username_anggota" class="form-label">Username<span class="text-danger">*</span></label></strong>
                                        <input type="text" id="username_anggota" name="username_anggota" @if($errors->hasBag('tambah_data')) value="{{ old('username_anggota') }}" @endif maxlength="25" value="" class="form-control @error('username_anggota', 'tambah_data') is-invalid @enderror" @required(true)>
                                        @error('username_anggota', 'tambah_data')
                                            <div class="text-danger"><small>{{ $errors->tambah_data->first('username_anggota') }}</small></div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 flex-column d-flex">
                                        <strong class="text-start"><label for="password_anggota" class="form-label">Password<span class="text-danger">*</span></label></strong>
                                        <input type="password" id="password_anggota" name="password_anggota" minlength="8" maxlength="25" class="form-control @error('password_anggota', 'tambah_data') is-invalid @enderror" @required(true)>
                                        <span id="togglePassword" class="toggle-password-icon position-absolute end-0 top-50 translate-middle-y me-3" style="cursor: pointer;">
                                            <i class="fa-regular fa-eye fa-lg" id="reveal-password"></i>
                                        </span>                        
                                        @error('password_anggota', 'tambah_data')
                                            <div class="text-danger"><small>{{ $errors->tambah_data->first('password_anggota') }}</small></div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 flex-column d-flex">
                                        <strong class="text-start"><label for="role_anggota" class="form-label">Role<span class="text-danger">*</span></label></strong>
                                        <select id="role_anggota" name="role_anggota" class="form-select @error('role_anggota', 'tambah_data') is-invalid @enderror" @required(true)>
                                            @if($data_ketua_tim->isNotEmpty())
                                                <option value="Anggota" default selected>Anggota</option>
                                            @else
                                                <option value="Anggota" default selected>Anggota</option>
                                                <option value="Ketua" >Ketua</option>
                                            @endif
                                        </select>
                                        @error('role_anggota', 'tambah_data')
                                            <div class="text-danger text-start"><small>{{ $message }}</small></div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            @if ($errors->hasBag('tambah_data'))
                                $("#modalTambahData").modal('show');
                            @endif
                        });

                        $(document).ready(function() {
                            $('#togglePassword').on('click', function() {
                                let passwordField = $('#password');
                                let passwordFieldType = passwordField.attr('type');
                                
                                if (passwordFieldType === 'password') {
                                    passwordField.attr('type', 'text');
                                    $('#reveal-password').removeClass('fa-regular').addClass('fa-solid');
                                } else {
                                    passwordField.attr('type', 'password');
                                    $('#reveal-password').removeClass('fa-solid').addClass('fa-regular');
                                }
                            });

                            if($('.password').hasClass('is-invalid')) {
                                $('#togglePassword').removeClass('end-0 top-50').addClass('end-reveal top-reveal');
                            }
                        });
                    </script>            
                </div>
            </div>
            <form class="col-12 col-sm-auto" action="{{ route('admin.search.data_anggota', ['tahun' => request('tahun'), 'nama' => request('nama')]) }}" method="GET">
                <div class="input-group mb-3">
                    <button type="submit" class="input-group-text shadow-sm" for="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <input type="text" class="form-control shadow-sm" name="keyword" id="search" type="search" value="{{ $keyword }}" placeholder="Search" aria-label="Search">
                </div>
            </form>
        </section>
        <h2 class="m-auto text-black text-center mb-3">{{ $data_tim_kegiatan->nama }}/Anggota</h2>
        <section class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-6 g-3 mb-3">
            @forelse($data_anggota_tim as $dataAnggota)
            {{-- Card --}}
            <div class="col">
                <div class="card">
                    <div class="overflow-hidden rounded">
                        <ul class="list-group list-group-flush">                
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> Username</h4>
                                <h5 class="card-text fw-normal">{{ $dataAnggota->username }}</h5>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> NIP</h4>
                                <h5 class="card-text fw-normal">{{ $dataAnggota->nip }}</h5>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> Nama</h4>
                                <h5 class="card-text fw-normal">{{ $dataAnggota->nama }}</h5>
                            </li>
                            <li class="list-group-item">
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> Role</h4>
                                <h5 class="card-text fw-normal">{{ $dataAnggota->role }}</h5>
                            </li>
                            <li class="list-group-item ">
                                <div class="row g-2">
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbahData{{ $dataAnggota->id }}">Ubah</button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusData{{ $dataAnggota->id }}">Hapus</button>
                                </div>
                            </li>                                                
                        </ul>
                    </div>
                </div>
            </div>
            {{-- Modal Ubah Data --}}
            <div class="modal fade" id="modalUbahData{{ $dataAnggota->id }}" tabindex="-1" aria-labelledby="modalUbahDataLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content container-fluid p-0">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalUbahDataLabel">Ubah Data Anggota Tim</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.edit.data_anggota', ['AnggotaTim' => $dataAnggota]) }}" method="POST" class="form-card">
                                @csrf
                                @method('PUT')
                                <div class="row justify-content-between text-left mb-2">
                                    <div class="col-sm-12 flex-column d-flex">
                                        <strong class="text-start"><label for="nip_anggota" class="form-label">NIP<span class="text-danger">*</span></label></strong>
                                        <input type="text" id="nip_anggota" name="nip_anggota" @if($errors->hasBag($dataAnggota->id)) value="{{ old('nip_anggota') }}" @else value="{{ $dataAnggota->nip }}" @endif maxlength="25" class="form-control @error('nip_anggota', $dataAnggota->id) is-invalid @enderror" @required(true)>
                                        @error('nip_anggota', $dataAnggota->id)
                                            <div class="text-danger"><small>{{ $errors->{$dataAnggota->id}->first('nip_anggota') }}</small></div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 flex-column d-flex">
                                        <strong class="text-start"><label for="nama_anggota" class="form-label">Nama<span class="text-danger">*</span></label></strong>
                                        <input type="text" id="nama_anggota" name="nama_anggota" @if($errors->hasBag($dataAnggota->id)) value="{{ old('nama_anggota') }}" @else value="{{ $dataAnggota->nama }}" @endif maxlength="25" class="form-control @error('nama_anggota', $dataAnggota->id) is-invalid @enderror" @required(true)>
                                        @error('nama_anggota', $dataAnggota->id)
                                            <div class="text-danger"><small>{{ $errors->{$dataAnggota->id}->first('nama_anggota') }}</small></div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 flex-column d-flex">
                                        <strong class="text-start"><label for="username_anggota" class="form-label">Username<span class="text-danger">*</span></label></strong>
                                        <input type="text" id="username_anggota" name="username_anggota" @if($errors->hasBag($dataAnggota->id)) value="{{ old('username_anggota') }}" @else value="{{ $dataAnggota->username }}" @endif maxlength="25" class="form-control @error('username_anggota', $dataAnggota->id) is-invalid @enderror" @required(true)>
                                        @error('username_anggota', $dataAnggota->id)
                                            <div class="text-danger"><small>{{ $errors->{$dataAnggota->id}->first('username_anggota') }}</small></div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 flex-column d-flex">
                                        <strong class="text-start"><label for="password_anggota" class="form-label">Password<span class="text-danger">*</span></label></strong>
                                        <input type="password" id="password_anggota" name="password_anggota" minlength="8" maxlength="25" class="form-control @error('password_anggota', $dataAnggota->id) is-invalid @enderror" @required(true)>
                                        @error('password_anggota', $dataAnggota->id)
                                            <div class="text-danger"><small>{{ $errors->{$dataAnggota->id}->first('password_anggota') }}</small></div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 flex-column d-flex">
                                        <strong class="text-start"><label for="role_anggota" class="form-label">Role<span class="text-danger">*</span></label></strong>
                                        <select id="role_anggota" name="role_anggota" class="form-select @error('role_anggota', $dataAnggota->id) is-invalid @enderror" @required(true)>
                                            @if($errors->hasBag($dataAnggota->id))
                                                <option value="{{ old('role_anggota') }}" selected hidden>{{ old('role_anggota') }}</option>
                                            @else
                                                <option value="{{ $dataAnggota->role }}" selected hidden>{{ $dataAnggota->role }}</option>
                                            @endif
                                            @if($data_ketua_tim->isNotEmpty())
                                                <option value="Anggota">Anggota</option>
                                            @else
                                                <option value="Anggota">Anggota</option>
                                                <option value="Ketua" >Ketua</option>
                                            @endif
                                        </select>
                                        @error('role_anggota', $dataAnggota->id)
                                            <div class="text-danger text-start"><small>{{ $message }}</small></div>
                                        @enderror
                                    </div>                
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Ubah</button>
                                </div>
                            </form>
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
            </div>

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
                            <b>{{ $dataAnggota->nama }}(NIP:{{ $dataAnggota->nip }})</b>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('admin.delete.data_anggota', ['AnggotaTim' => $dataAnggota]) }}" method="POST">
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
                <h3 class="m-auto text-secondary opacity-75 text-center mt-3">Data Kosong</h3>
            @endforelse
        </section>
        <h2 class="m-auto text-black text-center mb-3">Data Laporan Tim Kegiatan</h2>
        <section class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-6 g-3 mb-3">
            @forelse ($data_tim_kegiatan->laporan_kegiatan->sortBy('created_at') as $dataLaporanKegiatan)
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
                                <h4 class="card-title link-underline-dark link-offset-3 text-decoration-underline fw-bold"> Nama Tim Kegiatan</h4>
                                <h5 class="card-text fw-normal">{{ $dataLaporanKegiatan->nama_tim_kegiatan }}</h5>
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
    {{-- Script Modal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if ($errors->hasBag('tambah_data'))
                $('#modalTambahData').modal('show');
            @endif
        });
    </script>
</body>
</html>