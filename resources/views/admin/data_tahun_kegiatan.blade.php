<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Admin | Data Tahun Kegiatan</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>
    <h1>Admin.</h1><br>
    <a href="{{ route('logout') }}">Logout</a><br>

    <h3>Data Tahun Kegiatan</h3>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahData">Tambah Data</button>

    {{-- Modal Tambah Data --}}
    <form action="{{ route('admin.create.data_tahun_kegiatan') }}" method="POST" class="form-card">
        @csrf
        <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahDataLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content container-fluid p-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="formPengajuanLabel">Tambah Data Tahun Kegiatan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <div class="row justify-content-between text-left mb-2">
                            <div class="col-sm-12 flex-column d-flex">
                                <label for="tahun_kegiatan" class="form-label">Tahun Kegiatan<span class="text-danger">*</span></label>
                                <input type="number" id="tahun_kegiatan" name="tahun_kegiatan" @if($errors->hasBag('tambah_data')) value="{{ old('tahun_kegiatan') }}" @endif min="1901" max="2099" step="1" value="{{ date("Y") }}" class="form-control @error('tahun_kegiatan', 'tambah_data') is-invalid @enderror" @required(true)>
                                @error('tahun_kegiatan', 'tambah_data')
                                    <div class="text-danger"><small>{{ $errors->tambah_data->first('tahun_kegiatan') }}</small></div>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-between text-left mb-2">
                            <div class="col-sm-12 flex-column d-flex ">
                                <label for="nama_kegiatan" class="form-label">Nama Kegiatan<span class="text-danger">*</span></label>
                                <input type="text" id="nama_kegiatan" name="nama_kegiatan" @if($errors->hasBag('tambah_kegiatan')) value="{{ old('nama_kegiatan') }}" @endif min="" max-length="50" class="form-control @error('nama_kegiatan', 'tambah_data') is-invalid @enderror" @required(true)>
                                @error('nama_kegiatan', 'tambah_kegiatan')
                                    <div class="text-danger"><small>{{ $errors->tambah_data->first('nama_kegiatan') }}</small></div>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-car-on me-1 car-icon"></i>Tambah</button>
                </div>
            </div>
            </div>
        </div>
    </form>


    <table>
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Nama Kegiatan</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data_tahun_kegiatan as $dataTahunKegiatan)
                <tr>
                    <td>{{ $dataTahunKegiatan->tahun }}</td>
                    <td>{{ $dataTahunKegiatan->nama }}</td>
                    <td>
                        <a href="{{ route('admin.show.data_tim_kegiatan', ['tahun' => $dataTahunKegiatan->tahun]) }}" class="btn btn-primary">Detail</a> |
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbahData{{ $dataTahunKegiatan->id }}">Ubah</button> |
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusData{{ $dataTahunKegiatan->id }}">Hapus</button>
                    </td>
                </tr>

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
                                <b>{{ $dataTahunKegiatan->tahun }} - {{ $dataTahunKegiatan->nama }}</b>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('admin.delete.data_tahun_kegiatan', ['TahunKegiatan' => $dataTahunKegiatan]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Ubah Data --}}
                <form action="{{ route('admin.edit.data_tahun_kegiatan', ['TahunKegiatan' => $dataTahunKegiatan]) }}" method="POST" class="form-card">
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
                                            <label for="tahun_kegiatan" class="form-label">Tahun Kegiatan<span class="text-danger">*</span></label>
                                            <input type="number" id="tahun_kegiatan" name="tahun_kegiatan" @if($errors->hasBag($dataTahunKegiatan->id)) value="{{ old('tahun_kegiatan') }}" @else value="{{ $dataTahunKegiatan->tahun }}" @endif min="1901" max="2099" step="1" class="form-control @error('tahun_kegiatan', $dataTahunKegiatan->id) is-invalid @enderror" @required(true)>
                                            @error('tahun_kegiatan', $dataTahunKegiatan->id)
                                                <div class="text-danger"><small>{{ $errors->{$dataTahunKegiatan->id}->first('tahun_kegiatan') }}</small></div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row justify-content-between text-left mb-2">
                                        <div class="col-sm-12 flex-column d-flex ">
                                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan<span class="text-danger">*</span></label>
                                            <input type="text" id="nama_kegiatan" name="nama_kegiatan" @if($errors->hasBag($dataTahunKegiatan->id)) value="{{ old('nama_kegiatan') }}" @else value="{{ $dataTahunKegiatan->nama }}" @endif min="" max-length="50" class="form-control @error('nama_kegiatan', $dataTahunKegiatan->id) is-invalid @enderror" placeholder="" @required(true)>
                                            @error('nama_kegiatan', $dataTahunKegiatan->id)
                                                <div class="text-danger"><small>{{ $errors->{$dataTahunKegiatan->id}->first('nama_kegiatan') }}</small></div>
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
            @empty
                <a>Data Kosong!</a>
            @endforelse
        </tbody>
    </table>
</body>
</html>