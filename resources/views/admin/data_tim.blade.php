<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Admin | Data Tim</title>
</head>
<body>
    <h1>Data Tim Kegiatan.</h1>
    
    <table>
        <thead>
            <tr>
                <th>Nama Tim</th>
                <th>Jumlah Anggota</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tim Satu</td>
                <td>10</td>
                <td>
                    <button><a href="">Detail</a></button> |
                    <button><a href="">Edit</a></button> |
                    <button><a href="">Hapus</a></button>
                </td>
            </tr>
            <tr>
                <td>Tim Dua</td>
                <td>20</td>
                <td>
                    <button><a href="">Detail</a></button> |
                    <button><a href="">Edit</a></button> |
                    <button><a href="">Hapus</a></button>
                </td>
            </tr>
            <tr>
                <td>Tim Tiga</td>
                <td>30</td>
                <td>
                    <button><a href="">Detail</a></button> |
                    <button><a href="">Edit</a></button> |
                    <button><a href="">Hapus</a></button>
                </td>
            </tr>
            <tr>
                <td>Tim Empat</td>
                <td>40</td>
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