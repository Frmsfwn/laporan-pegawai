<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Anggota Tim | Homepage</title>

    {{-- Bootstrap --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>
    <h1>Homepage Anggota Tim.</h1><br>
    <a href="{{ route('logout') }}">Logout</a>
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
                <tr class="align-middle">
                    <td>{{ $data_tim_kegiatan->nama }}</td>
                    <td>{{ $data_tim_kegiatan->anggota_tim->count() }}</td>
                    <td>
                        <a href="{{ route('anggota.show.detail_tim_kegiatan', ['tahun' => $data_tim_kegiatan->tahun_kegiatan->tahun, 'nama' => $data_tim_kegiatan->nama]) }}" class="btn btn-primary">Detail</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
</body>
</html>