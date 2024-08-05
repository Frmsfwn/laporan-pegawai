<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Admin | Data Tahun Kegiatan</title>
</head>
<body>
    <h1>Admin.</h1><br>
    <a href="{{ route('logout') }}">Logout</a><br>

    <h3>Data Tahun Kegiatan</h3>
    <button><a href="">Tambah</a></button>
    <table>
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Nama Kegiatan</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2020</td>
                <td>Penelitian Gunung Kembar</td>
                <td>
                    <button><a href="{{ route('admin.show.data_tim_kegiatan', ['tahun' => '2020']) }}">Detail</a></button> |
                    <button><a href="{{ route('admin.edit.data_tahun_kegiatan', ['tahun' => '2020']) }}">Edit</a></button> |
                    <button><a href="{{ route('admin.delete.data_tahun_kegiatan', ['tahun' => '2020']) }}">Hapus</a></button>
                </td>
            </tr>
            <tr>
                <td>2021</td>
                <td>Penelitian Gunung Jeruk</td>
                <td>
                    <button><a href="{{ route('admin.show.data_tim_kegiatan', ['tahun' => '2021']) }}">Detail</a></button> |
                    <button><a href="{{ route('admin.edit.data_tahun_kegiatan', ['tahun' => '2021']) }}">Edit</a></button> |
                    <button><a href="{{ route('admin.delete.data_tahun_kegiatan', ['tahun' => '2021']) }}">Hapus</a></button>
                </td>
            </tr>
            <tr>
                <td>2022</td>
                <td>Penelitian Gunung Semangka</td>
                <td>
                    <button><a href="{{ route('admin.show.data_tim_kegiatan', ['tahun' => '2022']) }}">Detail</a></button> |
                    <button><a href="{{ route('admin.edit.data_tahun_kegiatan', ['tahun' => '2022']) }}">Edit</a></button> |
                    <button><a href="{{ route('admin.delete.data_tahun_kegiatan', ['tahun' => '2022']) }}">Hapus</a></button>
                </td>
            </tr>
            <tr>
                <td>2023</td>
                <td>Penelitian Gunung Melon</td>
                <td>
                    <button><a href="{{ route('admin.show.data_tim_kegiatan', ['tahun' => '2023']) }}">Detail</a></button> |
                    <button><a href="{{ route('admin.edit.data_tahun_kegiatan', ['tahun' => '2023']) }}">Edit</a></button> |
                    <button><a href="{{ route('admin.delete.data_tahun_kegiatan', ['tahun' => '2023']) }}">Hapus</a></button>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>