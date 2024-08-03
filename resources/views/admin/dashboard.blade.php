<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Admin | Dashboard</title>
</head>
<body>
    <h1>Dasboard Admin.</h1><br>
    <a href="{{ route('logout') }}">Logout</a><br>

    <h3>Tabel Tahun Kegiatan</h3>
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
                    <button><a href="">Detail</a></button> |
                    <button><a href="">Edit</a></button> |
                    <button><a href="">Hapus</a></button>
                </td>
            </tr>
            <tr>
                <td>2021</td>
                <td>Penelitian Gunung Jeruk</td>
                <td>
                    <button><a href="">Detail</a></button> |
                    <button><a href="">Edit</a></button> |
                    <button><a href="">Hapus</a></button>
                </td>
            </tr>
            <tr>
                <td>2022</td>
                <td>Penelitian Gunung Semangka</td>
                <td>
                    <button><a href="">Detail</a></button> |
                    <button><a href="">Edit</a></button> |
                    <button><a href="">Hapus</a></button>
                </td>
            </tr>
            <tr>
                <td>2023</td>
                <td>Penelitian Gunung Melon</td>
                <td>
                    <button><a href="">Detail</a></button> |
                    <button><a href="">Edit</a></button> |
                    <button><a href="">Hapus</a></button>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>